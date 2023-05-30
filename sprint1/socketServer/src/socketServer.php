<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class ChessServer implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to keep track of connected clients
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    // Implement the other methods of MessageComponentInterface:
    // onMessage, onClose, onError

    public function onMessage(ConnectionInterface $from, $msg) {
        // Parse the move data from JSON
        $moveData = json_decode($msg, true);
    
        // Process the move and update the game state on the server
    
        // Broadcast the move to other players
        foreach ($this->clients as $client) {
            if ($client !== $from) {
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
}
?>