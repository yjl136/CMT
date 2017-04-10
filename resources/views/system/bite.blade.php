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
			<li class="on"><a href="{{url('bite')}}">{{trans('menu.Bite')}}</a></li>
			<li class=""><a href="{{url('sysUpgrade')}}">{{trans('menu.SysUpgrade')}}</a></li>
			<li class=""><a href="{{url('sysBackup')}}">{{trans('menu.SysBackup')}}</a></li>
			<li class=""><a href="{{url('progUpdate')}}">{{trans('menu.ProUpdate')}}</a></li>
			<li class=""><a href="{{url('dataExport')}}">{{trans('menu.Export')}}</a></li>
			<li class=""><a href="{{url('sysTest')}}">{{trans('menu.Test')}}</a></li>
		</ul>
	</div>
	<div class="left rightCont">
		<div class="Testing_box blockBox mtop10">
			<ul class="btn_ctrl">
				@foreach($biteParam as $bite)
				<li onclick="{{"bite(this,'$bite->DevID')"}}" class="">
					<a href="#" class="img_{{strtolower($bite->Name)}}">{{$bite->Name}}{{$bite->DevType==15 ? substr($bite->DevPosition,-2) : ''}}</a>
					<span></span>
				</li>
				@endforeach
			</ul>
		</div>
		<!-- 结果信息页面 -->
		<div class="blockBox mtop10 hidden" id="msgbox">
			<p class="redMessage" id="msgwrap"><i id="msgicon" class="icoFail"></i><span id="msg"></span></p>
		</div>
	</div>
@stop

@section('footer')
	<script type="text/javascript" src='{{asset('/js/bite.js')}}'></script>
@stop