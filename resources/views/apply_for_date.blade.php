@extends('master')
@section('title','Apply_for_date')
@section('custom css')
<link rel="stylesheet" type="text/css" href="css/apply_for_date.css">
@endsection
@section('custom js')
<script type="text/javascript" src="scripts/apply_for_date.js"></script>
@endsection
@section('content')
	<div class="container">
		<div class="jumbotron" >
			<h1 class="text-center text-bold">今晚想要什麼樣的風格呢 <i class="fa fa-heart red"></i></h1>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-body inner">
						<h4 class="panel-heading col-sm-12" style="background:white">晚餐選項</h4>
						<form class="form-horizontal">
							<!-- area -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="area">*用餐城市:</label>
								<div class="col-sm-10">
									<select class="form-control" id="area">
										<option disabled selected>城市</option>
										<option>台北</option>
										<option>新竹</option>
									</select>
								</div>
							</div>
							<!-- time duration -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="startTime">*用餐時段:</label>
								<div class="col-sm-4">
									<select class="form-control" id="startTime">
										<option disabled selected>開始時間</option>
										<option>隨時奉陪</option>
										<option>17:30</option>
										<option>18:00</option>
									</select>
								</div>
								<span class="control-label col-sm-2" style="text-align:center">到</span>
								<div class="col-sm-4">
									<select class="form-control" id="endTime">
										<option disabled selected>結束時間</option>
										<option>天荒地老</option>
										<option>18:00</option>
										<option>18:30</option>
									</select>
								</div>
							</div>
							<!-- vegetarian -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="vegetarian">素食:</label>
								<div class="col-sm-10">
									<select class="form-control" id="vegetarian">
										<option>我都可以唷</option>
										<option>否</option>
										<option>是</option>
									</select>
								</div>
							</div>
							<!-- meal type -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="mealType">餐點類型:</label>
								<div class="col-sm-10">
									<select class="form-control" id="mealType">
										<option>我都可以唷</option>
										<option>西餐</option>
										<option>中餐</option>
									</select>
								</div>
							</div>
							<!-- sex constraint -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="sex">餐伴性別 (VIP 限定):</label>
								<div class="col-sm-10">
									<select class="form-control" id="sex" disabled="disabled">
										<option>不限</option>
										<option>男</option>
										<option>女</option>
									</select>
								</div>
							</div>
							<!-- dress code -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="dressCode">Dress code:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="dressCode" placeholder="範例 : 天體營, 迪士尼卡通">
								</div>
							</div>
							<!-- selfIntroduction -->
							<div class="form-group">
								<label class="control-label col-sm-2"for="selfIntroduction">想與餐伴說:</label>
								<div class="col-sm-10">
									<textarea class="form-control" rows="5" id="selfIntroduction" placeholder="很高興可以跟妳/你一起吃飯:)"></textarea>
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
