var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();

// Redis 訂閱 `chat-channel` 頻道
redis.subscribe('test-channel', function (err, count) {
    console.log('subscribed');
});

// 當 Redis 有事件發生時，透過 Socket.IO Server 發送事件
redis.on('message', function (channel, message) {
    console.log('message is coming!!!');
    console.log(message);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message);
});

// 讓用戶端可以透過 Port 3000 連接 Socket.IO Server
http.listen(3000, function () {
    console.log('Listening on Port 3000');
});