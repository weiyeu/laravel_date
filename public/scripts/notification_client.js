$(function () {
    // get connection data from server script
    var connData =
    {
        userToken: userToken,
        nickname: nickname,
        roomToken: roomToken
    };

    // create socket with query string
    //var socket = io('http://123.195.55.42:3000', {query: 'token=' + userToken + '&nickname=' + nickname});
    var socket = io('http://localhost:3000', {query: 'userToken=' + userToken + '&nickname=' + nickname});


    // connect
    socket.on('connect', function (message) {
        console.log('connetct!!!' + message);
        $('#message_box').append('connected');
        socket.emit('set-room-token', connData);
    });

    // error
    socket.on('error', function (err) {
        console.log('error' + err);
    });

    // user notification
    socket.on("notification-channel:App\\Events\\PushNotification", function (message) {
        console.log('notification message' + message.data.token);
        alert(message.data.message);
    });

    // server notification
    socket.on('server-notification', function (message) {
        alert(message);
    });

    socket.on('connect-to-friend', function (message) {
        alert(message.message);
    });

    var id = 0;
    var startDate;
    var startTime;
    var myname;
    // chat functions
    $('#message').keypress(function (e) {
        if (e.keyCode == 13) {
            $('#send-btn').click();
        }
    });

    var incremental = 0;
    var interval;
    $('#join-btn').on('click', function () {
        var connData = {
            friendNickname: $('#friendName').val()
        };
        socket.emit('connect-to-friend', connData);
    });

    $('#send-btn').click(function () { //use clicks message send button
        clearInterval(interval);
        startDate = new Date();
        startTime = startDate.getTime();
        var mymessage = $('#message').val(); //get message text
        var friendName = $('#friendName').val(); //get user name
        var _token = $('input[name=_token]').val();

        if (friendName == "") { //empty name?
            alert("Enter your Name please!");
            return;
        }
        if (mymessage == "") { //emtpy message?
            alert("Enter Some message Please!");
            return;
        }
        //interval = setInterval(function () {
        //    var _token = $('input[name=_token]').val();
        //    var msg = {
        //        message: ++incremental,
        //        name: myname,
        //        type: 'usermsg',
        //        color: 'black',
        //        id: ++id
        //    };
        //    var data = {
        //        '_token': _token,
        //        'msg': msg
        //    }
        //    // append message to box
        //    //$('#message_box').append("<div id=\"" + id + myname + "\"><span class=\"user_name\" style=\"color:#black\">" + myname + "</span> : <span class=\"user_message\">" + incremental + "</span></div>");
        //
        //    // ajax post message
        //    //$.ajax({
        //    //    method: 'post',
        //    //    url: 'http://localhost/laravel_date/public/chat',
        //    //    data: data,
        //    //    datatype: 'json',
        //    //    success: function (data, status, xhr) {
        //    //    }
        //    //});
        //    socket.emit('chat-message', msg);
        //
        //}, 50);
        //prepare json data
        var msg = {
            message: mymessage,
            name: connData.nickname,
            targetUser: friendName,
            type: 'usermsg',
            color: 'black',
            id: ++id
        };
        var data = {
            '_token': _token,
            'msg': msg
        }
        // append message to box
        //$('#message_box').append("<div id=\"" + id + "\"><span class=\"user_name\" style=\"color:#black\">" + myname + "</span> : <span class=\"user_message\">" + mymessage + "</span></div>");

        //convert and send data to server
        socket.emit('chat-message', msg);
    });

    socket.on('chat-channel', function (ev) {
        var endDate = new Date();
        var endTime = endDate.getTime();
        var processTime = endTime - startTime;
        console.log('proccess time is ' + processTime + 'ms')
        console.log('got chat-channel message!!! ' + ev);
        var msg = ev;
        var type = msg.type; //message type
        var umsg = msg.message; //message text
        var uname = msg.name; //user name
        var ucolor = msg.color; //color
        var u_id = msg.id; //id
        if (type == 'usermsg') {
            $('#message_box').append("<div><span class=\"user_name\" style=\"color:#" + ucolor + "\">" + uname + "</span> : <span class=\"user_message\">" + umsg + "</span></div>");

        }
        if (type == 'system') {
            $('#message_box').append("<div class=\"system_msg\">" + umsg + "</div>");
        }

        $('#message').val(''); //reset text
    });
})
;

