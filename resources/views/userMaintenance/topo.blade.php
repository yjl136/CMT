@extends('layout.frame')

@section('content')
	<div class="topBox">
		<div class="left {{config('app.locale') == 'zh_cn' ? 'logo' : 'logo_en'}}"></div>
		<ul class="topMenu left">
			<li class="on"><a class="index" href="{{url('maintenance/topo')}}"><span>{{trans('menu.Home')}}</span></a></li>
			<li class=""><a class="monitor" href="{{url('maintenance/list')}}"><span>{{trans('menu.Device')}}</span></a></li>
			<li class=""><a class="maintenance" href="{{url('maintenance/bite')}}"><span>{{trans('menu.Maintain')}}</span></a></li>
			<li class=""><a class="system" href="{{url('maintenance/operateLog')}}"><span>&nbsp;{{trans('menu.Information')}}&nbsp;</span></a></li>
		</ul>
		<ul class="topUser right">
			<li class="user"><a href="#"><i style="background: url({{ asset('/img/logos') }}/{{config('app.airline_company')}}/{{'user_logo.png'}}) repeat 0 0;"></i><span>{{trans('menu.Hello')}}!{{trans('menu.Maintenance')}}</span></a></li>
			<li class="loginOut"><a href="{{url('logout')}}"><i></i><span>{{trans('menu.Exit')}}</span></a></li>
		</ul>
	</div>
	<div class="bodybox">
		<a href="{{url('maintenance/flight')}}" id="tab1" class="tab1 tab1_"></a>
		<a href="{{url('maintenance/topo')}}" id="tab2" class="tab2"></a>
		<div class="body2 mtop10">
			<div class="airLayout">
				<div class="csa">
					@foreach ($deviceInfos as $deviceInfo)
						<a id="{{strtolower($deviceInfo->Name)}}{{$deviceInfo->DevType==15 ? substr($deviceInfo->DevPosition,-2) : ''}}"
						   href="#"
						   onclick="{{$deviceInfo->DevStatus==2 ? "showDevice('$deviceInfo->DevID')" : "layerMessage()"}}"
						   class="{{strtolower($deviceInfo->Name)}}{{$deviceInfo->DevType==15 ? substr($deviceInfo->DevPosition,-2) : ''}}{{$deviceInfo->DevStatus==2 ? '' : '_'}}">
						</a>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@stop

@section('footer')
	<script type="text/javascript" src='{{asset('/js/devlist.js')}}'></script>
@stop