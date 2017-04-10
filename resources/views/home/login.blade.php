<!doctype html>
<html lang="{{config('app.locale')}}">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="_token" content="{{ csrf_token() }}"/>
	<title>{{trans('空中娱乐管理系统')}}</title>
	<link rel="shortcut icon" href="{{asset('img/logos')}}/{{config('app.airline_company')}}/{{'favicon.ico'}}" />
	<link href="{{ config('app.theme')}}/{{'/css/style.css' }}" type="text/css" rel="stylesheet"/>
</head>
<body class="mainbody">
<div class="w1280">
	<div class="menu">
		<div class="{{config('app.locale') == 'zh_cn' ? 'logo' : 'logo_en'}}"></div>
		<div class="user">
			<a href="#">
				<i></i>
				<span>{{trans('button.Admin')}}</span>
			</a>
		</div>
		<div class="login" id="login_do">
			<div class="ipt">
				<input id="password" type="password" value="" />
			</div>
			<div class="tip_message"></div>
			<div class="nub">
				<button class="a7"></button>
				<button class="a8"></button>
				<button class="a9"></button>
				<button class="a4"></button>
				<button class="a5"></button>
				<button class="a6"></button>
				<button class="a1"></button>
				<button class="a2"></button>
				<button class="a3"></button>
				<button class="a0"></button>
				<button class="del"></button>
			</div>
			<div class="btn_en">
				<button></button>
			</div>
			<div class="side">
				<a href="#"></a>
			</div>
		</div>
	</div>

	<div class="detection">
		<div class="message message_ror ">
			<div class="fix">
				<div class="message_list">
					<div>
						<span class="btn_up"></span>
						<p>
							@foreach($message_list as $message)
								<a href="#">{{$message->Description}}</a>
							@endforeach
						</p>
					</div>
				</div>
			</div>
		</div>

		<div id="diagnose_status" class="cont ror">
			<div class="ico">
				<p></p>
				<i id="progress"><span></span><em>Loading</em></i>
			</div>
			<div class="text">
				<h3 id="diagnose_result">{{$diagnose_message}}</h3>
				<p id="message_count">
				</p>
			</div>
		</div>
		<a href="#" class="{{config('app.locale') == 'zh_cn' ? 'btn_jiance' : 'btn_jiance_en'}}" id="btn_onekey" onclick="onekeybite(this);"></a>
	</div>


	<div class="statusbar" id="param_status">
		<ul class="left">
			<li id="status_wifi" class="{{$status['status_wifi'] == 0 ? '' : 'dis'}}">
				<i class="wifi"></i>
				<span>{{$status['status_wifi'] == 0 ? 'Online' : 'Offline'}}</span>
			</li>
			<li id="status_online_users">
				<i class="nb">{{$status['status_online_users']}}</i>
				<span>{{trans('content.Online Users')}}</span>
			</li>
		</ul>
		<ul class="mid">
			<li>
				<a href="#" id="kg_wifi" class="{{$status['status_wifiswitch'] == 0 ? 'close' : 'open'}}" onclick="switchWifi();"></a>
				<span>Wi-Fi</span>
			</li>
			<li>
				<a href="#" id="kg_4g" class="{{$status['status_4gswitch'] == 0 ? 'close' : 'open'}}" onclick="switch4G();"></a>
				<span>4G</span>
			</li>
		</ul>
		<ul class="right">
			<li id="status_pa" class="{{$status['status_pa'] == 0 ? '' : 'dis'}}">
				<i class="pa"></i>
				<span>PA</span>
			</li>
			<li id="status_4g" class="{{$status['status_4g'] == 0 ? '' : 'dis'}}">
				<i class="g4"></i>
				<span>4G</span>
			</li>
			<li id="status_wow" class="{{$status['status_wow'] == 0 ? '' : 'dis'}}">
				<i class="wow"></i>
				<span>WoW</span>
			</li>
			<li id="status_door" class="{{$status['status_door'] == 0 ? '' : 'dis'}}">
				<i class="door"></i>
				<span>Door</span>
			</li>
		</ul>
	</div>

	<div class="menu_bottom" id="new_version">
		{{--<div class="language" id="lang">--}}
			{{--<div><a class="ck">中文 <i></i></a></div>--}}
			{{--<div>--}}
				{{--<p>--}}
					{{--<a href="#">中文</a>--}}
					{{--<a href="#">English</a>--}}
				{{--</p>--}}
			{{--</div>--}}
		{{--</div>--}}
		{{--@if ($ftp_version_flag->var_value == 0)--}}
			{{--<div class="time" style="color: #e90;">有最新版本：{{$ftp_version->var_value}}</div>--}}
			{{--<div id="cur_time" class="time" style="display: none;"></div>--}}
		{{--@else--}}
			{{--<div id="cur_time" class="time"></div>--}}
		{{--@endif--}}
		{{--<div class="screen">--}}
			{{--<a href="#" style="cursor: default;">LAN<i class="{{$status['status_lan'] == 0 ? 'lan' : 'lan_'}}"></i></a>--}}
			{{--<a href="#" style="cursor: default;">USB<i class="{{$status['status_usb'] == 0 ? 'usb' : 'usb_'}}"></i></a>--}}
		{{--</div>--}}
	</div>
	<input id="utc_flag" name="utc_flag" type="hidden" value="{{$timeType==1 ? '1' : '0'}}" />
</div>
<script type="text/javascript" src="{{ asset('/widget/jquery-3.1.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/Trans.js') }}"></script>
<script type="text/javascript" src="{{ asset('/widget/axios.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/homepage.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/lang.js') }}"></script>
<script type="text/javascript" src="{{asset('/widget/jquery.i18n.properties.js')}}"></script>
<script type="text/javascript" src="{{ asset('/layer/layer.js') }}"></script>
</body>
</html>
