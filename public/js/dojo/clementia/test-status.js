define([

], function() {
    var socket = io.connect('http://localhost:8080');
        socket.on('test_queue_result', function (data) {
            console.log(data);
        });
});