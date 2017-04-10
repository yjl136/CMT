@extends('layout.frame')

@section('content')
	<div class="topBox">
		<div class="left {{config('app.locale') == 'zh_cn' ? 'logo' : 'logo_en'}}"></div>
		<ul class="topMenu left">
			<li class=""><a class="index" href="{{url('maintenance/topo')}}"><span>{{trans('menu.Home')}}</span></a></li>
			<li class=""><a class="monitor" href="{{url('maintenance/list')}}"><span>{{trans('menu.Device')}}</span></a></li>
			<li class="on"><a class="maintenance" href="{{url('maintenance/bite')}}"><span>{{trans('menu.Maintain')}}</span></a></li>
			<li class=""><a class="system" href="{{url('maintenance/operateLog')}}"><span>&nbsp;{{trans('menu.Information')}}&nbsp;</span></a></li>
		</ul>
		<ul class="topUser right">
			<li class="user"><a href="#"><i style="background: url({{ asset('/img/logos') }}/{{config('app.airline_company')}}/{{'user_logo.png'}}) repeat 0 0;"></i><span>{{trans('menu.Hello')}}!{{trans('menu.Maintenance')}}</span></a></li>
			<li class="loginOut"><a href="{{url('logout')}}"><i></i><span>{{trans('menu.Exit')}}</span></a></li>
		</ul>
	</div>
	<div class="left leftMenu">
		<ul>
			<li class=""><a href="{{url('maintenance/bite')}}">{{trans('menu.Bite')}}</a></li>
			<li class=""><a href="{{url('maintenance/sysUpgrade')}}">{{trans('menu.SysUpgrade')}}</a></li>
			<li class=""><a href="{{url('maintenance/sysBackup')}}">{{trans('menu.SysBackup')}}</a></li>
			<li class="on"><a href="{{url('maintenance/progUpdate')}}">{{trans('menu.ProUpdate')}}</a></li>
			<li class=""><a href="{{url('maintenance/dataExport')}}">{{trans('menu.Export')}}</a></li>
			<li class=""><a href="{{url('maintenance/sysTest')}}">{{trans('menu.Test')}}</a></li>
		</ul>
	</div>
	<div class="left rightCont">
		<div class="scrollTex" id="stepbox">
			<span class="b1 on" id="step1">{{trans('系统检测')}}</span>
			<span class="b2" id="step1">{{trans('查询更新')}}</span>
			<span class="b3" id="step3">{{trans('更新节目包')}}</span>
			<span class="b4" id="step4">{{trans('清理垃圾媒体文件')}}</span>
		</div>
		<div class="scrollBarBg">
			<div class="on b1" id="scrollbar"></div>
		</div>
		<div class="blockBox mtop10" id="step1box">
			<div class="Screening">
				<ul>
					<li id="transWayBox">
						<label>{{trans('更新方式：')}}</label>
						<a href="#" class="on">
							<i id="1" class="checkbox_on"></i>{{trans('USB')}}
						</a>
						<a href="#" class="on">
							<i id="11" class="checkbox"></i>{{trans('PDL')}}
						</a>
					</li>
				</ul>
			</div>
			<p class="message">
				<i class="icoPop"></i>
				{{trans('说明：多尼卡节目更新是对视频点播网站的节目源（包括电影，电视，音乐，电子书等）进行更新。请接入设备后，点击<下一步>。')}}
			</p>
			<div class="subBox">
				<a class="Buton" href="#" onclick="checkTransWay();">{{trans('下一步')}}</a>
			</div>
		</div>
		<div class="blockBox mtop10 hidden" id="step2box">
			<div class="Screening">
				<ul>
					<li>
						<label>{{trans('创建时间:')}}</label>
						<span id="create_time"></span>
					</li>
					<li>
						<label>{{trans('节目描述:')}}</label>
						<span id="desc"></span>
					</li>
				</ul>
			</div>
			<div class="subBox">
				<a href="#" class="Buton" onclick="startProgUpdate();">{{trans('下一步')}}</a>
				<a href="#" class="Buton" onclick="init();">{{trans('返回')}}</a>
			</div>
		</div>
		<div class="blockBox mtop10 hidden"  id="step3box">
			<div class="loading">
				<p id="progressmsg"></p>
				<div class="bg">
					<label id="pg_percent">0%</label>
					<span id="pg_bar" style="width:0%"></span>
				</div>
			</div>
		</div>
		<div class="blockBox mtop10 hidden" id="step4box">
			<p class="message">
				<i class="icoSuccess"></i>
				{{trans('节目更新成功，正在清理媒体文件，可能需要消耗几分钟，请稍候...')}}
			</p>
			<div class="subBox">
				<a href="#" class="Buton" onclick="init();">{{trans('返回')}}</a>
			</div>
		</div>
		<div class="hidden" id="msgbox"></div>
	</div>
@stop

@section('footer')
	<script type="text/javascript" src='{{asset('/js/programUpdate.js')}}'></script>
	<script type="text/javascript" src='{{asset('/js/common.js')}}'></script>
@stop