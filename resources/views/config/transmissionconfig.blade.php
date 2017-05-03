@extends('layout.frame')

@section('content')
    <div class="topBox">
        <div class="left {{config('app.locale') == 'zh_cn' ? 'logo' : 'logo_en'}}"></div>
        <ul class="topMenu left">
            <li class=""><a class="index" href="{{url('topo')}}"><span>{{trans('menu.Home')}}</span></a></li>
            <li class=""><a class="monitor" href="{{url('list')}}"><span>{{trans('menu.Device')}}</span></a></li>
            <li class="on"><a class="config" href="{{url('receiver')}}"><span>{{trans('menu.Config')}}</span></a></li>
            <li class=""><a class="maintenance" href="{{url('bite')}}"><span>{{trans('menu.Maintain')}}</span></a></li>
            <li class=""><a class="system" href="{{url('operateLog')}}"><span>&nbsp;{{trans('menu.Information')}}&nbsp;</span></a></li>
        </ul>
        <ul class="topUser right">
            <li class="user"><a href="#"><i style="background: url({{ asset('/img/logos') }}/{{config('app.airline_company')}}/{{'user_logo.png'}}) repeat 0 0;"></i><span>{{trans('menu.Hello')}}!{{trans('menu.Super Admin')}}</span></a></li>
            <li class="loginOut"><a href="{{url('logout')}}"><i></i><span>{{trans('menu.Exit')}}</span></a></li>
        </ul>
    </div>
    <div class="left leftMenu">
        <ul>
            <li class=""><a href="{{url('receiver')}}">{{trans('menu.Mail')}}</a></li>
            <li class=""><a href="{{url('users')}}">{{trans('menu.Account')}}</a></li>
           {{-- <li class=""><a href="{{url('http')}}">{{trans('menu.Upgrade')}}</a></li>--}}
            <li class=""><a href="{{url('network')}}">{{trans('menu.NetWorkSetting')}}</a></li>
            <li class="on"><a href="{{url('transmission')}}">{{trans('menu.Transfer')}}</a></li>
            <li class=""><a href="{{url('system')}}">{{trans('menu.System')}}</a></li>
            <li class=""><a href="{{url('timesync')}}">{{trans('menu.TimeSetting')}}</a></li>
        </ul>
    </div>
    <div class="left rightCont">
        <div class="Screening blockBox mtop10 config_box">
            <ul>
                <li id="transportProtocol">
                    <label>{{trans('content.Transport Protocol')}}</label>
                    @foreach($transportProtocol as $key => $value)
                     <a href="#" class="on" ><i class="{{$value["checked"] ? "checkbox_on" : "checkbox"}}" id="{{$value["text"]}}"></i>{{$value["text"]}}</a>
                    @endforeach
                </li>
                <li id="exportUrl" >
                    <label>{{trans('IP')}}</label>
                    <input type="text" id="third_url" class="exportUrl ipt" value="{{$exportList[0]->export_url}}" onclick="showKeyboard(this, 50, 'all', '-1');"/></td>
                </li>
                <li id="exportUserName">
                    <label>{{trans('content.Username')}}</label>
                    <input type="text" id="third_username" class="exportUserName ipt" value="{{$exportList[0]->export_username}}" onclick="showKeyboard(this, 50, 'all', '-1');"/></td>
                </li>
                <li id="exportPassword">
                    <label>{{trans('content.Password')}}</label>
                    <input type="password" id="third_password" class="exportPassword ipt" value="{{$exportList[0]->export_password}}" onclick="showKeyboard(this, 50, 'all', '-1');"/></td>
                </li>
                <li id="exportMethod">
                    <label>{{trans('content.Derived Equation')}}</label>
                    @foreach($exportMethod as $key => $value)
                    <a href="#" class="on"><i class="{{$value["checked"] ? "checkbox_on" : "checkbox"}}" id="{{$key}}"></i>{{$value["text"]}}</a>
                    @endforeach
                </li>
            </ul>
        </div>
        <div class="subBox">
            <a href="#" class="Buton" onclick="checkTransWay();">{{trans('button.Save')}}</a>
            <a href="#" class="Buton" onclick="backToTransmissionConfig();">{{trans('button.Cancel')}}</a>
        </div>
    </div>
    @include('common.keyboard')
@stop

@section('footer')
    <script type="text/javascript" src='{{asset('js/validator.js')}}'></script>
    <script type="text/javascript" src='{{asset('js/transmissionConfig.js')}}'></script>
@stop