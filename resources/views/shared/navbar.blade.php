<!-- navbar -->
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#homeNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/laravel_date/public/home"><i class="fa fa-heart red"></i> 一起來晚餐吧!</a>
        </div>
        <div class="collapse navbar-collapse" id="homeNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="/laravel_date/public/home"><span class="glyphicon glyphicon-home"></span> 首頁</a></li>
                @if(Auth::check())
                <li><a href="/laravel_date/public/profile/edit"><i class="fa fa-cog"></i></span> 個人設定</a></li>
                <li><a href="/laravel_date/public/users/mydate"><i class="fa fa-heart"></i></span> 我的約會</a></li>
                <li><a href="/laravel_date/public/users/logout"><span class="glyphicon glyphicon-log-out"></span> 登出</a></li>
                @else
                <li><a href="/laravel_date/public/users/register"><span class="glyphicon glyphicon-user"></span>申請帳號</a></li>
                <li><a href="/laravel_date/public/users/login"><span class="glyphicon glyphicon-log-in"></span> 登入</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>