@extends('master')
@section('title','home')

@section('content')
@parent

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>


            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
<div class="container">
    <div class="content">
        <div class="title">Home Page</div>
        <div class="quote">Our Home page!</div>
    </div>
</div>
@endsection