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
			 <li class=""><a href="{{url('transmission')}}">{{trans('menu.Transfer')}}</a></li>
			 <li class=""><a href="{{url('system')}}">{{trans('menu.System')}}</a></li>
			 <li class="on"><a href="{{url('timesync')}}">{{trans('menu.TimeSetting')}}</a></li>
		 </ul>
	 </div>
	 <div class="left rightCont">
		 <div>
			 <div class="Screening blockBox mtop10">
				 <p class="message text-left">
					 <i class="icoPop"></i>
					 {{trans('content.Note: Time setting is to set the system time of Server manually, and it will reboot the whole system when completed.')}}
				 </p>
				 <ul class="bottom10">
					 <li>
						 <label class="middle">
							 {{trans('content.Current Time')}}{{ $timeType==0 ?  "" : trans("UTC") }}:
						 </label>
						 <input id="current_time" type="text" class="ipt"  value="{{$timeType==0 ? $current_time : $utc_time}}" onclick="showKeyboard(this, 20, 'all', '-1');"/>
					 </li>
				 </ul>
			 </div>

			 <div class="subBox">
				 <a href="#" class="Buton" onclick="timesync();">{{trans('button.Save')}}</a>
			 </div>
		 </div>
	 </div>
	 @include('common.keyboard')
 @stop

 @section('footer')
	 <script type="text/javascript" src='{{asset('js/validator.js')}}'></script>
	 <script type="text/javascript" src='{{asset('js/timesync.js')}}'></script>
 @stop