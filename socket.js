var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();
var mysql = require('mysql');
var crypto = require('crypto');
var async = require('async');
// crypto configuration
const secret = 'babamamamimi';

// mysql connection
var connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '115225',
    database: 'mydb'
});

connection.connect();

// Redis 訂閱 `notification` 頻道
redis.subscribe('notification-channel', function (err, count) {
    console.log('subscribed notification-channel');
});

// Redis 訂閱 `notification` 頻道
redis.subscribe('chat-channel', function (err, count) {
    console.log('subscribed chat-channel');
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
    // user chatting
    else if (channel == 'chat-channel') {
        io.emit(channel, message);
    }
    else {
        io.emit(channel + ':' + message.event, message);
    }
});
io.use(function (socket, next) {
    var token = socket.handshake.query.token;
    var nickname = socket.handshake.query.nickname;

    // debug message
    console.log(nickname + ' is coming for authentication\nUser   token is ' + token);

    var sha256Token;
    // get current user from mysql
    connection.query('SELECT * FROM users WHERE nickname=\'' + nickname + '\' LIMIT 1', function (err, rows, fields) {

        // if mysql error
        if (err) {
            console.log('mysql query error!!!\n');
            throw err;
        }

        // create token
        sha256Token = crypto.createHmac('sha256', secret)
            .update(rows[0].id + '|' + rows[0].email)
            .digest('hex');

        // debug message
        console.log('Server token is ' + sha256Token);

        // append nickname to socket
        socket.nickname = nickname;

        // initialize socket's chatRooms
        socket.chatRooms = {};

        // check authentication
        if (sha256Token == token) {
            next();
            console.log(nickname + ' pass authentication');
        } else {
            console.log(nickname + ' fail authentication');
            next(new Error('authentication fail!'));
        }
    });
});

io.on('connection', function (socket) {
    // join the token and socket into rooms
    socket.on('set-room-token', function (connData) {
        console.log('\'' + this.nickname + '\' join the token into the room : ' + connData.roomToken);
        this.join(connData.roomToken);
        this.roomToken = connData.roomToken;
        //console.log(Object.keys(io.nsps['/'].adapter.rooms['token:' + connData.roomToken].sockets));
    });
    socket.on('connect-to-friend', function (connData) {
        // debug message
        console.log('\'' + this.nickname + '\' is trying to connect to \'' + connData.friendNickname + '\'');
        var localSocket = this;
        var connDataToClient = {};
        // query string
        var queryRelationString = 'SELECT * FROM friends WHERE user_nickname=\''
            + this.nickname +
            '\' AND friend_nickname=\''
            + connData.friendNickname +
            '\' LIMIT 1';
        var queryFriendString = 'SELECT * FROM users WHERE nickname=' + connData.friendNickname + 'LIMIT 1';
        // query mysql
        connection.query(queryRelationString, function (err, rows, fields) {
            // check mysql error
            if (err) {
                console.log('mysql query error!!!\n');
                throw err;
            }
            // check friend fail
            if (!rows[0]) {
                // set message
                connDataToClient.message = '\'' + connData.friendNickname + '\' is not a friend of \'' + localSocket.nickname + '\'';
            }
            // check friend pass
            else {
                // set message
                connDataToClient.message = '\'' + localSocket.nickname + '\' successfully connect to  \'' + connData.friendNickname + '\'';

                // create friend's roomToken
                var friendRoomToken = crypto.createHash('sha1')
                    .update(rows[0].friend_id + '|' + rows[0].friend_email)
                    .digest('hex');

                // debug message
                console.log('friendRoomToken is ' + friendRoomToken);

                // append friend's nickname and roomToken into socket's chatRooms object
                localSocket.chatRooms[connData.friendNickname] = friendRoomToken;

                // append owner's nickname and roomToken to the target user
                console.log('==================');
                console.log(Object.keys(io.nsps['/'].adapter.rooms[friendRoomToken].sockets));
                var targetSocketId = Object.keys(io.nsps['/'].adapter.rooms[friendRoomToken].sockets);
                var targetSocket = io.sockets.connected[targetSocketId];
                console.log(io.sockets.connected[targetSocketId]);
                targetSocket.chatRooms[localSocket.nickname] = localSocket.roomToken;
                console.log('==================');

                // tell users that connection is established
                io.to(localSocket.id)
                    .to(friendRoomToken)
                    .emit('connect-to-friend', connDataToClient);
            }
            console.log(connDataToClient.message);
            console.log(localSocket.chatRooms);


        });
    });
// chat message
    socket.on('chat-message', function (message) {
        // debug message
        console.log('"' + this.nickname + '" send "' + message.message + '" to "' + message.targetUser + '"');
        console.log('target user roomTokens is ' + this.chatRooms[message.targetUser]);
        // send message to self and targetUser
        io.to(this.id)
            .to(this.chatRooms[message.targetUser])
            .emit('chat-channel', message);
        // check the target user is in chatRooms object or not

        // emit message to the target user
    });
})
;

// 讓用戶端可以透過 Port 3000 連接 Socket.IO Server
http.listen(3000, function () {
    console.log('Listening on Port 3000');
});