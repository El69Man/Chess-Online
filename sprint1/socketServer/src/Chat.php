<?php
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
}
?>