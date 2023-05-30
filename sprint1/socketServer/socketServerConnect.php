<?php
use Ratchet\Server\IoServer;

$server = IoServer::factory(
    new ChessServer(),
    8080 // Port number to listen on
);

$server->run();
?>