@extends('layout.frame')

@section('content')
	<div class="topBox">
		<div class="left {{config('app.locale') == 'zh_cn' ? 'logo' : 'logo_en'}}"></div>
		<ul class="topMenu left">
			<li class=""><a class="index" href="{{url('maintenance/topo')}}"><span>{{trans('menu.Home')}}</span></a></li>
			<li class=""><a class="monitor" href="{{url('maintenance/list')}}"><span>{{trans('menu.Device')}}</span></a></li>
			<li class=""><a class="maintenance" href="{{url('maintenance/bite')}}"><span>{{trans('menu.Maintain')}}</span></a></li>
			<li class="on"><a class="system" href="{{url('maintenance/operateLog')}}"><span>&nbsp;{{trans('menu.Information')}}&nbsp;</span></a></li>
		</ul>
		<ul class="topUser right">
			<li class="user"><a href="#"><i style="background: url({{ asset('/img/logos') }}/{{config('app.airline_company')}}/{{'user_logo.png'}}) repeat 0 0;"></i><span>{{trans('menu.Hello')}}!{{trans('menu.Maintenance')}}</span></a></li>
			<li class="loginOut"><a href="{{url('logout')}}"><i></i><span>{{trans('menu.Exit')}}</span></a></li>
		</ul>
	</div>
	<div class="left leftMenu">
		<ul>
			<li class="on"><a href="{{url('maintenance/operateLog')}}">{{trans('menu.Logs')}}</a></li>
			<li class=""><a href="{{url('maintenance/version')}}">{{trans('menu.Version')}}</a></li>
		</ul>
	</div>
	<div class="left rightCont">
		<ul class="threeMenu right">
			<li class=""><a href="{{url('maintenance/operateLog')}}">{{trans('menu.Operate Log')}}</a></li>
			<li class=""><a href="{{url('maintenance/dialLog')}}">{{trans('menu.Dial Log')}}</a></li>
			{{--<li class=""><a href="{{url('maintenance/flightLog')}}">{{trans('menu.Flight Log')}}</a></li>--}}
			<li class="on"><a href="{{url('maintenance/alarmLog')}}">{{trans('menu.Alarm Log')}}</a></li>
			<li class=""><a href="{{url('maintenance/runningLog')}}">{{trans('menu.Running Log')}}</a></li>
		</ul>
		<div class="clear"></div>
		<table class="Table mtop15">
			<tr>
				<th>{{trans('设备名称')}}</th>
				<th>{{trans('告警级别')}}</th>
				<th class="filterBox">
					<span>{{trans('告警内容')}}</span>
					<a href="#" onclick="showSearchForm();">
						<i class="icoFilter"></i>{{trans('筛选')}}
					</a>
				</th>
			</tr>
			@foreach($alarmLogList as $alarmLog)
			<tr onclick="showAlarmDetail({{$alarmLog->ID}});">
				<td>{{$alarmLog->Name}}</td>
				<td>
					<span class="label
					@if ($alarmLog->AlarmLevel === 1)
							label-info
                    @elseif ($alarmLog->AlarmLevel === 2)
							label-alert
                    @elseif ($alarmLog->AlarmLevel === 3)
							label-danger
                    @else
					@endif">
						@if ($alarmLog->AlarmLevel === 1)
							{{trans('信息')}}
						@elseif ($alarmLog->AlarmLevel === 2)
							{{trans('警告')}}
						@elseif ($alarmLog->AlarmLevel === 3)
							{{trans('错误')}}
						@else

						@endif
					</span>
				</td>
				<td class="{{$alarmLog->ClearFlag ? "mss_ok" : "mss_ror"}}">
					<span>[{{$alarmLog->AlarmOccurTime}}]---[{{$alarmLog->AlarmExtendInfo}}]:  {{$alarmLog->AlarmProbalCause}}</span>
				</td>
			</tr>
		    @endforeach
		</table>

		<div class="mtop15">
			{{ $alarmLogList->links() }}
		</div>
	</div>



	<div id="searchForm" class="hidden">
		<div class="Screening mtop10">
			<ul>
				<li id="dev_type">
					<label>设备：</label>
					<a href="#" class="on"><i class="checkbox_on" id="-1"></i>全部</a>
					<a href="#" class="on"><i class="checkbox" id="4"></i>Server</a>
					<a href="#" class="on"><i class="checkbox" id="15"></i>CAP</a>
				</li>
				<li id="alarm_level">
					<label>级别：</label>
					<a href="#" class="on"><i class="checkbox_on" id="-1"></i>全部</a>
					<a href="#" class="on"><i class="checkbox" id="0"></i>信息</a>
					<a href="#" class="on"><i class="checkbox" id="1"></i>告警</a>
					<a href="#" class="on"><i class="checkbox" id="2"></i>错误</a>
				</li>
				<li id="clear_status">
					<label>状态：</label>
					<a href="#" class="on"><i class="checkbox_on" id="-1"></i>全部</a>
					<a href="#" class="on"><i class="checkbox" id="0"></i>当前告警</a>
					<a href="#" class="on"><i class="checkbox" id="1"></i>历时告警</a>
				</li>
				<li>
					<label>时间：</label>
					<input id="start_time" type="text" class="ipt" value="" onclick="clearError();showKeyboard(this, 20, 'all', '-1')" placeholder="请输入开始时间">
					至
					<input id="end_time" type="text" class="ipt" value="" onclick="clearError();showKeyboard(this, 20, 'all', '-1')" placeholder="请输入结束时间">
				</li>
			</ul>
		</div>
	</div>

	@include('common.keyboard')
@stop




@section('footer')
	<script type="text/javascript" src='{{asset('/js/validator.js')}}'></script>
	<script type="text/javascript" src="{{asset('/js/alarmLog.js')}}"></script>
@stop