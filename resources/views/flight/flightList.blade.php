 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $system_name;?></title>
<?php echo Trans::linkCss("style/".getTheme()."/css/sys.css");?>
<?php echo Trans::linkCss("style/css/flight.css");?>
<?php include_once('include/php/common.php');?>
</head>
<body class="mainbody">
<div class="main">
	<!-- 顶部导航栏和状态栏 -->
	<?php include_once('include/php/top.php')?>
	<!-- 左侧菜单  -->
	<?php include_once('include/php/left.php')?>
    <!-- 页面内容 -->
    <div class="left rightCont mflight">
    <?php foreach ($list as $flight):?>
        <div class="blockBox">
            <div class="col_1"><?php echo trans('航班号');?>：<b><?php echo $flight['FlightNumber'];?></b></div>
            <div class="col_2">
                <p class="city"><span class="r"><?php echo $flight['Origin'];?></span><i></i><span><?php echo $flight['Destination'];?></span></p>
                <p class="time"><span class="r"><?php echo $flight['ETD'];?></span><i></i><span><?php echo $flight['ETA'];?></span></p>
            </div>
            <div class="col_3">
                <a href="index.php?group=flight&menu=flight&module=flight&action=flightInfo&id=<?php echo $flight['ID'];?>" class="Buton aboutXq"><?php echo trans('查看详情');?></a>
            </div>
        </div> 
    <?php endforeach;?>
    
    <?php echo $page_nav;?>
    </div>
	
</div>
</body>
</html>