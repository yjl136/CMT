<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{trans('空中娱乐管理系统')}}</title>
    <link rel="shortcut icon" href="{{asset('img/logos/csa/favicon.ico')}}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/base.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/detail.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/monitor.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('')}}{{ config('app.theme')}}/{{'/css/sys.css' }}"/>
</head>
<body class="mainbody">
<div class="main">
    <div class="topBox">
        <div class="left {{config('app.locale') == 'zh_cn' ? 'logo' : 'logo_en'}}"></div>
        <ul class="topMenu left">
            <li class=""><a class="index" href="{{url('topo')}}"><span>{{trans('menu.Home')}}</span></a></li>
            <li class="on"><a class="monitor" href="{{url('list')}}"><span>{{trans('menu.Device')}}</span></a></li>
            <li class=""><a class="config" href="{{url('receiver')}}"><span>{{trans('menu.Config')}}</span></a></li>
            <li class=""><a class="maintenance" href="{{url('bite')}}"><span>{{trans('menu.Maintain')}}</span></a></li>
            <li class=""><a class="system" href="{{url('operateLog')}}"><span>&nbsp;{{trans('menu.Information')}}&nbsp;</span></a></li>
        </ul>
        <ul class="topUser right">
            <li class="user"><a href="#"><i style="background: url({{ asset('/img/logos') }}/{{config('app.airline_company')}}/{{'user_logo.png'}}) repeat 0 0;"></i><span>{{trans('menu.Hello')}}!{{trans('menu.Super Admin')}}</span></a></li>
            <li class="loginOut"><a href="{{url('logout')}}"><i></i><span>{{trans('menu.Exit')}}</span></a></li>
        </ul>
    </div>

    <div class="deLeft">
        <div class="left">
            <a href="{{url('list')}}" class="btnBack">{{trans('button.Back to Device List')}}</a>
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
            <li class=""><a href="{{url('showDevice')}}/{{$deviceDetail->DevID}}">{{trans('menu.Device Details')}}</a></li>
            <li class="on"><a href="{{url('showDevice')}}/{{$deviceDetail->DevID}}/alarm"> {{trans('menu.Alarm Info')}}</a></li>
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
                        <a href="#" onclick="showSearchForm();">
                            <i class="icoFilter"></i>{{trans('button.Filter')}}
                        </a>
                    </th>
                </tr>
                @foreach($deviceAlarmData as $alarmData)
                <tr onclick="showAlarmDetail(1209);">
                    <td>{{$deviceDetail->Name}}</td>
                    <td>
                        <span class="label
					    @if ($alarmData->AlarmLevel === 1)
                                label-info
                        @elseif ($alarmData->AlarmLevel === 2)
                                label-alert
                        @elseif ($alarmData->AlarmLevel === 3)
                                label-danger
                        @else
                        @endif">
						@if ($alarmData->AlarmLevel === 1)
                                {{trans('button.Info')}}
                            @elseif ($alarmData->AlarmLevel === 2)
                                {{trans('button.Alarm')}}
                            @elseif ($alarmData->AlarmLevel === 3)
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

</div>
<script type="text/javascript" src="{{ asset('/widget/jquery-3.1.1.min.js') }}"></script>
<script type="text/javascript" src='{{asset('/widget/jquery.i18n.properties.js')}}'></script>
</body>
</html>