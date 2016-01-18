@extends('master')
@section('title','Change password')
@section('custom css')
<link rel="stylesheet" type="text/css" href="/laravel_date/public/css/profile.css">
@endsection
@section('custom js')
<script type="text/javascript" src="/laravel_date/public/scripts/change_password.js"></script>
@endsection
@section('content')
<!-- main container -->
	<div class="container">
		<div class="row">
			@include('profile.shared.left_list')
			<!-- main content -->
			<div class="col-sm-8">
				<div class="panel panel-default">
					<div class="panel-body inner">
						<h4 class="panel-heading" style="background:white">更改密碼</h4>
						<form class="form-horizontal" method="post" enctype="multipart/form-data">
   	                    {!! csrf_field() !!}
   	                        @foreach ($errors->all() as $error)
                                <p class="alert alert-danger">{{ $error }}</p>
                            @endforeach
                            @if(session('success'))
                                <p class="alert alert-success">{{ session('success') }}</p>
                            @endif
							<!-- old password -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="oldPassword">*舊密碼:</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" id="oldPassword" name="old_password" placeholder="請填寫舊密碼">
								</div>
							</div>
							<!-- new password -->
                            <div class="form-group">
                            	<label class="control-label col-sm-2" for="newPassword">*新密碼:</label>
                            	<div class="col-sm-10">
                            		<input type="password" class="form-control" id="newPassword" name="new_password" placeholder="請填寫新密碼">
                            	</div>
                            </div>
   							<!-- new password confirm -->
                            <div class="form-group">
                            	<label class="control-label col-sm-2" for="confirmNewPassword">*確認新密碼:</label>
                            	<div class="col-sm-10">
                            		<input type="password" class="form-control" id="confirmNewPassword" name="new_password_confirmation" placeholder="請確認密碼">
                            	</div>
                            </div>
							<!-- subimt button -->
							<div class="form-group">
								<div class="col-sm-2"></div>
								<div class="col-sm-10">
									<input type="submit" class="btn btn-default" value="更改密碼">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection