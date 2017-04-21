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
            <li class="on"><a href="{{url('users')}}">{{trans('menu.Account')}}</a></li>
           {{-- <li class=""><a href="{{url('http')}}">{{trans('menu.Upgrade')}}</a></li>--}}
            <li class=""><a href="{{url('network')}}">{{trans('menu.NetWorkSetting')}}</a></li>
            <li class=""><a href="{{url('transmission')}}">{{trans('menu.Transfer')}}</a></li>
            <li class=""><a href="{{url('system')}}">{{trans('menu.System')}}</a></li>
            <li class=""><a href="{{url('timesync')}}">{{trans('menu.TimeSetting')}}</a></li>
        </ul>
    </div>
    <div class="left rightCont">
        <div class="Navigation left">
            <a href="{{url('users')}}">{{trans('用户类型')}}<i></i></a><span>{{$user->type}}</span>
        </div>
        <div class="clear"></div>
        <table cellpadding="0" cellspacing="0" class="WarpTable mtop15">
            <tr>
                <td class="fontRight"><label>{{trans('新密码')}}</label></td>
                <td><input type="password" id='newpassword' class="ipt" value="{{$password}}" onclick="showKeyboard(this, 20, 'all', '-1');" placeholder="请输入密码"/></td>
            </tr>
            <tr>
                <td class="fontRight"><label>{{trans('重复密码')}}</label></td>
                <td><input type="password" id='repeatpassword' class="ipt" value="{{$password}}" onclick="showKeyboard(this, 20, 'all', '-1');" placeholder="请再次输入密码"/></td>
            </tr>
        </table>


        <input type="hidden" id="usertype" class="ipt" value="{{$user->type}}"/>

        <div class="subBox">
            <a href="#" class="Buton" href="#" onclick="changePwd();">{{trans('保存')}}</a>
            <a href="{{url('users/edit')}}/{{$user->type}}" class="Buton">{{trans('取消')}}</a>
        </div>

    </div>
    @include('common.keyboard')
@stop




@section('footer')
    <script type="text/javascript" src='{{asset('/js/validator.js')}}'></script>
    <script type="text/javascript" src='{{asset('/js/user.js')}}'></script>
@stop