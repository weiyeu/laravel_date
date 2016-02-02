// create socket
var socket = io('http://localhost:3000');

// on notification channel handler
socket.on("notification-channel:App\\Events\\PushNotification", function (message) {
    console.log('Got the message!!!' + message.data.token);
    alert(message.data.message);
});

socket.on('connect', function (message) {
    console.log('connetct!!!' + message);
    socket.emit('set-token',Notification.TOKEN);
});