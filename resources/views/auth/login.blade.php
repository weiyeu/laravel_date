@extends('master')
@section('title','Login')
@section('custom css')
<link rel="stylesheet" type="text/css" href="css/login.css">
@endsection
@section('custom js')
<script type="text/javascript" src="scripts/login.js"></script>
@endsection
@section('content')
	<div class="container">
		<div class="jumbotron" >
			<h1 class="text-center text-bold">登入 <i class="fa fa-heart"></i></h1>
		</div>
		<div class="row">
			<div class="col-sm-offset-3 col-sm-6">
				<div class="panel panel-default">
					<div class="panel-body inner">
						<h4 class="panel-heading col-sm-12" style="text-align:center">:)</h4>
						<form role="form">
							<!-- account -->
							<div class="form-group">
								<label class="control-label" for="account">*帳號:</label>
								<input type="text" class="form-control" id="account" placeholder="Hello@hellomail.com">
							</div>
							<!-- password -->
							<div class="form-group">
								<label class="control-label" for="password">*密碼:</label>
								<input type="password" class="form-control" id="password" placeholder="秘密">
							</div>
							<!-- email login button -->
							<div class="form-group">
								<button type="submit" class="btn btn-info btn-block"><i class="fa fa-envelope"></i> 登入</button>
							</div>
							<!-- facebook login button -->
							<div class="form-group">
								<button type="button" class="btn btn-primary btn-block"><i class="fa fa-facebook-square"></i> 使用FACEBOOK登入</button>
							</div>
						</form>
						<a href="#">忘記密碼</a>
						<a href="#" class="pull-right">重新註冊</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection