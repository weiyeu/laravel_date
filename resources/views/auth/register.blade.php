@extends('master')
@section('title','Register')
@section('custom css')
<!-- profile css -->
<link rel="stylesheet" type="text/css" href="/laravel_date/public/css/profile.css">
<!-- custom css -->
<link rel="stylesheet" type="text/css" href="/laravel_date/public/css/register.css">
@endsection
@section('custom js')
<!-- profile javascript -->
<script type="text/javascript" src="/laravel_date/public/scripts/profile.js"></script>
<!-- custom javascript -->
<script type="text/javascript" src="/laravel_date/public/scripts/register.js"></script>
@endsection
@section('content')
	<div class="container">
		<div class="jumbotron" >
			<h1 class="text-center text-bold">申請帳號 <i class="fa fa-heart"></i></h1>
		</div>
		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="panel panel-default">
					<div class="panel-body inner">
						<h4 class="panel-heading" style="background:white">填寫基本資料</h4>
						@foreach ($errors->all() as $error)
                            <p class="alert alert-danger">{{ $error }}</p>
                        @endforeach
						<form class="form-horizontal" method="post" enctype="multipart/form-data">
    	                    {!! csrf_field() !!}
							<!-- profileImg  -->
							<div class="form-group">
								<label class="control-label col-sm-2">大頭貼:</label>
								<!-- modal trigger button -->
								<div class="col-sm-10">
									<div class="previewContainer" style="margin-left:0">
										<img id="smallProfileImg" alt="file not found" src="/laravel_date/public/resource/flower.jpg">
									</div>
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#profileImgModal" data-backdrop="static"><i class="fa fa-user"></i> 更換大頭貼</button>
								</div>
							</div>

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
											<button type="button" id="confirmUploadImg" class="btn btn-success pull-left hidden" data-dismiss="">確定上傳</button>
										</div>
									</div>
								</div>
							</div>
							<!-- nick name -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="nickName">*暱稱:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="nickName" name="nickName" placeholder="請填寫暱稱" label="暱稱" maxlength="70" value="{{old('nickName')}}" required>
									<div class="c-alert slide"></div>
								</div>
							</div>

							<!-- real name -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="realName">*真實姓名:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="realName" name="realName" placeholder="請填寫真實姓名" maxlength="70" value="{{old('realName')}}" required>
								</div>
							</div>
							<!-- Email -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="email">*Email:</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" maxlength="255" value="{{old('email')}}" required>
									<div class="c-alert slide"></div>
								</div>
							</div>
							<!-- password -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="password">*密碼:</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" id="password" name="password" placeholder="密碼最少四個字" minlength="4" required>
								</div>
							</div>
							<!-- confirm password -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="confirmPassword">*確認密碼:</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" id="confirmPassword" name="password_confirmation" placeholder="確認密碼"
									minlength="4" required>
									<div class="c-alert slide">
										<i class="fa fa-exclamation-triangle"></i>
									</div>
								</div>
							</div>
							<!-- sex -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="sex">*性別:</label>
								<div class="col-sm-10">
									<select class="form-control" id="sex" name="sex" required>
										<option disabled selected value="">null</option>
										<option value="male">男</option>
										<option value="female">女</option>
									</select>
								</div>
							</div>
							<!-- birthday -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="birthday">*生日:</label>
								<!-- year -->
								<div class="col-sm-4">
									<select class="form-control" id="year" name="year" required>
										<option disabled selected value="">年</option>
									</select>
								</div>
								<!-- month -->
								<div class="col-sm-3">
									<select class="form-control" id="month" name="month" required>
										<option disabled selected value="">月</option>
									</select>
								</div>
								<!-- date -->
								<div class="col-sm-3">
									<select class="form-control" id="date" name="date" required>
										<option disabled selected value="">日</option>
									</select>
								</div>
							</div>
							<!-- phoneNumber -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="phoneNumber">電話:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="範例 : 0912345678 or 0228761234" id="phoneNumber" value="{{old('phoneNumber')}}">
								</div>
							</div>
							<!-- selfIntroduction -->
							<div class="form-group">
								<label class="control-label col-sm-2"for="selfIntroduction">自我介紹:</label>
								<div class="col-sm-10">
									<textarea class="form-control" rows="5" id="selfIntroduction" name="selfIntroduction">{{old('selfIntroduction')}}</textarea>
								</div>
							</div>
							<!-- subimt button -->
							<div class="form-group">
								<div class="col-sm-2"></div>
								<div class="col-sm-10">
									<button type="submit" class="btn btn-primary" id="submit" >確定送出</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection