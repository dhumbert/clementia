var redis = require('redis');

var io = require('socket.io').listen(8080);

io.sockets.on('connection', function (socket) {
    var subscribe = redis.createClient();
    subscribe.subscribe('test_queue_add');
    subscribe.on('message', function(channel, message) {
        socket.emit('test_queue_result', { message: message });
    });
});