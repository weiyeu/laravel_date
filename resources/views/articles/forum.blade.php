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
    			<!-- search article -->
    			<form class="form-horizontal" method="post">
                    {!! csrf_field() !!}
                    <input type="text" class="form-control" style="margin-bottom:1em" id="searchArticle" name="search_article" placeholder="搜尋文章">
                    <button type="submit" class="btn btn-default">搜尋</button>
                </form>
                <!--articles list-->
				<div class="panel panel-default">
					<div class="panel-body">
						<h1>最新文章</h1>
						<div class="c-table table-header">
                            <div class="col-sm-4 table-cell">標題</div>
                            <div class="col-sm-3 table-cell">作者</div>
                            <div class="col-sm-3 table-cell">分類</div>
                            <div class="col-sm-1 table-cell"><i class="fa fa-commenting"></i></div>
                            <div class="col-sm-1 table-cell"><i class="fa fa-heart"></i></div>
						</div>
						@foreach($articles as $article)
						    <a href="{{'/laravel_date/public/article/p/'.$article->id}}">
                                <div class="c-table table-row">
                                    <div class="col-sm-4 table-cell">{{$article->title}}</div>
                                    <div class="col-sm-3 table-cell">{{$article->user->nickname}}</div>
                                    <div class="col-sm-3 table-cell">{{$article_type_hash[$article->article_type]}}</div>
                                    <div class="col-sm-1 table-cell">{{$article->num_of_comments}}</div>
                                    <div class="col-sm-1 table-cell">{{$article->num_of_likes}}</div>
                                </div>
                            </a>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection