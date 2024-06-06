<?php
require 'vendor/autoload.php';

use React\EventLoop\Factory;
use Ratchet\Client\Connector;
use React\Socket\Connector as ReactConnector;

$loop = Factory::create();
$reactConnector = new ReactConnector($loop);

$data = [
    "contacts" => [
        [
            "profile" => [
                "name" => "John Doe"
            ],
            "wa_id" => "1234567890"
        ]
    ],
    "messages" => [
        [
            "from" => "1234567890",
            "id" => "ABCD1234",
            "timestamp" => "1607111234",
            "text" => [
                "body" => "Hello, this is a test message"
            ],
            "type" => "text"
        ]
    ]
];

$connector = new Connector($loop, $reactConnector);
$connector('ws://localhost:8080')
    ->then(function($conn) use ($data, $loop) {
        echo "Connected to WebSocket server\n";
        $conn->send(json_encode($data));
        echo "Message sent: " . json_encode($data) . "\n";
        
        // Keep the connection open for a short while to ensure message reception
        $loop->addTimer(1, function() use ($conn, $loop) {
            $conn->close();
            $loop->stop();
        });
    }, function ($e) use ($loop) {
        echo "Could not connect: {$e->getMessage()}\n";
        $loop->stop();
    });

$loop->run();

echo json_encode(['status' => 'success']);
?>
