<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{trans('空中娱乐管理系统')}}</title>
    <link rel="shortcut icon" href="{{asset('img/logos/csa/favicon.ico')}}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/base.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/detail.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/monitor.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('')}}{{ config('app.theme')}}{{'/css/sys.css' }}"/>
</head>
<body class="mainbody">
<div class="main">
    <div class="topBox">
        <div class="left {{config('app.locale') == 'zh_cn' ? 'logo' : 'logo_en'}}"></div>
        <ul class="topMenu left">
            <li class=""><a class="index" href="{{url('topo')}}"><span>{{trans('menu.Home')}}</span></a></li>
            <li class="on"><a class="monitor" href="{{url('list')}}"><span>{{trans('menu.Device')}}</span></a></li>
            <li class=""><a class="config" href="{{url('receiver')}}"><span>{{trans('menu.Config')}}</span></a></li>
            <li class=""><a class="maintenance" href="{{url('bite')}}"><span>{{trans('menu.Maintain')}}</span></a></li>
            <li class=""><a class="system" href="{{url('operateLog')}}"><span>&nbsp;{{trans('menu.Information')}}&nbsp;</span></a></li>
        </ul>
        <ul class="topUser right">
            <li class="user"><a href="#"><i style="background: url({{ asset('/img/logos') }}/{{config('app.airline_company')}}/{{'user_logo.png'}}) repeat 0 0;"></i><span>{{trans('menu.Hello')}}!{{trans('menu.Super Admin')}}</span></a></li>
            <li class="loginOut"><a href="{{url('logout')}}"><i></i><span>{{trans('menu.Exit')}}</span></a></li>
        </ul>
    </div>

    <div class="deLeft">
        <div class="left">
            <a href="{{url('list')}}" class="btnBack">{{trans('button.Back to Device List')}}</a>
            <p class="devName">
                <label>{{trans('content.Device Name')}}:</label>
                <span>
                    @if($deviceDetail->Name == 'CAP')
                        {{$deviceDetail->Name}}-{{substr($deviceDetail->DevPosition,-1)}}
                    @else
                        {{$deviceDetail->Name}}
                    @endif
                </span>
            </p>
        </div>
        <ul class="threeMenu right mtop15">
            <li class="on"><a href="{{url('showDevice')}}/{{$deviceDetail->DevID}}">{{trans('menu.Device Details')}}</a></li>
            <li class="">
                <a href="{{url('showDevice')}}/{{$deviceDetail->DevID}}/alarm">
                    {{trans('menu.Alarm Info')}}
                </a>
            </li>
        </ul>
        <div class="clear"></div>
    </div>
    @if ($deviceDetail->Name === 'Server')
        <div class="left fullCont">
            <!-- CAP or Server -->
            <div class="moduleShow left detailLeft">
                <h4>{{trans('content.Essential Information')}}</h4>
                <ul class="blockBox basic left" id="physic_info">
                    <li>
                        <label>{{trans('content.Free CPU')}}：</label>
                        <span>{{$devicePhysicInfo['free_cpu'] or 'N/A'}}</span>
                    </li>
                    <li>
                        <label>{{trans('content.Total Memory')}}：</label>
                        <span>
                            {{$devicePhysicInfo['total_memory'] or 'N/A'}}
                        </span>
                    </li>
                    <li>
                        <label>{{trans('content.Free Memory')}}：</label>
                        <span>
                            {{$devicePhysicInfo['free_memory'] or 'N/A'}}
                        </span>
                    </li>
                    <li>
                        <label>{{trans('content.CPU Temperature')}}：</label>
                        <span>{{$devicePhysicInfo['cpu_temperature'] or 'N/A'}}</span>
                    </li>
                    <li>
                        <label>{{trans('content.System Temperature')}}：</label>
                        <span>{{$devicePhysicInfo['system_temperature'] or 'N/A'}}</span>
                    </li>
                </ul>
                <ul class="blockBox switch left" id="physic_info">
                    <li>
                        <p>交换机</p>
                    </li>
                  {{--  <li>
                        <label>IP地址：</label>
                        <span>
                            {{'N/A'}}
                        </span>
                    </li>--}}
                    <li>
                        <label>运行状态</label>
                        <span>
                           <label class="label label-success">运行正常</label>
                        </span>
                    </li>

                </ul>
                <h4>{{trans('content.Hard disk Information')}}</h4>
                <table cellspacing="0" cellpadding="0" border="0" class="Table">
                    <tr>
                        <th>{{trans('content.Hard disk Partition')}}</th>
                        <th>{{trans('content.Use Ratio')}}</th>
                        <th>{{trans('content.Available Capacity')}}</th>
                    </tr>
                    <tbody id="disk_list">
                    @if(!empty($hardDiskInfo))
                        @foreach($hardDiskInfo as $hardDisk)
                            <tr class="disk">
                                <td class="smallText">{{$hardDisk['partion'] or 'N/A'}}</td>
                                <td>
                            <span class="gayColumn">
                                <b class="blueColumn" style="width:{{$hardDisk['percent'] or '0'}};">
                                    <i>{{$hardDisk['percent'] or '0'}}</i>
                                </b>
                            </span>
                                </td>
                                <td class="smallText">
                                    {{$hardDisk['avail']}}
                                    {{trans('content.Available Total')}}
                                    {{$hardDisk['total'] or 'N/A'}}
                                </td>
                            </tr>
                        @endforeach
                    @else

                    @endif
                    </tbody>
                </table>
            </div>
            <div class="moduleShow left detailRight">
                <h4>{{trans('content.Application Information')}}</h4>
                <table cellspacing="0" cellpadding="0" border="0" class="Table">
                    <tr>
                        <th></th>
                        <th>{{trans('content.ApplyName')}}</th>
                        <th>{{trans('content.Runtime')}}</th>
                        <th>{{trans('content.Running State')}}</th>
                    </tr>
                    <tbody id="app_list">
                    @if(!empty($appData))
                        @foreach($appData as $app)
                        <tr>
                            <td>{{$app['id'] or 'N/A'}}</td>
                            <td>{{$app['name'] or 'N/A'}}</td>
                            <td>{{$app['run_time'] or 'N/A'}}</td>
                            <td>
                                <label class="label {{$app['status'] or 'N/A'}}">{{$app['state'] or 'N/A'}}</label>
                            </td>
                        </tr>
                        @endforeach
                    @else

                    @endif
                    </tbody>
                </table>
                <ul class="blockBox card1 left" id="physic_info">
                    <li>
                        <p>4G #1</p>
                    </li>
                    <li>
                        <label>IP地址：</label>
                        <span>
                            {{$g4_data['4g1ip']->Value or 'N/A'}}
                        </span>
                    </li>
                    {{--<li>--}}
                        {{--<label>流量统计：</label>--}}
                        {{--<span>--}}
                           {{--1952421/kpbs--}}
                        {{--</span>--}}
                    {{--</li>--}}
                    <li>
                        <label>运行状态</label>
                        <span>
                           <label class="label {{$g4_data['4g1sta']->Value == '1' ? 'label-success' : 'label-danger'}}">
                               {{$g4_data['4g1sta']->Value == '1' ? '运行中' : '运行异常'}}
                           </label>
                        </span>
                    </li>

                </ul>
                <ul class="blockBox card2 left" id="physic_info">
                    <li>
                        <p>4G #2</p>
                    </li>
                    <li>
                        <label>IP地址：</label>
                        <span>
                           {{$g4_data['4g2ip']->Value or 'N/A'}}
                        </span>
                    </li>
                    {{--<li>--}}
                        {{--<label>流量统计：</label>--}}
                        {{--<span>--}}
                           {{--1952421/kpbs--}}
                        {{--</span>--}}
                    {{--</li>--}}
                    <li>
                        <label>运行状态</label>
                        <span>
                           <label class="label {{$g4_data['4g2sta']->Value == '1' ? 'label-success' : 'label-danger'}}">
                               {{$g4_data['4g2sta']->Value == '1' ? '运行中' : '运行异常'}}
                           </label>
                        </span>
                    </li>

                </ul>
            </div>
        </div>
    @elseif ($deviceDetail->Name === 'CAP')
        <div class="left fullCont">
            <div class="moduleShow left detailLeft">
                <h4>{{trans('content.Equipment Information')}}</h4>
                <ul class="blockBox">
                    <li>
                        <label>{{trans('content.State')}}：</label>
                        <span class="label label-success" id="dev_status">
                            {{$deviceDetail->DevStatus == 2 ? trans('content.Online') : trans('content.Offline')}}
                        </span>
                    </li>
                    <li>
                        <label>IP：</label>
                        <span id="dev_ip">{{$deviceDetail->IPAddress or ''}}</span>
                    </li>
                    <li>
                        <label>Mac：</label>
                        <span id="dev_mac">{{$deviceDetail->DevID or ''}}</span>
                    </li>
                    <li>
                        <label>{{trans('content.Uptime')}}：</label>
                        <span id="dev_uptime">{{$deviceDetail->RegisterDate or ''}}</span>
                    </li>
                </ul>
            </div>
            <div class="moduleShow left detailRight">
                <h4>{{trans('content.Status Information')}}</h4>
                <ul class="blockBox" id="status_info">
                    @if ( $capPosition == '0-ap-1')
                        @foreach($capStatusInfo as $data)
                        <li>
                            <label>{{$data['name'] or ''}}:</label>
                            <span>{{$data['value'] or ''}}</span>
                        </li>
                        @endforeach
                    @elseif ($capPosition == '0-ap-2')
                        @foreach($capStatusInfo as $data)
                            <li>
                                <label>{{$data['name'] or ''}}:</label>
                                <span>{{$data['value'] or ''}}</span>
                            </li>
                        @endforeach
                    @elseif ($capPosition == '0-ap-3')
                        @foreach($capStatusInfo as $data)
                            <li>
                                <label>{{$data['name'] or ''}}:</label>
                                <span>{{$data['value'] or ''}}</span>
                            </li>
                        @endforeach
                    @else

                    @endif
                </ul>
            </div>
        </div>
    @else

    @endif

    <input id="dev_id" type="hidden" value="{{$deviceDetail->DevID or ''}}"/>
    <input id="dev_type" type="hidden" value="{{$deviceDetail->Type or ''}}"/>
</div>
<script type="text/javascript" src="{{ asset('/widget/jquery-3.1.1.min.js') }}"></script>
<script type="text/javascript" src='{{asset('/widget/jquery.i18n.properties.js')}}'></script>
<script type="text/javascript" src='{{asset('/js/devlist.js')}}'></script>
</body>
</html>