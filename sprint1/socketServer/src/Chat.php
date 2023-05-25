<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $ports;
    protected $currentPort;
    protected $maxUsers;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->ports = [];
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

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // Enviar el mensaje a cada cliente conectado (excepto al remitente)
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // Eliminar la conexión y el puerto asociado
        unset($this->ports[$conn->resourceId]);
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
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
/*
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $playerCount;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->playerCount = 0;
    }

    public function onOpen(ConnectionInterface $conn) {
        if ($this->playerCount >= 2) {
            // Reject the connection if the maximum player count has been reached
            $conn->close();
            return;
        }

        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        $this->playerCount++;

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // Remove the connection and decrement the player count
        $this->clients->detach($conn);
        $this->playerCount--;

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}*/
?>