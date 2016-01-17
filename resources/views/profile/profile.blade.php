@extends('master')
@section('title','Profile')
@section('custom css')
<link rel="stylesheet" type="text/css" href="/laravel_date/public/css/profile.css">
@endsection
@section('custom js')
<script type="text/javascript" src="/laravel_date/public/scripts/profile.js"></script>
@endsection
@section('content')
<!-- main container -->
	<div class="container">
		<div class="row">
			<!-- left list -->
			<div class="col-sm-4">
				<div class="inner">
					<!-- basic information -->
					<ul class="list-group">
						<h4 class="underline">帳號管理</h4>
						<li class="list-group-item">
							<a href="profile.html">基本資料<span class="glyphicon glyphicon-chevron-right" style="float:right"></span></a>
						</li>
						<li class="list-group-item">
							<a href="profile_password.html">修改密碼<span class="glyphicon glyphicon-chevron-right" style="float:right"></span>
							</a>
						</li>
						<li class="list-group-item">
							<a href="profile_subcribe.html">訂閱通知<span class="glyphicon glyphicon-chevron-right" style="float:right"></span>
							</a>
						</li>
						<li class="list-group-item">
							<a href="profile_surprise.html">驚喜一下<span class="glyphicon glyphicon-chevron-right" style="float:right"></span>
							</a>
						</li>
					</ul>
					<!-- custom data -->
					<ul class="list-group">
						<h4 class="underline">我的私藏</h4>
						<li class="list-group-item">
							<a href="#">item0<span class="glyphicon glyphicon-chevron-right" style="float:right"></span>
							</a>
						</li>
						<li class="list-group-item">
							<a href="#">item1<span class="glyphicon glyphicon-chevron-right" style="float:right"></span>
							</a>
						</li>
					</ul>
				</div>
			</div>

			<!-- main content -->
			<div class="col-sm-8">
				<div class="panel panel-default">
					<div class="panel-body inner">
						<h4 class="panel-heading" style="background:white">基本資料</h4>
						<form class="form-horizontal" method="post" enctype="multipart/form-data">
   	                    {!! csrf_field() !!}
   	                        @foreach ($errors->all() as $error)
                                <p class="alert alert-danger">{{ $error }}</p>
                            @endforeach
							<!-- profileImg  -->
							<div class="form-group">
								<label class="control-label col-sm-2">大頭貼:</label>
								<!-- modal trigger button -->
								<div class="col-sm-10">
									<div class="smallProfileContainer" style="margin-left:0">
										<img id="smallProfileImg" alt="file not found" src="{{auth()->user()->profile_image_path}}">
									</div>
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#profileImgModal" data-backdrop="static"><i class="fa fa-user"></i> 更換大頭貼</button>
								</div>
							</div>
                   			<input type="text" class="hidden" id="jcropSelection" name="jcropSelection">
							<!-- profileImg modal -->
                            <div id="profileImgModal" class="modal fade">
                            	<div class="modal-dialog">
                            		<!-- content -->
                            		<div class="modal-content">
                            			<!-- header -->
                            			<div class="modal-header">
                            				<button type="button" class="close" data-dismiss="modal">&times;</button>
                            				<h4 class="modal-title">Modal Header</h4>
                            			</div>
                            			<!-- body -->
                            			<div class="modal-body">
                            				<img id="profileImg" alt="file not found" src="/laravel_date/public/resource/flower.jpg">
                            				<div class="previewContainer hidden">
                            					<img id="previewImg" alt="file not found" src="/laravel_date/public/resource/flower.jpg">
                            				</div>
                            			    <input type='file' class="hidden" name="uploadImg" id="uploadImg"/>
                            			</div>
                            			<!-- footer -->
                            			<div class="modal-footer">
                            				<button type="button" class="btn btn-info" data-dismiss="modal">取消</button>
                            				<button type="button" id="selectUploadImg" class="btn btn-primary pull-left" data-dismiss="">選擇圖片</button>
                            				<button type="button" id="confirmCrop" class="btn btn-success pull-left hidden" data-dismiss="">確定裁切</button>
                            			</div>
                            		</div>
                            	</div>
                            </div>
							<!-- nick name -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="nickName">*暱稱:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="nickName" name="nickName" placeholder="請填寫暱稱" value="{{auth()->user()->nickname}}">
								</div>
							</div>
							<!-- real name -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="realName">*真實姓名:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="realName" name="realName" placeholder="請填寫真實姓名" value="{{auth()->user()->real_name}}">
								</div>
							</div>
							<!-- Email -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="email">*Email:</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{auth()->user()->email}}">
								</div>
							</div>
							<!-- sex -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="sex">性別:</label>
								<div class="col-sm-10">
									<select class="form-control" id="sex" name="sex">
										<option disabled selected>null</option>
										<option>男</option>
										<option>女</option>
									</select>
								</div>
							</div>
							<!-- birthday -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="sex">生日:</label>
								<!-- year -->
								<div class="col-sm-4">
									<select class="form-control" id="year" name="year">
										<option disabled selected>年</option>
									</select>
								</div>
								<!-- month -->
								<div class="col-sm-3">
									<select class="form-control" id="month" name="month">
										<option disabled selected>月</option>
									</select>
								</div>
								<!-- date -->
								<div class="col-sm-3">
									<select class="form-control" id="date" name="date">
										<option disabled selected>日</option>
									</select>
								</div>
							</div>
							<!-- phoneNumber -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="phoneNumber">電話:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="範例 : 0912345678 or 0228761234" id="phoneNumber" name="phoneNumber" value="{{auth()->user()->phone_number}}">
								</div>
							</div>
							<!-- selfIntroduction -->
							<div class="form-group">
								<label class="control-label col-sm-2"for="selfIntroduction">自我介紹:</label>
								<div class="col-sm-10">
									<textarea class="form-control" rows="5" id="selfIntroduction" name="selfIntroduction">{{auth()->user()->self_introduction}}</textarea>
								</div>
							</div>
							<!-- subimt button -->
							<div class="form-group">
								<div class="col-sm-2"></div>
								<div class="col-sm-10">
									<input type="submit" class="btn btn-default" value="儲存資料">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection