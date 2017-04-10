@extends('layout.frame')

@section('content')
	<div class="topBox">
		<div class="left {{config('app.locale') == 'zh_cn' ? 'logo' : 'logo_en'}}"></div>
		<ul class="topMenu left">
			<li class="on"><a class="index" href="{{url('factoryset/customizeSetting')}}"><span>{{trans('menu.Reset')}}</span></a></li>
		</ul>
		<ul class="topUser right">
			<li class="user"><a href="#"><i style="background: url({{ asset('/img/logos') }}/{{config('app.airline_company')}}/{{'user_logo.png'}}) repeat 0 0;"></i><span>{{trans('menu.Hello')}}!{{trans('menu.Factory Set')}}</span></a></li>
			<li class="loginOut"><a href="{{url('logout')}}"><i></i><span>{{trans('menu.Exit')}}</span></a></li>
		</ul>
	</div>
	<div class="left leftMenu">
		<ul>
			<li class="on"><a href="{{url('factoryset/customizeSetting')}}">{{trans('menu.SystemCustomize')}}</a></li>
		</ul>
	</div>
	<div class="left rightCont">
		<div>
			<div class="reset_Setting blockBox mtop10">
				<h3 class="text-left mtop10"><?php echo trans("航空公司");?></h3>
				<div class="select_box">
					<p>
						<a href="#" class="al"></a>
						<span>{{trans('中国南方航空')}}</span>
						<a href="#" class="ar"></a>
					</p>
				</div>
				<h3 class="text-left">{{trans('语言选择')}}</h3>
				<div class="select_box">
					<p>
						<a href="#" class="al"></a>
						<span>{{trans('中文')}}</span>
						<a href="#" class="ar"></a>
					</p>
				</div>
				<h3 class="text-left">{{trans('主题选择')}}</h3>
				<div class="select_box">
					<p>
						<a href="#" class="al"></a>
						<span>{{trans('暗黑主题')}}</span>
						<a href="#" class="ar"></a>
					</p>
				</div>
				<div class="mtop10"></div>
			</div>
		</div>
	</div>
@stop

@section('footer')
	<script type="text/javascript" src='{{asset('js/factoryReset.js')}}'></script>
@stop