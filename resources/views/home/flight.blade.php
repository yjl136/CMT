@extends('layout.frame')

@section('content')
    <div class="topBox">
        <div class="left {{config('app.locale') == 'zh_cn' ? 'logo' : 'logo_en'}}"></div>
        <ul class="topMenu left">
            <li class="on"><a class="index" href="{{url('topo')}}"><span>{{trans('menu.Home')}}</span></a></li>
            <li class=""><a class="monitor" href="{{url('list')}}"><span>{{trans('menu.Device')}}</span></a></li>
            <li class=""><a class="config" href="{{url('receiver')}}"><span>{{trans('menu.Config')}}</span></a></li>
            <li class=""><a class="maintenance" href="{{url('bite')}}"><span>{{trans('menu.Maintain')}}</span></a></li>
            <li class=""><a class="system" href="{{url('operateLog')}}"><span>&nbsp;{{trans('menu.Information')}}&nbsp;</span></a></li>
        </ul>
        <ul class="topUser right">
            <li class="user"><a href="#"><i style="background: url({{ asset('/img/logos') }}/{{config('app.airline_company')}}/{{'user_logo.png'}}) repeat 0 0;"></i><span>{{trans('menu.Hello')}}!{{trans('menu.Super Admin')}}</span></a></li>
            <li class="loginOut"><a href="{{url('logout')}}"><i></i><span>{{trans('menu.Exit')}}</span></a></li>
        </ul>
    </div>
    <div class="bodybox">
        <a href="{{url('flight')}}" id="tab1" class="tab1"></a>
        <a href="{{url('topo')}}" id="tab2" class="tab2 tab2_"></a>

        <div class="body1">
            <div class="li2box mtop10">
                <div class="warpbox deviceStatus">
                    <div class="wpTop">
                        <h3>{{trans('content.Device Status')}}</h3>
                    </div>
                    <div class="wpCont" id="deviceStatusList">
                        <ul>
                            @foreach($deviceInfos as $deviceInfo)
                            <li class="{{$deviceInfo->DevStatus==2 ? '' : 'ror'}}">
                                <a href="#" onclick="{{$deviceInfo->DevStatus==2 ? "showDevice('$deviceInfo->DevID')" : "layerMessage()"}}">
                                    <i></i>
                                    <img src="img/{{strtolower($deviceInfo->Name)}}.png"/>
                                    <span>{{$deviceInfo->Name}}{{$deviceInfo->DevType==15 ? substr($deviceInfo->DevPosition,-2) : ''}}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="warpbox flightData">
                    <div class="wpTop">
                        <h3>{{trans('content.Flight Data')}}</h3>
                    </div>
                    <div class="wpCont">
                        <div class="data">
                            <ul>
                                <li class="item1">
                                    <i></i>
                                    <label>{{trans('content.Altitude')}}</label>
                                    <span id="altitude">{{$data["Altitude"]}}</span>
                                    <em></em>
                                </li>
                                <li class="item1">
                                    <i></i>
                                    <label>{{trans('content.Speed')}}</label>
                                    <span id="airspeed">{{$data["AirSpeed"]}}</span>
                                    <em></em>
                                </li>
                                <li class="item2">
                                    <i></i>
                                    <label>{{trans('content.Longitude')}}</label>
                                    <span id="longitude">{{$data["Longitude"]}}</span>
                                    <em></em>
                                </li>
                                <li class="item2">
                                    <i></i>
                                    <label>{{trans('content.Latitude')}}</label>
                                    <span id="latitude">{{$data["Latitude"]}}</span>
                                    <em></em>
                                </li>
                            </ul>
                        </div>
                        <div class="bottom">
                            <div class="mTime">{{trans('content.The page data update time')}} :
                                <span>{{$currentTime}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


@section('footer')
    <script type="text/javascript" src='{{asset('/js/devlist.js')}}'></script>
@stop