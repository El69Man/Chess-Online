<?php

require 'vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class MyWebSocketServer implements MessageComponentInterface {

    protected $clients;
    protected $groupCounter;
    protected $currentPort;
    protected $clientStates;

    public function __construct() {
        $this->clients = new \SplObjectStorage();
        $this->groupCounter = 0;
        $this->currentPort = 8080;
        $this->clientCount = 0;
        $this->clientStates = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        $this->clientCount++;
        $this->clientStates[$conn->resourceId] = true; // Establecer el estado del cliente como activo
        echo "Nuevo cliente conectado: " . $conn->resourceId . "\n";

        // Verificar si el cliente recién conectado es el segundo en el grupo actual
        if (count($this->clientStates) % 2 === 0) {
            $this->groupCounter++;
            $this->currentPort++;
        }
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "Mensaje recibido de cliente " . $from->resourceId . ": " . $msg . "\n";

        // Enviar una respuesta al cliente
        $response = "Hola, cliente " . $from->resourceId . "! He recibido tu mensaje: " . $msg;
        $from->send($response);
        $test = "Usuarios conectados:" +$this->clientCount;
        $from->send($test);
        // Enviar una respuesta a todos los conectados
        $this->broadcastMessage($msg);
    }

    public function onClose(ConnectionInterface $conn) {
        unset($this->clientStates[$conn->resourceId]); // Establecer el estado del cliente como inactivo
        $this->clients->detach($conn);
        echo "Cliente desconectado: " . $conn->resourceId . "\n";

        // Verificar si el cliente desconectado es el segundo en el grupo actual
        if (count($this->clientStates) % 2 === 1) {
            $this->groupCounter++;
            $this->currentPort++;
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        // Lógica para manejar errores
    }

    public function broadcastMessage($message) {
        foreach ($this->clients as $client) {
            $client->send($message);
        }
    }
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new MyWebSocketServer()
        )
    ),
    8080
);
header("Location: index.html");
$server->run();

?>