<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- bootstrap css -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!-- Jcrop css -->
	<link rel="stylesheet" href="/laravel_date/public/css/jquery.Jcrop.css" type="text/css" />
	<!-- custom css -->
	<link rel="stylesheet" type="text/css" href="/laravel_date/public/css/profile.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- bootstrap javascript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<!-- Jcrop -->
	<script src="/laravel_date/public/js/jquery.Jcrop.js"></script>
	<!-- custom javascript -->
	<script type="text/javascript" src="/laravel_date/public/js/profile.js"></script>
</head>
<body>
	<div class="container-fluid">
	    @if(isset($path))
	    <h1>{{ $path }}</h1>
	    @endif
		<h1>Hello world</h1>
		<p>Hello again</p>
		<!-- modal trigger button -->
		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#profileImgModal" data-backdrop="static">change profile picture</button>
		<!-- profileImg modal -->
		<div id="profileImgModal" class="modal fade">
			<div class="modal-dialog">
				<form method="post" enctype="multipart/form-data">
    			{!! csrf_field() !!}
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
				    		<div class="previewContainer">
				    			<img id="previewImg" alt="file not found" src="/laravel_date/public/resource/flower.jpg">
				    		</div>
				    		<input type='file' name="uploadImg" id="uploadImg"/>
				    	</div>
				    	<!-- footer -->
				    	<div class="modal-footer">
				    		<input value="Submit" type="submit" class="btn btn-default" style="float:left">
				    		<button class="btn btn-default" data-dismiss="modal">Close</button>
				    	</div>
				    </div>
			    </form>
			</div>
		</div>
	</div>
</body>
</html>