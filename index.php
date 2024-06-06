<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Client</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="messages"></div>

    <script>
        $(document).ready(function() {
            const socket = new WebSocket('ws://localhost:8080');

            socket.onopen = function(event) {
                console.log('WebSocket connection established');
            };

            socket.onmessage = function(event) {
                console.log('Raw message received:', event.data); // Log raw data
                const data = JSON.parse(event.data);
                console.log('Parsed data:', data);
                $('#messages').append('<p>' + JSON.stringify(data) + '</p>');
            };

            socket.onclose = function(event) {
                console.log('WebSocket connection closed');
            };

            socket.onerror = function(event) {
                console.log('WebSocket error:', event);
            };
        });
    </script>
</body>
</html>
