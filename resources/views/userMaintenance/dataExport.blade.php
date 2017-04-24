@extends('layout.frame')

@section('content')
	<div class="topBox">
		<div class="left {{config('app.locale') == 'zh_cn' ? 'logo' : 'logo_en'}}"></div>
		<ul class="topMenu left">
			<li class=""><a class="index" href="{{url('topo')}}"><span>{{trans('menu.Home')}}</span></a></li>
			<li class=""><a class="monitor" href="{{url('list')}}"><span>{{trans('menu.Device')}}</span></a></li>
			<li class="on"><a class="maintenance" href="{{url('bite')}}"><span>{{trans('menu.Maintain')}}</span></a></li>
			<li class=""><a class="system" href="{{url('operateLog')}}"><span>&nbsp;{{trans('menu.Information')}}&nbsp;</span></a></li>
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
			{{--<li class=""><a href="{{url('maintenance/sysBackup')}}">{{trans('menu.SysBackup')}}</a></li>--}}
			<li class=""><a href="{{url('maintenance/progUpdate')}}">{{trans('menu.ProUpdate')}}</a></li>
			<li class="on"><a href="{{url('maintenance/dataExport')}}">{{trans('menu.Export')}}</a></li>
			<li class=""><a href="{{url('maintenance/sysTest')}}">{{trans('menu.Test')}}</a></li>
		</ul>
	</div>
	<div class="left rightCont">
		<ul class="threeMenu right">
			<li class="on">
				<a href="{{url('maintenance/dataExport')}}">{{trans('menu.Manually Export')}}</a>
			</li>
			<li class="">
				<a href="{{url('maintenance/autoExport')}}">{{trans('menu.Auto Export')}}</a>
			</li>
		</ul>
		<div class="clear"></div>
		<div class="scrollTex">
			<span id="step1" class="on x1">{{trans('maintain.selectconditions')}}</span>
			<span id="step2" class="x2">{{trans('maintain.resultinformation')}}</span>
		</div>
		<div class="scrollBarBg">
			<div id="progBar" class="on x1"></div>
		</div>
		<div id="conditionBox">
			<div class="Screening blockBox mtop10">
				<ul>
					<li id="transWayBox">
						<label>{{trans('maintain.transfermethod')}}</label>
						@foreach($transWays as $key => $value)
							<a href="#" class="on">
								<i class="{{$value["checked"] ? "checkbox_on" : "checkbox"}}" id="{{$key}}"></i>{{$value["text"]}}
							</a>
						@endforeach

					</li>
					<li id="formatTypeBox">
						<label>{{trans('maintain.fileformat')}}</label>
						@foreach($formatTypes as $key => $value)
							<a href="#" class="on">
								<i class="{{$value["checked"] ? "checkbox_on" : "checkbox"}}" id="{{$key}}"></i>{{$value["text"]}}
							</a>
						@endforeach
					</li>
					<li>
						<label>{{trans('maintain.dateperiod')}}</label>
						<input id="startTime" type="text" class="ipt"  value="{{date("Y-m-d", time()-1209600)}}" onclick="clearError();showKeyboard(this, 20, 'num', '-1')"/>
						&nbsp;{{trans('maintain.to')}}&nbsp;
						<input id="endTime" type="text" class="ipt" value="{{date("Y-m-d", time())}}" onclick="clearError();showKeyboard(this, 20, 'num', '-1')"/>
					</li>
				</ul>
			</div>
			<div class="subBox">
				<a href="#" class="Buton" onclick="checkTransWay();">{{trans('maintain.export')}}</a>
			</div>

		</div>
		<!-- 结果信息000页面 -->
		<div class="hidden" id="msgbox" >
		</div>
	</div>
	@include('common.keyboard')
@stop

@section('footer')


	<script type="text/javascript" src='{{asset('/keyboard/js/keyboard.js')}}'></script>
	<script type="text/javascript" src='{{asset('/js/dataExport.js')}}'></script>
	<script type="text/javascript" src='{{asset('/js/common.js')}}'></script>
	<script type="text/javascript" src='{{asset('/js/validator.js')}}'></script>
@stop