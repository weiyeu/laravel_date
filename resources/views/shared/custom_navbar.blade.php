<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/laravel_date/public/home"><span class="glyphicon glyphicon-heart"></span> 一起來晚餐吧!</a>
    </div>
    <div>
      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="/laravel_date/public/home"><span class="glyphicon glyphicon-home"></span> 首頁</a></li>
        <li><a href="#"><span class="glyphicon glyphicon-info-sign"></span> 關於</a></li>
        @if(Auth::check())
        <li><a href="/laravel_date/public/users/logout"><span class="glyphicon glyphicon-log-out"></span> 登出</a></li>
        @else
        <li><a href="/laravel_date/public/users/register"><span class="glyphicon glyphicon-user"></span>申請帳號</a></li>
        <li><a href="/laravel_date/public/users/login"><span class="glyphicon glyphicon-log-in"></span> 登入</a></li>
        @endif
      </ul>
    </div>
  </div>
</nav>
