 @extends('layout.frame')

 @section('content')
     <div class="topBox">
         <div class="left {{config('app.locale') == 'zh_cn' ? 'logo' : 'logo_en'}}"></div>
         <ul class="topMenu left">
             <li class=""><a class="index" href="{{url('topo')}}"><span>{{trans('menu.Home')}}</span></a></li>
             <li class=""><a class="monitor" href="{{url('list')}}"><span>{{trans('menu.Device')}}</span></a></li>
             <li class=""><a class="config" href="{{url('receiver')}}"><span>{{trans('menu.Config')}}</span></a></li>
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
             <li class=""><a href="{{url('bite')}}">{{trans('menu.Bite')}}</a></li>
             <li class=""><a href="{{url('sysUpgrade')}}">{{trans('menu.SysUpgrade')}}</a></li>
             <li class=""><a href="{{url('devUpgrade')}}">{{trans('menu.DevUpgrade')}}</a></li>
          {{--   <li class=""><a href="{{url('sysBackup')}}">{{trans('menu.SysBackup')}}</a></li>--}}
             <li class=""><a href="{{url('progUpdate')}}">{{trans('menu.ProUpdate')}}</a></li>
             <li class="on"><a href="{{url('dataExport')}}">{{trans('menu.Export')}}</a></li>
             <li class=""><a href="{{url('sysTest')}}">{{trans('menu.Test')}}</a></li>
         </ul>
     </div>
     <div class="left rightCont">
         <table cellpadding="0" cellspacing="0" class="WarpTable">
             <tr>
                 <td rowspan="5"  class="plane"><img src="{{$plane['ImagePath']}}"/></td>
                 <td><label>{{trans('飞机序列号')}}</label></td>
                 <td><span>{{$plane['AircraftID']}}</span></td>
                 <td><label>{{trans('飞机机型')}}</label></td>
                 <td><span>{{$plane['Manufacturer']." ".$plane['Type']}}</span></td>
             </tr>
             <tr>
                 <td><label>{{trans('飞机注册号')}}</label></td>
                 <td><span>{{$plane['RegisterNo']}}</span></td>
                 <td><label>{{trans('注册国家（缩写）')}}</label></td>
                 <td><span>{{$plane['RegisterNation']}}</span></td>
             </tr>
             <tr>
                 <td><label>{{trans('头端服务器序列号')}}</label></td>
                 <td><span>{{$plane['ComponentNo']}}</span></td>
                 <td><label>{{trans('系统型号')}}</label></td>
                 <td><span>{{$plane['ProductNo']}}</span></td>
             </tr>
             <tr>
                 <td><label>{{trans('生产日期')}}</label></td>
                 <td><span>{{$plane['ManufactureDate']}}</span></td>
                 <td><label>{{trans('注册日期')}}</label></td>
                 <td><span>{{$plane['RegisterDate']}}</span></td>
             </tr>
             <tr>
                 <td><label>{{trans('飞机简介')}}</label></td>
                 <td colspan="3"><span>{{$plane['Descs']}}</span></td>
             </tr>
         </table>
     </div>
     @include('common.keyboard')
 @stop

 @section('footer')
     <script type="text/javascript" src='{{asset('/js/validator.js')}}'></script>
     <script type="text/javascript" src='{{asset('/keyboard/js/keyboard.js')}}'></script>
     <script type="text/javascript" src='{{asset('/js/common.js')}}'></script>
     <script type="text/javascript" src='{{asset('/js/dataImport.js')}}'></script>
 @stop