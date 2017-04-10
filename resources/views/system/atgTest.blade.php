 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $system_name;?></title>
<?php echo Trans::linkCss("style/".getTheme()."/css/sys.css");?>
<?php echo Trans::linkCss("style/css/system.css");?>
<?php include_once('include/php/common.php');?>
<script type="text/javascript" src="style/js/atgTest.js"></script>
</head>
<body class="mainbody">
<div class="main">
	<!-- 顶部导航栏和状态栏 -->
	<?php include_once('include/php/top.php');?>
	<!-- 左侧菜单  -->
	<?php include_once('include/php/left.php');?>
    <!-- 页面内容 -->
    <div class="left rightCont">
    	<!-- 三级菜单 -->
		<?php include_once('include/php/menu.php');?>
		
		<div class="ap_state_box">
	    	<div class="blockBox mtop10 ap_box">
				<div class="h3">
			    	<h3 class="left"><?php echo trans("WiFi控制模式");?>：</h3>
				    <div class="ap_state left">
				        <a href="#" class="on" id="btn_auto" onclick="switchWifiMode(0);"><?php echo trans("自动模式");?></a>
				        <a href="#" id="btn_manual" onclick="switchWifiMode(1);"><?php echo trans("手动模式");?></a>
				    </div>
			    </div>
			    
	        	<p class="alt"><b><?php echo trans("说明");?></b><br /><?php echo trans("系统默认为自动模式，切换为手动模式后30分钟自动切换到自动模式。");?>
	        	</p>    			
			    <ul id="ap_box">
			        <li class="tloading" id="CPE"><span class="ico_cpe"></span><label><?php echo $cpe["Name"];?></label><a href="#" class="hidden" onclick="switchATG();"><em>off</em></a></li>
			    </ul>
			    <div class="clear"></div>
			    
			    <!-- 错误信息页面 -->
			    <p class="redMessage hidden" id="msgbox"><i id="msgicon" class="icoFail"></i><span id="msg"></span></p>
	    	</div>
	    	
	    	<p class="subBox mtop10 hidden" id="btn_box">
		        <a href="#" class="Buton" id="btn_time" onclick="forceSwitchMode();"><?php echo trans("手动模式剩余时间");?></a>
		    </p>
	    </div>        
    </div>
</div>
</body>
</html>