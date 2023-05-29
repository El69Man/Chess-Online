<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use MyApp\Chat;

require __DIR__ . '/vendor/autoload.php';

class ChessGame {
    public $board;
    public $players;
    public $turn;

    public function __construct() {
        $this->board = new Chess();
        $this->players = [];
        $this->turn = 'w'; // Empieza el jugador blanco
    }

    public function addPlayer($conn) {
        if (count($this->players) < 2) {
            $this->players[] = $conn;
            return true;
        }
        return false;
    }

    public function isPlayerTurn($conn) {
        $index = array_search($conn, $this->players);
        return $index !== false && $this->turn === ($index === 0 ? 'w' : 'b');
    }

    public function makeMove($conn, $move) {
        if (!$this->isPlayerTurn($conn)) {
            return false;
        }

        // Aquí deberás utilizar la librería Chess.js para aplicar el movimiento en el tablero
        // Puedes acceder al tablero con $this->board

        // Por ejemplo:
        // $this->board->move($move);

        // Luego, actualiza el turno al siguiente jugador
        $this->turn = $this->turn === 'w' ? 'b' : 'w';

        return true;
    }
}

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $ports;
    protected $currentPort;
    protected $maxUsers;
    protected $games;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->ports = [];
        $this->games = [];
        $this->currentPort = 8080;
        $this->maxUsers = 2;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Verificar si el puerto actual alcanzó el límite de usuarios
        if ($this->getUserCount($this->currentPort) >= $this->maxUsers) {
            // Encontrar el siguiente puerto disponible
            $nextPort = $this->findNextAvailablePort();

            if ($nextPort === null) {
                // No se encontró un puerto disponible, cerrar la conexión
                $conn->close();
                return;
            }

            $this->currentPort = $nextPort;
        }

        // Almacenar el puerto utilizado para esta conexión
        $this->ports[$conn->resourceId] = $this->currentPort;

        // Almacenar la nueva conexión para enviar mensajes más tarde
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );

        // Obtener el juego al que pertenece la conexión
        $game = $this->getGameByPlayer($from);

        if ($game && $game->isPlayerTurn($from)) {
            // Aplicar el movimiento en el juego
            $move = json_decode($msg, true);
            $game->makeMove($from, $move);

            // Enviar el movimiento a todos los jugadores en el juego
            foreach ($game->players as $player) {
                $player->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // Eliminar la conexión y el puerto asociado
        unset($this->ports[$conn->resourceId]);
        $this->clients->detach($conn);

        $game = $this->getGameByPlayer($conn);
        if ($game) {
            unset($this->games[$game]);
        }

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    private function getGameByPlayer($player) {
        foreach ($this->games as $game) {
            if (in_array($player, $game->players)) {
                return $game;
            }
        }
        return null;
    }

    private function createGame() {
        $game = new ChessGame();
        $this->games[] = $game;
        return $game;
    }

    private function findNextAvailablePort() {
        $nextPort = $this->currentPort + 1;

        while ($nextPort < 65535) { // 65535 es el número máximo de puertos
            if ($this->getUserCount($nextPort) < $this->maxUsers) {
                return $nextPort;
            }

            $nextPort++;
        }

        return null; // No se encontró un puerto disponible
    }

    private function getUserCount($port) {
        $userCount = 0;

        foreach ($this->ports as $connPort) {
            if ($connPort === $port) {
                $userCount++;
            }
        }

        return $userCount;
    }
}
?>