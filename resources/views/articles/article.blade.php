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
					    @if(Auth::check())
						<button class="btn btn-default" data-toggle="slide" data-target="#reply-collapse"><i class="fa fa-comments"></i> 回覆</button>
						@else
						<a class="btn btn-default" href="/laravel_date/public/article/intend/reply/{{$article_id}}"><i class="fa fa-comments"></i> 回覆</a>
						@endif
						<button class="btn btn-default" id="like" data-article-id="{{$article_id}}"><i class="fa fa-heart"></i> 喜歡 {{$article->num_of_likes}}</button>
						<a class="btn btn-default" href="#"><i class="fa fa-shopping-basket"></i> 收藏</a>
						<a class="btn btn-default" href="#"><i class="fa fa-th-list"></i> 清單</a>
					</div>
				</div>
			</div>
		</div>
		<!-- reply -->
		@if(isset($user))
		<div class="row slide" id="reply-collapse">
			<div class="panel panel-default">
			    <form method="post">
                    {!! csrf_field() !!}
				    <div class="panel-body">
				    	<p>我也要回覆</p>
				    	<p class="underline-lightgray"></p>
				    	<div class="comment">
				    		<!-- author img -->
				    		<div class="author">
				    			<img src={{$user->profile_image_url}}>
				    		</div>
				    		<!-- content -->
				    		<div class="content">
				    			<p class="author-title">{{$user->nickname}}</p>
				    			<textarea name="comment_content" style="width:100%" rows="5" placeHolder="一起來討論吧..."></textarea>
				    		</div>
				    		<button type="submit" class="btn btn-info pull-right" style="margin-top:15px">確定送出</button>
				    	</div>
				    </div>
				</form>
			</div>
		</div>
		@endif
		<!-- comments -->
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-info">
					<div class="panel-body">
						<p>回覆</p>
						<p class="underline-lightgray">
    					<!-- comment -->
						@foreach($article->comments as $comment)
                        <div class="comment" >
							<!-- author img -->
							<div class="author">
								<img src={{$comment->user->profile_image_url}}>
							</div>
							<!-- content -->
							<div class="content">
								<p class="author-title">{{$comment->user->nickname}}</p>
								{{$comment->comment_content}}
								<p class="time">{{$comment->updated_at}}</p>
								<p class="underline-lightgray"></p>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection