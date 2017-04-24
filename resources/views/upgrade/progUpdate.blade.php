@extends('layout.frame')

@section('content')
		<!-- 顶部导航栏和状态栏 -->
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
		<li class="on"><a href="{{url('progUpdate')}}">{{trans('menu.ProUpdate')}}</a></li>
		<li class=""><a href="{{url('dataExport')}}">{{trans('menu.Export')}}</a></li>
		<li class=""><a href="{{url('sysTest')}}">{{trans('menu.Test')}}</a></li>
	</ul>
</div>
<div class="left rightCont">
	<!-- 步骤说明 -->
	<div class="scrollTex" id="stepbox">
		<span class="b1 on" id="step1">{{trans('maintain.detectsystem')}}</span>
		<span class="b2" id="step1">{{trans('maintain.queryversion')}}</span>
		<span class="b3" id="step3">{{trans('maintain.updateprograms')}}</span>
		<span class="b4" id="step4">{{trans('maintain.clearmedia')}}</span>
	</div>
	<div class="scrollBarBg">
		<div class="on b1" id="scrollbar"></div>
	</div>
	<!-- 第一步 -->
	<div class="blockBox mtop10" id="step1box">
		<div class="Screening">
			<ul>
				<li id="transWayBox">
					<label>{{trans('maintain.updatemethod')}}</label>
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
			{{trans('maintain.proupdatedes')}}
		</p>
		<div class="subBox">
			<a class="Buton" href="#" onclick="checkTransWay();">{{trans('maintain.next')}}</a>
		</div>
	</div>
	<!-- 第二步 -->
	<div class="blockBox mtop10 hidden" id="step2box">
		<div class="Screening">
			<ul>
				<li>
					<label>{{trans('maintain.createtime')}}</label>
					<span id="create_time"></span>
				</li>
				<li>
					<label>{{trans('maintain.programdescription')}}</label>
					<span id="desc"></span>
				</li>
			</ul>
		</div>
		<div class="subBox">
			<a href="#" class="Buton" onclick="startProgUpdate();">{{trans('maintain.next')}}</a>
			<a href="#" class="Buton" onclick="init();">{{trans('maintain.back')}}</a>
		</div>
	</div>
	<!-- 第三步 -->
	<div class="blockBox mtop10 hidden"  id="step3box">
		<div class="loading">
			<p id="progressmsg"></p>
			<div class="bg">
				<label id="pg_percent">0%</label>
				<span id="pg_bar" style="width:0%"></span>
			</div>
		</div>
	</div>
	<!-- 第四步 -->
	<div class="blockBox mtop10 hidden" id="step4box" >
		<p class="message">
			<i class="icoSuccess"></i>
			{{trans('maintain.clearing')}}
		</p>
		<div class="subBox">
			<a href="#" class="Buton" onclick="init();">{{trans('maintain.back')}}</a>
		</div>
	</div>
	<!-- 结果信息页面 -->
	<div class="hidden" id="msgbox"></div>
</div>
@stop

@section('footer')
	<script type="text/javascript" src='{{asset('/js/common.js')}}'></script>
	<script type="text/javascript" src='{{asset('/js/programUpdate.js')}}'></script>

@stop