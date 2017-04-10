@extends('layout.frame')

@section('content')
    <div class="topBox">
        <div class="left {{config('app.locale') == 'zh_cn' ? 'logo' : 'logo_en'}}"></div>
        <ul class="topMenu left">
            <li class=""><a class="index" href="{{url('topo')}}"><span>{{trans('menu.Home')}}</span></a></li>
            <li class=""><a class="monitor" href="{{url('list')}}"><span>{{trans('menu.Device')}}</span></a></li>
            <li class="on"><a class="maintenance" href="{{url('bite')}}"><span>{{trans('menu.Maintain')}}</span></a></li>
            <li class=""><a class="system" href="{{url('operateLog')}}"><span>&nbsp;{{trans('menu.Information')}}&nbsp;</span></a></li>
        </ul>
        <ul class="topUser right">
            <li class="user"><a href="#"><i style="background: url({{ asset('/img/logos') }}/{{config('app.airline_company')}}/{{'user_logo.png'}}) repeat 0 0;"></i><span>{{trans('menu.Hello')}}!{{trans('menu.Super Admin')}}</span></a></li>
            <li class="loginOut"><a href="{{url('logout')}}"><i></i><span>{{trans('menu.Exit')}}</span></a></li>
        </ul>
    </div>
    <div class="left leftMenu">
        <ul>
            <li class=""><a href="{{url('maintenance/bite')}}">{{trans('menu.Bite')}}</a></li>
            <li class=""><a href="{{url('maintenance/sysUpgrade')}}">{{trans('menu.SysUpgrade')}}</a></li>
            <li class=""><a href="{{url('maintenance/sysBackup')}}">{{trans('menu.SysBackup')}}</a></li>
            <li class=""><a href="{{url('maintenance/progUpdate')}}">{{trans('menu.ProUpdate')}}</a></li>
            <li class="on"><a href="{{url('maintenance/dataExport')}}">{{trans('menu.Export')}}</a></li>
            <li class=""><a href="{{url('maintenance/sysTest')}}">{{trans('menu.Test')}}</a></li>
        </ul>
    </div>
    <div class="left rightCont">
        <ul class="threeMenu right">
            <li class="">
                <a href="{{url('maintenance/dataExport')}}">{{trans('menu.Manually Export')}}</a>
            </li>
            <li class="on">
                <a href="{{url('maintenance/autoExport')}}">{{trans('menu.Auto Export')}}</a>
            </li>
        </ul>
        <div class="clear"></div>
        <div id="conditionBox">
            <div class="Screening blockBox mtop10 config_box">
                <ul>
                    <li id="autoExportTactics">
                        <input type="radio" name="export_policy" id="radio_autoExportTactics" value="1" {{$list['export_type']==1 ? 'checked' : ''}}>
                        <label>{{trans('maintain.landingexport')}}</label>
                    </li>
                    <li>
                        <input type="radio" name="export_policy" id="radio_autoExportDays" value="2" {{$list['export_type']==2 ? 'checked' : ''}}>
                        <label>{{trans('maintain.days')}}</label>
                        <input type="text" id="export_days" class="ipt" value="{{$list['export_type']==2 ? $list["export_days"] : ''}}" onclick="showKeyboard(this, 50, 'all', '-1');"/></td>
                    </li>
                    <li>
                        <input type="radio" name="export_policy" id="radio_autoExportWeeks" value="3" {{$list['export_type']==3 ? 'checked' : ''}} >
                        <label>{{trans('maintain.weeks')}}</label>
                        <input type="text" id="export_weeks" class="ipt" value="{{$list['export_type']==3 ? $list["export_weeks"] : ''}}" onclick="showKeyboard(this, 50, 'all', '-1');"/></td>
                    </li>
                    <li>
                        <input type="radio" name="export_policy" id="radio_autoExportMonths" value="4" {{$list['export_type']==4 ? 'checked' : ''}} >
                        <label>{{trans('maintain.months')}}</label>
                        <input type="text" id="export_months" class="ipt" value="{{$list['export_type']==4 ? $list["export_months"] : ''}}" onclick="showKeyboard(this, 50, 'all', '-1');"/></td>
                    </li>
                </ul>
            </div>
            <div class="subBox">
                <a href="#" class="Buton" onclick="checkTransWay();">{{trans('maintain.save')}}</a>
            </div>
        </div>
        @include('common.keyboard')
    </div>
@stop

@section('footer')
    <script type="text/javascript" src='{{asset('/js/autoExport.js')}}'></script>
    <script type="text/javascript" src='{{asset('/js/common.js')}}'></script>
@stop