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
						<h4 class="panel-heading" style="background:white">晚餐選項</h4>
						@foreach ($errors->all() as $error)
                            <p class="alert alert-danger">{{ $error }}</p>
                        @endforeach
						<form class="form-horizontal" method="post">
   	                    {!! csrf_field() !!}
							<!-- city -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="city">*用餐城市:</label>
								<div class="col-sm-10">
									<select class="form-control" id="city" name="city">
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
									<select class="form-control" id="startTime" name="start_time">
										<option disabled selected>開始時間</option>
										<option value="0">隨時奉陪</option>
                                        @for($i = 17; $i < 24; $i++)
                                        <option value="{{$i.'00'}}">{{$i}}:00</option>
                                        <option value="{{$i.'30'}}">{{$i}}:30</option>
                                        @endfor
									</select>
								</div>
								<span class="control-label col-sm-2" style="text-align:center">到</span>
								<div class="col-sm-4">
									<select class="form-control" id="endTime" name="end_time">
										<option disabled selected>結束時間</option>
										<option value="0">天荒地老</option>
                                        @for($i = 17; $i < 24; $i++)
                                        <option value="{{$i.'30'}}">{{$i}}:30</option>
                                        <option value="{{($i+1).'00'}}">{{$i+1}}:00</option>
                                        @endfor
									</select>
								</div>
							</div>
							<!-- vegetarian -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="vegetarian">素食:</label>
								<div class="col-sm-10">
									<select class="form-control" id="vegetarian" name="vegetarian_type">
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
									<select class="form-control" id="mealType" name="meal_type">
										<option>我都可以唷</option>
										<option>西餐</option>
										<option>中餐</option>
									</select>
								</div>
							</div>
							<!-- sex constraint -->
							<div class="form-group">
								<label class="control-label col-sm-2" for="sex_constraint">餐伴性別 (VIP 限定):</label>
								<div class="col-sm-10">
									<select class="form-control" id="sex" name="sex_constraint">
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
									<input type="text" class="form-control" id="dressCode" name="dress_code" placeholder="範例 : 天體營, 迪士尼卡通" value="{{old('dress_code')}}">
								</div>
							</div>
							<!-- message -->
							<div class="form-group">
								<label class="control-label col-sm-2"for="message">想與餐伴說:</label>
								<div class="col-sm-10">
									<textarea class="form-control" rows="5" id="message" name="message" placeholder="很高興可以跟妳/你一起吃飯:)">{{old('message')}}</textarea>
								</div>
							</div>
							<!-- subimt button -->
							<div class="form-group">
								<div class="col-sm-2"></div>
								<div class="col-sm-10">
									<button type="submit" class="btn btn-default">儲存資料</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
