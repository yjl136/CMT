@extends('layout.frame')

@section('content')
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
	<div class="monitorCont mtop10" id="device_info">
		@foreach ($deviceInfos as $deviceInfo)
			<div class="State left {{$deviceInfo->DevStatus==2 ? '' : 'unline'}}">
				<a href="#" onclick="{{$deviceInfo->DevStatus==2 ? "showDevice('$deviceInfo->DevID')" : "layerMessage()"}}" class="img"><img src="img/{{strtolower($deviceInfo->Name)}}.png" /><span></span></a>
				<div class="boutState">
					<h4>{{$deviceInfo->Name}}{{$deviceInfo->DevType==15 ? substr($deviceInfo->DevPosition,-2) : ''}}</h4>
					<p>{{trans($deviceInfo->Descs)}}</p>
					<p>IP:  {{$deviceInfo->IPAddress}}</p>
					<p>MAC:  {{$deviceInfo->DevID}}</p>
				</div>
			</div>
		@endforeach
	</div>
@stop


@section('footer')
	<script type="text/javascript" src='{{asset('/js/devlist.js')}}'></script>
@stop