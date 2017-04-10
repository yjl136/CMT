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
          {{--  <li class=""><a href="{{url('http')}}">{{trans('menu.Upgrade')}}</a></li>--}}
            <li class=""><a href="{{url('transmission')}}">{{trans('menu.Transfer')}}</a></li>
            <li class=""><a href="{{url('system')}}">{{trans('menu.System')}}</a></li>
            <li class=""><a href="{{url('timesync')}}">{{trans('menu.TimeSetting')}}</a></li>
        </ul>
    </div>
    <div class="left rightCont">
        <div class="Navigation left">
            <a href="{{url('receiver')}}">{{trans('content.Receiver Config')}}<i></i></a><span>{{$receive->MailType}}</span>
        </div>
        <ul class="threeMenu right">
            <li class="on"><a href="{{url('receiver')}}">{{trans('menu.Receiver')}}</a></li>
            <li class=""><a href="{{url('sender')}}">{{trans('menu.Sender')}}</a></li>
        </ul>
        <div class="clear"></div>
            <table id="receiveBox2" cellpadding="0" cellspacing="0" class="WarpTable mtop15">
                <tr>
                    <td><label>{{trans('content.Mail Type')}}</label></td>
                    <td><span>{{$receive->MailType}}</span></td>
                </tr>
                <tr>
                    <td><label>{{trans('content.Receiver')}}</label></td>
                    <td>
                        <input type="text" id="userid" class="ipt" value="{{$receive->UserID}}" onclick="showKeyboard(this, 50, 'all', '-1');"/>
                    </td>
                </tr>
                <tr>
                    <td><label>{{trans('content.Subject')}}</label></td>
                    <td><span>{{$receive->Subject}}</span></td>
                </tr>
                <tr>
                    <td><label>{{trans('content.Context')}}</label></td>
                    <td>
                    <span class="mailcontent">
                        <pre>
                            {{$receive->Context}}
                        </pre>
                    </span>
                    </td>
                </tr>
            </table>

            <input type="hidden" id="mailtype" class="ipt" value="{{$receive->MailType}}"/>

            <div id="receiveBox3" class="subBox">
                <a href="#" class="Buton" onclick="updateRecver();">{{trans('button.Save')}}</a>
                <a href="#" class="Buton" onclick="backToRecver();">{{trans('button.Cancel')}}</a>
            </div>
    </div>
    @include('common.keyboard')
@stop




@section('footer')
    <script type="text/javascript" src='{{asset('/js/mail.js')}}'></script>
@stop