<?php
use Ratchet\Server\IoServer;
use MyApp\Chat;

    require __DIR__ . '/vendor/autoload.php';

    $server = IoServer::factory(
        new Chat(),
        8080
    );

    $server->run();