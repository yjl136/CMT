 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $system_name;?></title>
<?php echo Trans::linkCss("style/".getTheme()."/css/sys.css");?>
<?php echo Trans::linkCss("style/css/system.css");?>
<?php echo Trans::linkCss("widget/keyboard/css/keyboard.css");?>
<?php include_once('include/php/common.php');?>
<script src="style/js/factoryReset.js"></script>
</head>
<body class="mainbody">
<div class="main">
	<!-- 顶部导航栏和状态栏 -->
	<?php include_once('include/php/top.php')?>
	<!-- 左侧菜单  -->
	<?php include_once('include/php/left.php')?>
    <!-- 页面内容 -->
    <div class="left rightCont">
		<div>
	        <div class="Screening blockBox mtop10">
	        	<p class="message text-left"><i class="icoPop"></i><?php echo trans('说明：恢复出厂设置将重置用户密码为发布说明中的密码、清除CMT系统和epg系统的缓存文件、重置时区设置、重置DNS，请登出系统重新登录。');?></p>
	        	<div class="subBox"><a href="#" class="Buton" onclick="resetUser();"><?php echo trans("系统重置");?></a></div>
	        </div>
            <div class="ckshow">
                 <ul>
                     <li class="ok"><i></i>恢复用户密码成功....</li>
                     <li class="ok"><i></i>已清除CMT及EPG缓存....</li>
                     <li class="ror"><i></i>重置时区失败....</li>
                     <li><i></i>重置DNS....</li>
                     <li class="ok"><i></i>系统恢复完成，请<a href="#">重新登录系统</a></li>
                     
                </ul>
            </div>
        </div>
    </div>
	
</div>

<?php include_once('widget/keyboard/php/keyboard.blade.php')?>
</body>
</html>