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
            <li class="on"><a href="{{url('receiver')}}">{{trans('menu.Mail')}}</a></li>
            <li class=""><a href="{{url('users')}}">{{trans('menu.Account')}}</a></li>
           {{-- <li class=""><a href="{{url('http')}}">{{trans('menu.Upgrade')}}</a></li>--}}
            <li class=""><a href="{{url('network')}}">{{trans('menu.NetWorkSetting')}}</a></li>
            <li class=""><a href="{{url('transmission')}}">{{trans('menu.Transfer')}}</a></li>
            <li class=""><a href="{{url('system')}}">{{trans('menu.System')}}</a></li>
            <li class=""><a href="{{url('timesync')}}">{{trans('menu.TimeSetting')}}</a></li>
        </ul>
    </div>
    <div class="left rightCont">
        <div class="Navigation left">
            <a href="{{url('sender')}}">{{trans('content.Sender Config')}}<i></i></a><span>{{$sender->UserID}}</span>
        </div>
        <ul class="threeMenu right">
            <li class=""><a href="{{url('receiver')}}">{{trans('menu.Receiver')}}</a></li>
            <li class="on"><a href="{{url('sender')}}">{{trans('menu.Sender')}}</a></li>
        </ul>
        <div class="clear"></div>
        <table cellpadding="0" cellspacing="0" class="WarpTable mtop15">
            <tr>
                <td>
                    <label>{{trans('content.Sender')}}</label>
                </td>
                <td>
                    <input type="text" id="userid" class="ipt" value="{{$sender->UserID}}" onclick="showKeyboard(this, 50, 'all', '-1');"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>{{trans('content.Password')}}</label>
                </td>
                <td>
                    <input type="text" id="pwd" class="ipt" value="{{$sender->Pwd}}" onclick="showKeyboard(this, 50, 'all', '-1');"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>{{trans('content.SMTP Server')}}
                        <small>{{trans('content.(Must be IP format)')}}</small>
                    </label>
                </td>
                <td>
                    <input type="text" id="smtpsvr" class="ipt" value="{{$sender->SmtpSvr}}" onclick="showKeyboard(this, 50, 'all', '-1');"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>{{trans('content.Port')}}</label>
                </td>
                <td>
                    <input type="text" id="port" class="ipt" value="{{$sender->Port}}" onclick="showKeyboard(this, 20, 'num', '65535');"/>
                </td>
            </tr>
        </table>

        <div class="subBox">
            <a href="#" class="Buton" onclick="updateSender();">{{trans('button.Save')}}</a>
            <a href="{{url('sender/edit')}}/{{$sender->UserID}}" class="Buton">{{trans('button.Cancel')}}</a>
        </div>
    </div>
    @include('common.keyboard')
@stop




@section('footer')
    <script type="text/javascript" src='{{asset('/js/mail.js')}}'></script>
@stop