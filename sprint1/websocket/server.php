<?php

require 'vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class MyWebSocketServer implements MessageComponentInterface {

    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Nuevo cliente conectado: " . $conn->resourceId . "\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "Mensaje recibido de cliente " . $from->resourceId . ": " . $msg . "\n";

        // Enviar una respuesta al cliente
        $response = "Hola, cliente " . $from->resourceId . "! He recibido tu mensaje: " . $msg;
        $from->send($response);

        //Enviar una respuesta a todos los conectados
        $this->broadcastMessage($msg);
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Cliente desconectado: " . $conn->resourceId . "\n";
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
                ), 8080
);

$server->run();
?>
