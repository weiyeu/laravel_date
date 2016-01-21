@extends('master')
@section('title','Article')
@section('custom css')
<!-- custom css -->
<link rel="stylesheet" type="text/css" href="/laravel_date/public/css/article.css">
@endsection
@section('custom js')
<!-- custom javascript -->
<script type="text/javascript" src="/laravel_date/public/scripts/article.js"></script>
@endsection
@section('content')
    <!-- main container -->
	<div class="container">
		<!-- main article -->
		<div class="row">
			<div class="panel panel-info">
				<!-- panel heading -->
				<div class="panel-heading">
					<!-- title -->
					<h2>{{$article->title}}</h2>
				</div>
				<!-- panel body -->
				<div class="panel-body">
					<p>分類 : <span>{{$article_type_hash[$article->article_type]}}</span>&nbsp&nbsp&nbsp&nbsp 發表時間 : <span>{{$article->updated_at}}</span></p>
					<span>{{$article->user->nickname}}</span></p>
					<p class="underline-lightgray"></p>
					<div class="article-content" >
                    {!!$article->article_content!!}
					</div>
				</div>
				<div class="panel-footer" style="text-align:center">
					<div class="btn-group">
						<a class="btn btn-default no-jump" data-toggle="slide" data-target="#reply-collapse" href="#"><i class="fa fa-comments"></i> 回覆</a>
						<a class="btn btn-default" href="#"><i class="fa fa-heart"></i> 喜歡</a>
						<a class="btn btn-default" href="#"><i class="fa fa-shopping-basket"></i> 收藏</a>
						<a class="btn btn-default" href="#"><i class="fa fa-th-list"></i> 清單</a>
					</div>
				</div>
			</div>
		</div>
		<!-- reply -->
		<div class="row slide" id="reply-collapse">
			<div class="panel panel-default">
				<div class="panel-body">
					<p>我也要回覆</p>
					<p class="underline-lightgray"></p>
					<div class="comment">
						<!-- author img -->
						<div class="author">
							<img src="Lighthouse.jpg">
						</div>
						<!-- content -->
						<div class="content">
							<p class="author-title">煞氣a小明</p>
							<textarea style="width:100%" rows="5" placeHolder="一起來討論吧..."></textarea>
						</div>
						<button class="btn btn-info pull-right" style="margin-top:15px">確定送出</button>
					</div>
				</div>
			</div>
		</div>
		<!-- comments -->
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-info">
					<div class="panel-body">
						<p>回覆</p>
						<p class="underline-lightgray"></p>
						<!-- comment -->
						<div class="comment" >
							<!-- author img -->
							<div class="author">
								<img src="flower.jpg">
							</div>
							<!-- content -->
							<div class="content">
								<p class="author-title">BWS 夠狂</p>
								<p>真是為你感到開心阿小明</p>
								<p>我的吃完晚餐後就沒下文了QQ</p>
								<p class="time">2015/12/22 ,11:33PM</p>
								<p class="underline-lightgray"></p>
							</div>
						</div>
						<!-- comment -->
						<div class="comment" >
							<!-- author img -->
							<div class="author">
								<img src="Penguins.jpg">
							</div>
							<!-- content -->
							<div class="content">
								<p class="author-title">電機狂人</p>
								<p>下次可以去活大自助餐吃吃看!</p>
								<p>我推薦:)</p>
								<p class="time">2015/12/22 ,11:35PM</p>
								<p class="underline-lightgray"></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection