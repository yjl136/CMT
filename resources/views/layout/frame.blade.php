<!doctype html>
<html lang="{{config('app.locale')}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{trans('空中娱乐管理系统')}}</title>
    <link rel="shortcut icon" href="{{asset('img/logos')}}/{{config('app.airline_company')}}/{{'favicon.ico'}}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/base.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/home.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/config.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/system.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('')}}{{ config('app.theme')}}/{{'/css/sys.css' }}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('')}}{{ config('app.theme')}}/{{'/css/monitor.css' }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/keyboard/css/keyboard.css') }}"/>
    @yield('style')
</head>
<body class="mainbody">
<div class="main">
    @yield('content')
</div>


</body>
<script type="text/javascript" src="{{ asset('/widget/jquery-3.1.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/widget/vue.min.js') }}"></script>
<script type="text/javascript" src='{{asset('/widget/axios.min.js')}}'></script>
<script type="text/javascript" src='{{asset('/widget/jquery.i18n.properties.js')}}'></script>
<script type="text/javascript" src="{{ asset('/layer/layer.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/status.js') }}"></script>
@yield('footer')
</html>