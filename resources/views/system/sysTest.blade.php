@extends('layout.frame')

@section('content')
	<div class="topBox">
		<div class="left {{config('app.locale') == 'zh_cn' ? 'logo' : 'logo_en'}}"></div>
		<ul class="topMenu left">
			<li class=""><a class="index" href="{{url('topo')}}"><span>{{trans('menu.Home')}}</span></a></li>
			<li class=""><a class="monitor" href="{{url('list')}}"><span>{{trans('menu.Device')}}</span></a></li>
			<li class=""><a class="config" href="{{url('receiver')}}"><span>{{trans('menu.Config')}}</span></a></li>
			<li class="on"><a class="maintenance" href="{{url('bite')}}"><span>{{trans('menu.Maintain')}}</span></a></li>
			<li class=""><a class="system" href="{{url('operateLog')}}"><span>&nbsp;{{trans('menu.Information')}}&nbsp;</span></a></li>
		</ul>
		<ul class="topUser right">
			<li class="user"><a href="#"><i style="background: url({{ asset('/img/logos') }}/{{config('app.airline_company')}}/{{'user_logo.png'}}) repeat 0 0;"></i><span>{{trans('menu.Hello')}}!{{trans('menu.Super Admin')}}</span></a></li>
			<li class="loginOut"><a href="{{url('logout')}}"><i></i><span>{{trans('menu.Exit')}}</span></a></li>
		</ul>
	</div>
	<div class="left leftMenu">
		<ul>
			<li class=""><a href="{{url('bite')}}">{{trans('menu.Bite')}}</a></li>
			<li class=""><a href="{{url('sysUpgrade')}}">{{trans('menu.SysUpgrade')}}</a></li>
			{{--<li class=""><a href="{{url('sysBackup')}}">{{trans('menu.SysBackup')}}</a></li>--}}
			<li class=""><a href="{{url('progUpdate')}}">{{trans('menu.ProUpdate')}}</a></li>
			<li class=""><a href="{{url('dataExport')}}">{{trans('menu.Export')}}</a></li>
			<li class="on"><a href="{{url('sysTest')}}">{{trans('menu.Test')}}</a></li>
		</ul>
	</div>
	<div class="left rightCont">
		<div class="ap_state_box">
			<div class="blockBox mtop10 ap_box">
				<div class="h3">
					<h3 class="left">{{trans('content.WiFi Control Mode')}}: &nbsp;</h3>
					<div class="ap_state left">
						<a href="#" class="on" id="btn_auto" onclick="switchWifiMode(0);">{{trans('button.Auto')}}</a>
						<a href="#" id="btn_manual" onclick="switchWifiMode(1);">{{trans('button.Manual')}}</a>
					</div>
				</div>
				<p class="alt">
					<b>{{trans('content.Note')}}</b>
					<br />
					{{trans('content.The default mode is auto mode, and it will turn back to auto mode when turns to manual mode after 30 minites.')}}
					<a href="#" class="reset" onclick="sendReset();">{{trans('button.Reset Factory')}}</a>
				</p>
				<ul id="ap_box">
					<li class="tloading" id="CAP-1">
						<span></span>
						<label>CAP-1</label>
						<a href="#" class="hidden" onclick="switchAP(1);">
							<em>off</em>
						</a>
					</li>
					<li class="online" id="CAP-2">
						<span></span>
						<label>CAP-2</label>
						<a href="#" class="hidden" onclick="switchAP(2);">
							<em>on</em>
						</a>
					</li>
					<li class="" id="CAP-3">
						<span></span>
						<label>CAP-3</label>
						<a href="#" class="hidden" onclick="switchAP(3);">
							<em>off</em>
						</a>
					</li>
				</ul>
				<div class="clear"></div>
				<p class="redMessage hidden" id="msgbox">
					<i id="msgicon" class="icoFail"></i>
					<span id="msg"></span>
				</p>
			</div>
			<p class="subBox mtop10 hidden" id="btn_box">
				<a href="#" class="gayButon" id="btn_open" onclick="switchWifi(1);">{{trans('button.Open All')}}</a>
				<a href="#" class="gayButon" id="btn_close" onclick="switchWifi(0);">{{trans('button.Close All')}}</a>
				<a href="#" class="Buton" id="btn_time" onclick="forceSwitchMode();">{{trans('button.Remain Time')}}</a>
			</p>
		</div>
	</div>
@stop

@section('footer')
	<script type="text/javascript" src='{{asset('/js/systemTest.js')}}'></script>
@stop