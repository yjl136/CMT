<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{trans('空中娱乐管理系统')}}</title>
    <link rel="shortcut icon" href="{{asset('img/logos/csa/favicon.ico')}}" />
    <link rel="shortcut icon" href="{{asset('img/logos')}}/{{config('app.airline_company')}}/{{'favicon.ico'}}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/base.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/home.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/config.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/system.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('')}}{{ config('app.theme')}}/{{'/css/sys.css' }}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('')}}{{ config('app.theme')}}/{{'/css/monitor.css' }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/keyboard/css/keyboard.css') }}"/>
</head>
<body class="mainbody">
<div class="main">
    <div class="topBox">
        <div class="left {{config('app.locale') == 'zh_cn' ? 'logo' : 'logo_en'}}"></div>
        <ul class="topMenu left">
            <li class=""><a class="index" href="{{url('maintenance/topo')}}"><span>{{trans('menu.Home')}}</span></a></li>
            <li class="on"><a class="monitor" href="{{url('maintenance/list')}}"><span>{{trans('menu.Device')}}</span></a></li>
            <li class=""><a class="maintenance" href="{{url('maintenance/bite')}}"><span>{{trans('menu.Maintain')}}</span></a></li>
            <li class=""><a class="system" href="{{url('maintenance/operateLog')}}"><span>&nbsp;{{trans('menu.Information')}}&nbsp;</span></a></li>
        </ul>
        <ul class="topUser right">
            <li class="user"><a href="#"><i style="background: url({{ asset('/img/logos') }}/{{config('app.airline_company')}}/{{'user_logo.png'}}) repeat 0 0;"></i><span>{{trans('menu.Hello')}}!{{trans('menu.Maintenance')}}</span></a></li>
            <li class="loginOut"><a href="{{url('logout')}}"><i></i><span>{{trans('menu.Exit')}}</span></a></li>
        </ul>
    </div>

    <div class="deLeft">
        <div class="left">
            <a href="{{url('maintenance/list')}}" class="btnBack">{{trans('button.Back to Device List')}}</a>
            <p class="devName">
                <label>{{trans('content.Device Name')}}: </label>
                <span>
                     @if($deviceDetail->Name == 'CAP')
                        {{$deviceDetail->Name}}-{{substr($deviceDetail->DevPosition,-1)}}
                    @else
                        {{$deviceDetail->Name}}
                    @endif
                </span>
            </p>
        </div>
        <ul class="threeMenu right mtop15">
            <li class=""><a href="{{url('maintenance/showDevice')}}/{{$deviceDetail->DevID}}">{{trans('menu.Device Details')}}</a></li>
            <li class="on"><a href="{{url('maintenance/showDevice')}}/{{$deviceDetail->DevID}}/alarm"> {{trans('menu.Alarm Info')}}</a></li>
        </ul>
        <div class="clear"></div>
    </div>


    <div class="fullCont">
        <div class="mtop15">
            <table class="Table">
                <tr>
                    <th>{{trans('content.Device Name')}}</th>
                    <th>{{trans('content.Alarm Level')}}</th>
                    <th class="filterBox">
                        <span>{{trans('content.Alarm Content')}}</span>
                        <a href="#" onclick="{{"showSearchForm('$deviceDetail->DevID','maintenance');"}}">
                            <i class="icoFilter"></i>{{trans('button.Filter')}}
                        </a>
                    </th>
                </tr>
                @foreach($deviceAlarmData as $alarmData)
                <tr onclick="showAlarmDetail(1209);">
                    <td>{{$deviceDetail->Name}}</td>
                    <td>
                        <span class="label
					    @if ($alarmData->AlarmLevel === 0)
                                label-info
                        @elseif ($alarmData->AlarmLevel === 1)
                                label-alert
                        @elseif ($alarmData->AlarmLevel === 2)
                                label-danger
                        @else
                        @endif">
						@if ($alarmData->AlarmLevel === 0)
                                {{trans('button.Info')}}
                            @elseif ($alarmData->AlarmLevel === 1)
                                {{trans('button.Alarm')}}
                            @elseif ($alarmData->AlarmLevel === 2)
                                {{trans('button.Error')}}
                            @else

                            @endif
					</span>
                    </td>
                    <td class="{{$alarmData->ClearFlag ? "mss_ok" : "mss_ror"}}">
                        <span>[{{$alarmData->AlarmOccurTime}}]-[cmd]: {{$alarmData->AlarmProbalCause}}</span>
                    </td>
                </tr>
                @endforeach
            </table>
            <div class="mtop15">
                {{ $deviceAlarmData->links() }}
            </div>
        </div>
    </div>


    <div id="searchForm" class="hidden">
        <div class="Screening mtop10">
            <ul>

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

</div>
<script type="text/javascript" src="{{ asset('/widget/jquery-3.1.1.min.js') }}"></script>
<script type="text/javascript" src='{{asset('/widget/jquery.i18n.properties.js')}}'></script>
<script type="text/javascript" src="{{ asset('/layer/layer.js') }}"></script>
<script type="text/javascript" src='{{asset('/js/validator.js')}}'></script>
<script type="text/javascript" src="{{asset('/keyboard/js/keyboard.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/alarm.js')}}"></script>
</body>
</html>