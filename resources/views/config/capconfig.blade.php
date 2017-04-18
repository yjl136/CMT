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
            <li class=""><a href="{{url('transmission')}}">{{trans('menu.Transfer')}}</a></li>
            <li class="on"><a href="{{url('system')}}">{{trans('menu.System')}}</a></li>
            <li class=""><a href="{{url('timesync')}}">{{trans('menu.TimeSetting')}}</a></li>
        </ul>
    </div>
    <div class="left rightCont">

        <!-- 三级菜单 -->
        <ul class="threeMenu right">
            <li class=""><a href="{{url('system')}}">系统配置</a></li>
            <li class=""><a href="{{url('server')}}">SERVER配置</a></li>
            <li class="on"><a href="{{url('cap')}}">CWAP配置</a></li>
        </ul>

        <div class="clear"></div>
        <div id="conditionBox">
            <div class="Screening blockBox mtop10">
                <p class="message text-left">
                    <i class="icoPop"></i>
                    {{trans('说明：CWAP配置是对CWAP的（生产序列号和设备MOD）进行配置。')}}
                </p>
                <ul>
                    <li>
                        <label>{{trans('CAP-1生产序列号')}}：</label>
                        <input id="cap_sn1" type="text" class="ipt"  value="{{$data[0]->DevSeq}}" onclick="showKeyboard(this, 20, 'all', '-1');"/>
                    </li>
                    <li>
                        <label>{{trans('CAP-2生产序列号')}}：</label>
                        <input id="cap_sn2" type="text" class="ipt"  value="{{$data[1]->DevSeq}}" onclick="showKeyboard(this, 20, 'all', '-1');"/>
                    </li>
                    <li>
                        <label>{{trans('CAP-3生产序列号')}}：</label>
                        <input id="cap_sn3" type="text" class="ipt"  value="{{$data[2]->DevSeq}}" onclick="showKeyboard(this, 20, 'all', '-1');"/>
                    </li>
                    <li>
                        <label>{{trans('CAP-1 MOD')}}:</label>
                        <input id="cap_em1" type="text" class="ipt"  value="{{$data[0]->DevModel}}" onclick="showKeyboard(this, 20, 'all', '-1');"/>
                    </li>
                    <li>
                        <label>{{trans('CAP-2 MOD')}}:</label>
                        <input id="cap_em2" type="text" class="ipt"  value="{{$data[1]->DevModel}}" onclick="showKeyboard(this, 20, 'all', '-1');"/>
                    </li>
                    <li>
                        <label>{{trans('CAP-3 MOD')}}:</label>
                        <input id="cap_em3" type="text" class="ipt"  value="{{$data[2]->DevModel}}" onclick="showKeyboard(this, 20, 'all', '-1');"/>
                    </li>
                </ul>
            </div>

            <div class="subBox">
                <a href="#" class="Buton" onclick="saveCapConfig();">{{trans('button.Save')}}</a>
                <a href="{{url('cap')}}" class="Buton">{{trans('button.Cancel')}}</a>
            </div>
        </div>
    </div>


    @include('common.keyboard')
@stop

@section('footer')
    <script type="text/javascript" src='{{asset('js/sysconfig.js')}}'></script>
@stop