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
			{{-- <li class=""><a href="{{url('sysBackup')}}">{{trans('menu.SysBackup')}}</a></li>--}}
			 <li class=""><a href="{{url('progUpdate')}}">{{trans('menu.ProUpdate')}}</a></li>
			 <li class="on"><a href="{{url('dataExport')}}">{{trans('menu.Export')}}</a></li>
			 <li class=""><a href="{{url('sysTest')}}">{{trans('menu.Test')}}</a></li>
		 </ul>
	 </div>
	 <div class="left rightCont">
     		<?php include_once('include/php/menu.php')?>
		 <div class="blockBox mtop10" id="notebox">
			 <p class="message">
				 <i class="icoPop"></i>
				 {{trans('说明：数据导入是将USB设备中的import文件夹下的所有文件导入到数据库中，目前只支持XML格式或者FRM格式。')}}
			 </p>
			 <div class="subBox">
				 <a class="Buton" href="#" onclick="checkTransWay();">{{trans('导入')}}</a>
			 </div>
		 </div>
		 <div class="hidden" id="msgbox"></div>
	 </div>
	 @include('common.keyboard')
 @stop

 @section('footer')
	 <script type="text/javascript" src='{{asset('/js/validator.js')}}'></script>
	 <script type="text/javascript" src='{{asset('/keyboard/js/keyboard.js')}}'></script>
	 <script type="text/javascript" src='{{asset('/js/common.js')}}'></script>
	 <script type="text/javascript" src='{{asset('/js/dataImport.js')}}'></script>
 @stop