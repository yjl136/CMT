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
            <li class="on"><a href="{{url('maintenance/flightLog')}}">{{trans('menu.Flight Log')}}</a></li>
            <li class=""><a href="{{url('maintenance/alarmLog')}}">{{trans('menu.Alarm Log')}}</a></li>
            <li class=""><a href="{{url('maintenance/runningLog')}}">{{trans('menu.Running Log')}}</a></li>
        </ul>
        <div class="clear"></div>
        <table class="Table mtop15">
            <tr>
                <th>{{trans('ID')}}</th>
                <th>{{trans('飞机号')}}</th>
                <th>{{trans('经度')}}</th>
                <th>{{trans('纬度')}}</th>
                <th>{{trans('航程')}}</th>
                <th>{{trans('所需时间')}}</th>
                <th>{{trans('开始时间')}}</th>
            </tr>
            @foreach($flightList as $flight)
            <tr>
                <td>{{$flight->ID}}</td>
                <td>{{$flight->FlightNumber}}</td>
                <td>{{$flight->Latitude}}</td>
                <td>{{$flight->Longitude}}</td>
                <td>{{$flight->DistanceToDestiation}}</td>
                <td>{{$flight->TimeToDestiation}}</td>
                <td>{{$flight->CreateDate}}</td>
            </tr>
            @endforeach
        </table>

        <div class="mtop15">
            {{ $flightList->links() }}
        </div>
    </div>
@stop




@section('footer')
    <script type="text/javascript" src="{{asset('/keyboard/js/keyboard.js')}}"></script>
    <script type="text/javascript" src='{{asset('/js/validator.js')}}'></script>
    <script type="text/javascript" src="{{asset('/js/operateLog.js')}}"></script>
@stop