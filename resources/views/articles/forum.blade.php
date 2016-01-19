@extends('master')
@section('title','Forum')
@section('custom css')
<!-- custom css -->
<link rel="stylesheet" type="text/css" href="/laravel_date/public/css/forum.css">
@endsection
@section('custom js')
<!-- custom javascript -->
<script type="text/javascript" src="/laravel_date/public/scripts/forum.js"></script>
@endsection
@section('content')
    <!-- main container -->
	<div class="container">
		<!-- first row -->
		<div class="row">
			<!-- today hot -->
			<div class="col-sm-4">
				<a class="cancel-decoration" href="#">
					<div class="panel panel-default">
						<div class="panel-heading text-center">今日熱門</div>
						<div class="panel-body text-center">
							<span class="glyphicon glyphicon-star text-super-large" style="color:gold"></span>
							<p class="text-large" style="color:black"><br>看看今天最熱門的文章吧!</p>
						</div>
					</div>
				</a>
			</div>
			<!-- review after dinner -->
			<div class="col-sm-4">
				<a class="cancel-decoration" href="#">
					<div class="panel panel-default">
						<div class="panel-heading text-center">餐後心情</div>
						<div class="panel-body text-center">
							<i class="fa fa-heart red text-super-large"></i>
							<p class="text-large" style="color:black"><br>分享今日餐聚的心情</p>
						</div>
					</div>
				</a>
			</div>
			<!-- food share -->
			<div class="col-sm-4">
				<a class="cancel-decoration" href="#">
					<div class="panel panel-default">
						<div class="panel-heading text-center">美食分享</div>
						<div class="panel-body text-center">
							<span class="glyphicon glyphicon-cutlery text-super-large" style="color:black"></span>
							<p class="text-large" style="color:black"><br>好吃的餐點真讓人愉悅呢!</p>
						</div>
					</div>
				</a>
			</div>
		</div>
		<!-- second row -->
		<div class="row">
			<!-- music -->
			<div class="col-sm-4">
				<a class="cancel-decoration" href="#">
					<div class="panel panel-default">
						<div class="panel-heading text-center">美妙旋律</div>
						<div class="panel-body text-center">
							<span class="glyphicon glyphicon-music text-super-large" style="color:DeepSkyBlue"></span>
							<p class="text-large" style="color:black"><br>聽到了好聽的音樂</p>
						</div>
					</div>
				</a>
			</div>
			<!-- talk -->
			<div class="col-sm-4">
				<a class="cancel-decoration" href="#">
					<div class="panel panel-default">
						<div class="panel-heading text-center">我想抒發</div>
						<div class="panel-body text-center">
							<span class="glyphicon glyphicon-bullhorn text-super-large" style="color:gray"></span>
							<p class="text-large" style="color:black"><br>這就是我的情緒與想法!</p>
						</div>
					</div>
				</a>
			</div>
			<!-- fashion -->
			<div class="col-sm-4">
				<a class="cancel-decoration" href="#">
					<div class="panel panel-default">
						<div class="panel-heading text-center">時尚潮流</div>
						<div class="panel-body text-center">
							<span class="glyphicon glyphicon-sunglasses text-super-large" style="color:darkOrange"></span>
							<p class="text-large" style="color:black"><br>這樣穿搭最好看</p>
						</div>
					</div>
				</a>
			</div>
			<!-- questions -->
			<div class="col-sm-4">
				<a class="cancel-decoration" href="#">
					<div class="panel panel-default">
						<div class="panel-heading text-center">我有疑問</div>
						<div class="panel-body text-center">
							<span class="glyphicon glyphicon-question-sign text-super-large" style=""></span>
							<p class="text-large" style="color:black"><br>我想問...</p>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
	<!-- articles -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="panel panel-default">
					<div class="panel-body">
						<h1>今日熱門</h1>
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="col-sm-4">標題</th>
									<th class="col-sm-3">作者</th>
									<th class="col-sm-3">分類</th>
									<th class="col-sm-1"><span class="glyphicon glyphicon-comment" style="color:gray"></span></th>
									<th class="col-sm-1"><span class="glyphicon glyphicon-heart" style="color:gray"></span></th>
								</tr>
							</thead>
							<tbody>
								<tr class="info click-row" data-href="/laravel_date/public/article/p/123">
									<td>第一次跟女生吃飯</td>
									<td>煞氣a小明</td>
									<td>餐後心情</td>
									<td>2350</td>
									<td>1822</td>
								</tr>
								<tr>
									<td>吃完飯就沒下文了...</td>
									<td>BWS夠狂</td>
									<td>我想抒發</td>
									<td>2150</td>
									<td>1622</td>
								</tr>
								<tr class="info">
									<td>活大自助餐真美味</td>
									<td>電機狂人</td>
									<td>美食分享</td>
									<td>1232</td>
									<td>822</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection