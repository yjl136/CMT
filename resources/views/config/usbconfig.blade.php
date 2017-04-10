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
       {{--     <li class="on"><a href="{{url('http')}}">{{trans('menu.Upgrade')}}</a></li>--}}
            <li class=""><a href="{{url('transmission')}}">{{trans('menu.Transfer')}}</a></li>
            <li class=""><a href="{{url('system')}}">{{trans('menu.System')}}</a></li>
            <li class=""><a href="{{url('timesync')}}">{{trans('menu.TimeSetting')}}</a></li>
        </ul>
    </div>
    <div class="left rightCont">
        <table cellpadding="0" cellspacing="0" class="WarpTable mtop15">
            <tr>
                <td><label>{{trans('content.URL')}}</label></td>
                <td><input type="text" id="url" class="ipt" value="{{$data->url}}" onclick="showKeyboard(this, 50, 'all', '-1');"/></td>
            </tr>
            <tr>
                <td><label>{{trans('content.Username')}}</label></td>
                <td><input type="text" id="username" class="ipt" value="{{$data->username}}" onclick="showKeyboard(this, 50, 'all', '-1');"/></td>
            </tr>
            <tr>
                <td><label>{{trans('content.Password')}}</label></td>
                <td><input type="password" id="password" class="ipt" value="{{$data->passwd}}" onclick="showKeyboard(this, 50, 'all', '-1');"/></td>
            </tr>
            <input type="hidden" id="upgrade_method" value="{{$data->type}}">
        </table>
        <div class="subBox">
            <a href="#" class="Buton" onclick="updateUsbConfig();">{{trans('button.Save')}}</a>
            <a href="{{url('http')}}" class="Buton">{{trans('button.Cancel')}}</a>
        </div>
    </div>
    @include('common.keyboard')
@stop

@section('footer')
    <script type="text/javascript" src='{{asset('js/transmissionConfig.js')}}'></script>
@stop