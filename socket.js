var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();

// Redis 訂閱 `notification` 頻道
redis.subscribe('notification-channel', function (err, count) {
    console.log('subscribed notification-channel');
});

// Redis 訂閱 `test-channel` 頻道
redis.subscribe('test-channel', function (err, count) {
    console.log('subscribed test-channel');
});


// 當 Redis 有事件發生時，透過 Socket.IO Server 發送事件
redis.on('message', function (channel, message) {
    console.log('message is coming in ' + channel);
    console.log(message);

    // json parse message
    message = JSON.parse(message);

    // notify users
    if (channel == 'notification-channel') {
        io.to('token:' + message.data.token).emit(channel + ':' + message.event, message);
    }
    else {
        io.emit(channel + ':' + message.event, message);
    }
    console.log(io.clients());
});

io.on('connection', function (socket) {
    // join the token and socket into rooms
    socket.on('set-token', function (token) {
        console.log('join the token into the room : ' + token);
        socket.join('token:' + token);
    });
});

// 讓用戶端可以透過 Port 3000 連接 Socket.IO Server
http.listen(3000, function () {
    console.log('Listening on Port 3000');
});