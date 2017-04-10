@extends('layout.frame')

@section('content')
	<div class="topBox">
		<div class="left {{config('app.locale') == 'zh_cn' ? 'logo' : 'logo_en'}}"></div>
		<ul class="topMenu left">
			<li class=""><a class="index" href="{{url('maintenance/topo')}}"><span>{{trans('menu.Home')}}</span></a></li>
			<li class=""><a class="monitor" href="{{url('maintenance/list')}}"><span>{{trans('menu.Device')}}</span></a></li>
			<li class=""><a class="maintenance" href="{{url('maintenance/bite')}}"><span>{{trans('menu.Maintain')}}</span></a></li>
			<li class="on"><a class="system" href="{{url('maintenance/operateLog')}}"><span>&nbsp;{{trans('menu.Information')}}&nbsp;</span></a></li>
		</ul>
		<ul class="topUser right">
			<li class="user"><a href="#"><i style="background: url({{ asset('/img/logos') }}/{{config('app.airline_company')}}/{{'user_logo.png'}}) repeat 0 0;"></i><span>{{trans('menu.Hello')}}!{{trans('menu.Maintenance')}}</span></a></li>
			<li class="loginOut"><a href="{{url('logout')}}"><i></i><span>{{trans('menu.Exit')}}</span></a></li>
		</ul>
	</div>
	<div class="left leftMenu">
		<ul>
			<li class=""><a href="{{url('maintenance/operateLog')}}">{{trans('menu.Logs')}}</a></li>
			<li class="on"><a href="{{url('maintenance/version')}}">{{trans('menu.Version')}}</a></li>
		</ul>
	</div>
	<div class="left rightCont">
		<div class="versionBox mtop20">
			@foreach($versionInfo as $version)
			<div class="list">
				<div class="img">
					<img src="{{asset('/img')}}/{{strtolower($version->Name).'.png'}}" />
					<span></span>
				</div>
				<div class="boutState">
					<h4>{{$version->Name}}</h4>
					<p>{{trans('件号: ')}}{{$version->DevNumber}}</p>
					<p>{{trans('MOD号: ')}}{{$version->DevModel}}</p>
					<p>{{trans('生产序列号: ')}}{{$version->DevSeq}}</p>
					<p>{{trans('软件版本号: ')}}{{$version->CurVersion}}</p>
					<p>{{trans('平台版本号: ')}}{{$version->CurSysVersion}}</p>
					<p>{{trans('应用版本号: ')}}{{$version->CurAppVersion}}</p>
					@if ($version->Name === 'Server')
						<p>{{trans('content.Config')}}:&nbsp;&nbsp;&nbsp;{{$version->CurConfVersion}}</p>
					@else
						<p></p>
					@endif
				</div>
			</div>
			@endforeach
		</div>
	</div>
@stop

