<?php

require 'vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

// Create your WebSocket application
$webSocketApp = new YourWebSocketApp();

$server = IoServer::factory(
    new HttpServer(
        new WsServer($webSocketApp)
    ),
    8080 // Port number to listen on
);

$server->run();