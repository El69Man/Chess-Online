<?php
require 'vendor/autoload.php';
require_once 'session_manager.php';


use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class ChessServer implements MessageComponentInterface {
    protected $clients = [];
    protected $ports = [];
    protected $currentPort = 8090;
    // Create the WebSocket application
   // const $webSocketApp = new ChessServer();

    public function onOpen(ConnectionInterface $conn) {
        echo "New connection! ({$conn->resourceId})\n";

        // Assign a port to the client
        $port = $this->getAvailablePort();
        $this->clients[$conn->resourceId] = $port;
        $this->ports[$port] = $conn;
        
        // Send the assigned port to the client
        $conn->send($port);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "Received message from client ({$from->resourceId}): $msg\n";

        // Process the message as needed
        
        // Example: Send a message back to the client
        $from->send('Server received your message');
    }

    /*$webSocketApp->onMessage = function ($connection, $message) {
    $messageData = json_decode($message, true);
    
    // Add the tab_id to the message payload
    $messageData['tab_id'] = $_SESSION['tab_id'];

    // Process the message and send the response back to the client
    // ...
    
    $response = json_encode($messageData);
    $connection->send($response);
    };*/

    public function onClose(ConnectionInterface $conn) {
        echo "Connection {$conn->resourceId} has disconnected\n";

        // Remove the client and its assigned port
        $port = $this->clients[$conn->resourceId];
        unset($this->clients[$conn->resourceId]);
        unset($this->ports[$port]);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    protected function getAvailablePort() {
        while (isset($this->ports[$this->currentPort])) {
            $this->currentPort++;
        }
        return $this->currentPort;
    }
}

// Create your WebSocket application
//$webSocketApp = new HttpServer(new WsServer(new ChessServer()));

// Create the server
//$server = IoServer::factory($webSocketApp, 8090);

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChessServer()
        )
    ),
    8090
);

echo "Server listening on port 8090\n";

$server->run();
?>