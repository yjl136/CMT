 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $system_name;?></title>
<?php echo Trans::linkCss("style/".getTheme()."/css/sys.css");?>
<?php echo Trans::linkCss("style/css/system.css");?>
<?php include_once('include/php/common.php');?>
<script src='style/js/devReboot.js'></script>
</head>
<body class="mainbody">
<div class="main">
	<!-- 顶部导航栏和状态栏 -->
	<?php include_once('include/php/top.php')?>
	<!-- 左侧菜单  -->
	<?php include_once('include/php/left.php')?>
    <!-- 页面内容 -->
    <div class="left rightCont">
	    <div class="Testing_box blockBox mtop10">
		    <ul class="btn_ctrl">
		    	<?php foreach($list as $device):?>
		        <li onclick="rebootDevice(<?php echo sprintf("%s, '%s'", $device["DevType"], $device["DevPosition"]);?>)" class=""><a href="#" class="<?php echo empty($device["Name"]) ? "" : "img_".strtolower($device["Name"]);?>"><?php echo $device["NameText"];?></a><span></span></li>
		        <?php endforeach;?>
		    </ul> 
	    </div>
    
    	<!-- 结果信息页面 -->
        <div class="blockBox mtop10 hidden" id="msgbox">
        	<p class="redMessage" id="msgwrap"><i id="msgicon" class="icoFail"></i><span id="msg"></span></p>
        </div>
    </div>
</div>
</body>
</html>