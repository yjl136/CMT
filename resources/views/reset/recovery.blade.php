 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $system_name;?></title>
<?php echo Trans::linkCss("style/".getTheme()."/css/sys.css");?>
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
	        	<p class="message text-left"><i class="icoPop"></i><?php echo trans('说明：从外挂硬盘系统启动，并还原主系统。');?></p>
	        	<div class="subBox"><a href="#" class="Buton" onclick="recovery();"><?php echo trans("系统还原");?></a></div>
	        </div>
        </div>
    </div>
</div>
</body>
</html>