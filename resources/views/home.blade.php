@extends('master')
@section('title','Home')
@section('custom css')
<link rel="stylesheet" type="text/css" href="/laravel_date/public/css/home.css">
@endsection
@section('custom js')
<script type="text/javascript" src="/laravel_date/public/scripts/home.js"></script>
@endsection
@section('content')
<!-- main contain -->
<div class="container">
    <div class="background-image">
    </div>
    <div class="jumbotron">
        <h1 class="text-center text-bold">距離配對時間 <span id="clock"></span></h1>
    </div>
    <div class="jumbotron">
        <h1 class="text-center text-bold">要不要一起吃晚餐 <i class="fa fa-heart"></i></h1>
    </div>
    <a href="/laravel_date/public/apply_for_date" class="btn btn-danger btn-block text-super-large text-bold">我想參加</a>
    <a href="/laravel_date/public/forum" class="btn btn-warning btn-block text-super-large text-bold">經驗分享</a>
    <a href="/laravel_date/public/about" class="btn btn-primary btn-block text-super-large text-bold">關於一切</a>
</div>
@endsection
