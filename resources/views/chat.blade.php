@extends('master')
@section('title','Chat')
@section('custom css')
<link rel="stylesheet" type="text/css" href="css/chat.css">
@endsection
@section('custom js')
<script type="text/javascript" src="scripts/chat.js"></script>
@endsection
@section('content')
<style type="text/css">
<!--
.chat_wrapper {
	width: 500px;
	margin-right: auto;
	margin-left: auto;
	background: #CCCCCC;
	border: 1px solid #999999;
	padding: 10px;
	font: 12px 'lucida grande',tahoma,verdana,arial,sans-serif;
}
.chat_wrapper .message_box {
	background: #FFFFFF;
	height: 150px;
	overflow: auto;
	padding: 10px;
	border: 1px solid #999999;
}
.chat_wrapper .panel input{
	padding: 2px 2px 2px 5px;
}
.system_msg{color: #BDBDBD;font-style: italic;}
.user_name{font-weight:bold;}
.user_message{color: #88B6E0;}
-->
</style>
{!! csrf_field() !!}
<div class="container">
<div class="chat_wrapper">
<div class="message_box" id="message_box"></div>
<div class="panel">
<input type="text" name="name" id="name" placeholder="Your Name" maxlength="10" style="width:20%"  />
<input type="text" name="message" id="message" placeholder="Message" maxlength="80" style="width:60%" />
<button id="send-btn">Send</button>
<button id="join-btn">Join Room</button>
</div>
</div>
</div>

@endsection