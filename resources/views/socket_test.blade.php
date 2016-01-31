@extends('master')
@section('title','Socket_test')
@section('custom css')
@endsection
@section('custom js')
@endsection
@section('content')
<p id="power">0</p>
<script>
var socket = io('http://localhost:3000');
        socket.on("test-channel:App\\Events\\TestEvent", function(message){
            console.log('Got the message!!!' + message);
            // increase the power everytime we load test route
            $('#power').text(parseInt($('#power').text()) + parseInt(message.data.power));
        });
</script>
@endsection