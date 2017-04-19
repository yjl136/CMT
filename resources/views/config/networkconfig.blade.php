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
			<li class="on"><a href="{{url('network')}}">{{trans('menu.NetWorkSetting')}}</a></li>
			 <li class=""><a href="{{url('transmission')}}">{{trans('menu.Transfer')}}</a></li>
			 <li class=""><a href="{{url('system')}}">{{trans('menu.System')}}</a></li>
			 <li class=""><a href="{{url('timesync')}}">{{trans('menu.TimeSetting')}}</a></li>
		 </ul>
	 </div>
	 <div class="left rightCont">
		 <div>
			 <div class="Screening blockBox mtop10">
				 <ul>
					 <li id="transWayBox">
						 <label>{{trans('组网模式')}}：</label>
						 <a href="#" class="on">
							 <i id="1" class="{{$data->var_value?'checkbox':'checkbox_on'}}"></i>{{trans('并联')}}
						 </a>
						 <a href="#" class="on">
							 <i id="4" class="{{$data->var_value?'checkbox_on':'checkbox'}}"></i>{{trans('串联')}}
						 </a>
					 </li>
				 </ul>
			 </div>

			 <div class="subBox">
				 <a href="#" class="Buton" onclick="saveNetworkMode();">{{trans('button.Save')}}</a>
				 <a href="#" class="Buton" onclick="back();">{{trans('button.Cancel')}}</a>
			 </div>
		 </div>
	 </div>
 @stop

 @section('footer')
	 <script type="text/javascript" src='{{asset('js/validator.js')}}'></script>
	 <script type="text/javascript" src='{{asset('js/network.js')}}'></script>
 @stop