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
         {{--   <li class=""><a href="{{url('http')}}">{{trans('menu.Upgrade')}}</a></li>--}}
            <li class=""><a href="{{url('network')}}">{{trans('menu.NetWorkSetting')}}</a></li>
            <li class=""><a href="{{url('transmission')}}">{{trans('menu.Transfer')}}</a></li>
            <li class=""><a href="{{url('system')}}">{{trans('menu.System')}}</a></li>
            <li class=""><a href="{{url('timesync')}}">{{trans('menu.TimeSetting')}}</a></li>
        </ul>
    </div>
    <div class="left rightCont">
        <ul class="threeMenu right">
            <li class=""><a href="{{url('receiver')}}">{{trans('menu.Receiver')}}</a></li>
            <li class="on"><a href="{{url('sender')}}">{{trans('menu.Sender')}}</a></li>
        </ul>
        <div class="clear"></div>

        <table class="Table mtop15">
            <tr>
                <th>{{trans('content.Sender')}}</th>
                <th>{{trans('content.SMTP Server')}}</th>
                <th>{{trans('content.Port')}}</th>
                <th>{{trans('content.Operation')}}</th>
            </tr>
            @foreach($senderList as $sender)
            <tr>
                <td>{{$sender->UserID}}</td>
                <td>{{$sender->SmtpSvr}}</td>
                <td>{{$sender->Port}}</td>
                <td>
                    <a class="Buton" href="{{url('sender/edit')}}/{{$sender->UserID}}">{{trans('button.Edit')}}</a>
                    <a class="Buton" href="#" onclick="validateSender('{{$sender->UserID}}');">{{trans('button.Validate')}}</a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
@stop




@section('footer')
    <script type="text/javascript" src='{{asset('js/mail.js')}}'></script>
@stop