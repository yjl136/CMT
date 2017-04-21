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
            <li class=""><a href="{{url('maintenance/alarmLog')}}">{{trans('menu.Alarm Log')}}</a></li>
            <li class="on"><a href="{{url('maintenance/runningLog')}}">{{trans('menu.Running Log')}}</a></li>
        </ul>
        <div class="clear"></div>
        <table class="Table mtop15">
            <tr>
                <th>{{trans('设备名称')}}</th>
                <th>{{trans('应用名称')}}</th>
                <th>{{trans('参数')}}</th>
                <th>{{trans('参数值')}}</th>
                <th class="filterBox">
                    <span>{{trans('时间')}}</span>
                    <a href="#" onclick="showSearchForm();">
                        <i class="icoFilter"></i>{{trans('筛选')}}
                    </a>
                </th>
            </tr>
            @foreach($runningList as $running)
            <tr>
                <td>{{$running->Name}}</td>
                <td>{{$running->AppName}}</td>
                <td>{{$running->Descs}}</td>
                <td>{{$running->ParamValue}}</td>
                <td>{{$running->CreateTime}}</td>
            </tr>
            @endforeach
        </table>

        <div class="mtop15">
            {{ $runningList->links() }}
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
    <script type="text/javascript" src="{{asset('/js/runningLog.js')}}"></script>
@stop