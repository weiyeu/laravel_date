<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Jcrop css -->
    <link rel="stylesheet" href="/laravel_date/public/css/jquery.Jcrop.css" type="text/css" />
    <!-- font-awesom -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- common css -->
    <link rel="stylesheet" type="text/css" href="/laravel_date/public/css/common.css">
    <!-- custom css -->
    @yield('custom css')

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- bootstrap javascript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- Jcrop -->
    <script src="/laravel_date/public/scripts/jquery.Jcrop.js"></script>
    @if(Auth::check())
    <!--Socket io-->
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
    <script>
        Notification.TOKEN = '{{sha1(auth()->user()->id.'|'.auth()->user()->email)}}';
    </script>
    <!--Notification-->
    <script src="/laravel_date/public/scripts/notification_client.js"></script>
    @endif
    <!-- common javascript -->
    <script type="text/javascript" src="/laravel_date/public/scripts/common.js"></script>
    <!-- custom javascript -->
    @yield('custom js')
</head>
<body>

@include('shared.navbar')

@yield('content')

<!-- footer -->
<footer class="container-fluid text-center">
    <p>&copy 2015 Dating</p>
</footer>

</body>

</html>