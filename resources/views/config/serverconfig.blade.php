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
          {{--  <li class=""><a href="{{url('http')}}">{{trans('menu.Upgrade')}}</a></li>--}}
            <li class=""><a href="{{url('transmission')}}">{{trans('menu.Transfer')}}</a></li>
            <li class="on"><a href="{{url('system')}}">{{trans('menu.System')}}</a></li>
            <li class=""><a href="{{url('timesync')}}">{{trans('menu.TimeSetting')}}</a></li>
        </ul>
    </div>
    <div class="left rightCont">

        <!-- 三级菜单 -->
        <ul class="threeMenu right">
            <li class=""><a href="{{url('system')}}">系统配置</a></li>
            <li class="on"><a href="{{url('server')}}">CNSU配置</a></li>
            <li class=""><a href="{{url('cap')}}">CWAP配置</a></li>
        </ul>

        <div class="clear"></div>
        <div id="conditionBox">
            <div class="Screening blockBox mtop10">
                <p class="message text-left">
                    <i class="icoPop"></i>
                    {{trans('说明：CNSU配置是对CNSU的（生产序列号和设备MOD）进行配置。')}}
                </p>
                <ul>
                    <li>
                        <label style="padding-left: 8px;">{{trans('生产序列号')}}：</label>
                        <input id="server_sn" type="text" class="ipt"  value="{{$data->DevSeq}}" onclick="showKeyboard(this, 20, 'all', '-1');"/>
                    </li>
                    <li>
                        <label>{{trans('设备MOD号')}}：</label>
                        <input id="server_em" type="text" class="ipt"  value="{{$data->DevModel}}" onclick="showKeyboard(this, 20, 'all', '-1');"/>
                    </li>
                </ul>
            </div>

            <div class="subBox">
                <a href="#" class="Buton" onclick="saveServerConfig();">{{trans('button.Save')}}</a>
                <a href="{{url('server')}}" class="Buton">{{trans('button.Cancel')}}</a>
            </div>
        </div>
    </div>
    @include('common.keyboard')
@stop

@section('footer')
    <script type="text/javascript" src='{{asset('js/sysconfig.js')}}'></script>
@stop