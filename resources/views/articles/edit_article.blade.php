@extends('master')
@section('title','Edit Article')
@section('custom css')
<!-- custom css -->
<link rel="stylesheet" type="text/css" href="/laravel_date/public/css/edit_article.css">
@endsection
@section('custom js')
<!-- custom javascript -->
<script type="text/javascript" src="/laravel_date/public/scripts/edit_article.js"></script>
@endsection
@section('content')
    <!-- main container -->
	<div class="container">
		<div class="jumbotron" >
			<h1 class="text-center text-bold">寫下你想說的吧 <i class="fa fa-heart red"></i></h1>
		</div>
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-body inner">
					<form class="form-horizontal" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @foreach ($errors->all() as $error)
                            <p class="alert alert-danger">{{ $error }}</p>
                        @endforeach
						<!-- article title -->
						<div class="form-group">
							<label class="control-label col-sm-1" for="title">標題:</label>
							<div class="col-sm-11">
								<input type="text" class="form-control" id="title" name="title" placeholder="" value="{{ old('title') }}">
							</div>
						</div>
						<!-- insert img modal button -->
						<div class="form-group" >
							<div class="col-sm-offset-1 col-sm-11">
								<button type="button" id="openModal" class="btn btn-info" data-toggle="modal" data-target="#insertImgModal"><i class="fa fa-picture-o"></i> 插入圖片</button>
							</div>
						</div>
						<!-- profileImg modal -->
						<div id="insertImgModal" class="modal fade">
							<div class="modal-dialog modal-lg">
								<!-- content -->
								<div class="modal-content">
									<!-- header -->
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Modal Header</h4>
									</div>
									<!-- body -->
									<div class="modal-body">
										<!-- drop area -->
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-8">
												<div class="drop-area">
													<input class="hidden" type='file' name="uploadImg" id="uploadImg"/>
													<p>
														將本機圖片拖曳至此<br>
														或<br>
														點擊這裡
													</p>
												</div>
											</div>
										</div>
										<!-- hint text -->
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-8" style="text-align:center">
												<p>或是貼上圖片連結↓</p>
											</div>
										</div>
										<!-- link input -->
										<div class="form-group">
											<label class="control-label col-sm-2" for="title">圖片連結:</label>
											<div class="col-sm-8">
												<input id="uploadImgLink" name="uploadImgLink" type="text" class="form-control" id="title" placeholder="http://example.com/img.jpg">
											</div>
										</div>
									</div>
									<!-- footer -->
									<div class="modal-footer">
										<button type="button" id="cancel" class="btn btn-default" data-dismiss="modal">取消</button>
										<button type="button" id="uploadImgConfirm" class="btn btn-default pull-left">確定</button>
									</div>
								</div>
							</div>
						</div>
						<!-- article content -->
						<div class="form-group">
							<label class="control-label col-sm-1" for="content">內文:</label>
							<div class="col-sm-11">
								<div class="form-control editable" id="editableContent" contenteditable="true" style="width:100%;height:500px;overflow:auto" id="content">{{old('article_content')}}</div>
							</div>
						</div>
						<input type="text" id="articleContent" name="article_content" class="hidden">
						<!-- article type -->
						<div class="form-group">
							<label class="control-label col-sm-1" for="articleType">文章分類:</label>
							<div class="col-sm-11">
								<select class="form-control" id="articleType" name="article_type">
									<option disabled selected>未分類</option>
									<option value="1">餐後心情</option>
									<option value="2">美食分享</option>
									<option value="3">美妙旋律</option>
									<option value="4">我想抒發</option>
									<option value="5">時尚潮流</option>
									<option value="6">隨便亂發</option>
								</select>
							</div>
						</div>
						<!-- subimt button -->
						<div class="form-group">
							<div class="col-sm-11 col-sm-offset-1">
								<button type="submit" id="submit" class="btn btn-default">確定發表</button>
								<button type="button" id="cancel" class="btn btn-default">取消</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection