<?php
namespace App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require __DIR__ . '/vendor/autoload.php';

class Chat implements MessageComponentInterface {
    public function onOpen(ConnectionInterface $conn) {
    }

    public function onMessage(ConnectionInterface $from, $msg) {
    }

    public function onClose(ConnectionInterface $conn) {
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
    }
}