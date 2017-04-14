@extends('layout.frame')

@section('content')
	<div class="topBox">
		<div class="left {{config('app.locale') == 'zh_cn' ? 'logo' : 'logo_en'}}"></div>
		<ul class="topMenu left">
			<li class=""><a class="index" href="{{url('maintenance/topo')}}"><span>{{trans('menu.Home')}}</span></a></li>
			<li class=""><a class="monitor" href="{{url('maintenance/list')}}"><span>{{trans('menu.Device')}}</span></a></li>
			<li class="on"><a class="maintenance" href="{{url('maintenance/bite')}}"><span>{{trans('menu.Maintain')}}</span></a></li>
			<li class=""><a class="system" href="{{url('maintenance/operateLog')}}"><span>&nbsp;{{trans('menu.Information')}}&nbsp;</span></a></li>
		</ul>
		<ul class="topUser right">
			<li class="user"><a href="#"><i style="background: url({{ asset('/img/logos') }}/{{config('app.airline_company')}}/{{'user_logo.png'}}) repeat 0 0;"></i><span>{{trans('menu.Hello')}}!{{trans('menu.Maintenance')}}</span></a></li>
			<li class="loginOut"><a href="{{url('logout')}}"><i></i><span>{{trans('menu.Exit')}}</span></a></li>
		</ul>
	</div>
	<div class="left leftMenu">
		<ul>
			<li class=""><a href="{{url('maintenance/bite')}}">{{trans('menu.Bite')}}</a></li>
			<li class="on"><a href="{{url('maintenance/sysUpgrade')}}">{{trans('menu.SysUpgrade')}}</a></li>
			<li class=""><a href="{{url('maintenance/sysBackup')}}">{{trans('menu.SysBackup')}}</a></li>
			<li class=""><a href="{{url('maintenance/progUpdate')}}">{{trans('menu.ProUpdate')}}</a></li>
			<li class=""><a href="{{url('maintenance/dataExport')}}">{{trans('menu.Export')}}</a></li>
			<li class=""><a href="{{url('maintenance/sysTest')}}">{{trans('menu.Test')}}</a></li>
		</ul>
	</div>
	<div class="left rightCont">
		<div class="scrollTex mtop20" id="stepbox">
			<span class="b1 on" id="step1">{{trans('content.System Detection')}}</span>
			<span class="b2" id="step1">{{trans('content.Query Update')}}</span>
			<span class="b3" id="step3">{{trans('content.Copy update package')}}</span>
			<span class="b4" id="step4">{{trans('content.Upgrade system')}}</span>
		</div>
		<div class="scrollBarBg">
			<div class="on b1" id="scrollbar"></div>
		</div>
		<div  id="step1box">
			<div class="blockBox mtop20" >
				<div class="Screening">
					<ul>
						<li id="transWayBox">
							<label>{{trans('content.Update mode')}}：</label>
							<a href="#" class="on">
								<i id="1" class="checkbox_on"></i>{{trans('USB')}}
							</a>
							<a href="#" class="on">
								<i id="4" class="checkbox"></i>{{trans('FTP')}}
							</a>
						</li>
					</ul>
				</div>
				<p class="message">
					<i class="icoPop"></i>
					{{trans('content.Note: System upgrade is to upgrade the software and the kernel of each component. /<\br/>Please click \'Next\' button after inserting device.')}}
				</p>
			</div>
			<div class="subBox">
				<a class="Buton" href="#" onclick="checkTransWay();">{{trans('button.Next')}}</a>
			</div>
		</div>
		<div  id="step2box" class="hidden">
			<div class="blockBox mtop20">
				<table cellpadding="0" cellspacing="0" border="0" class="TableMo">
					<tr>
						<th>{{trans('content.Device Name')}}</th>
						<th>{{trans('content.Current Version')}}</th>
						<th>{{trans('content.Package Version')}}</th>
					</tr>
					<tbody id="versiontab">
					</tbody>
				</table>
			</div>
			<div class="subBox">
				<a href="#" class="Buton" onclick="copyPackage();">{{trans('button.Next')}}</a>
				<a href="#" class="Buton" onclick="init();">{{trans('button.Back')}}</a>
			</div>
		</div>
		<div class="blockBox mtop20 hidden"  id="step3box">
			<div class="loading">
				<p id="progressmsg"></p>
				<div class="bg">
					<label id="pg_percent">0%</label>
					<span id="pg_bar" style="width:0%"></span>
				</div>
			</div>
		</div>
		<div id="step4box" class="hidden">
			<div class="blockBox mtop20" >
				<p class="message">
					<i class="icoSuccess"></i>
					{{trans('maintain.sysrebootdes')}}
				</p>
			</div>
			<div class="subBox">
				<a href="#" class="Buton" onclick="init();">{{trans('button.Back')}}</a>
			</div>
		</div>
		<div class="hidden" id="msgbox"></div>
	</div>
@stop

@section('footer')
	<script type="text/javascript" src='{{asset('/js/systemUpdate.js')}}'></script>
	<script type="text/javascript" src='{{asset('/js/common.js')}}'></script>
@stop