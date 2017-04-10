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
        <table cellpadding="0" cellspacing="0" class="WarpTable mtop15">
            <tr>
                <td><label><?php echo trans('中文名');?></label></td>
                <td><span><?php echo $passenger['ChineseName'];?></span></td>
                <td><label><?php echo trans('英文名');?> </label></td>
                <td><span><?php echo $passenger['EnglishName'];?></td>
            </tr>
            <tr>
                <td><label><?php echo trans('航班号');?></label></td>
                <td><span><?php echo $passenger['FlightNumber'];?></span></td>
                <td><label><?php echo trans('飞行日期');?></label></td>
                <td><span><?php echo $passenger['FlightDate'];?></span></td>
            </tr>
            <tr>
                <td><label><?php echo trans('出发地');?></label></td>
                <td><span><?php echo $passenger['Origin'];?></span></td>
                <td><label><?php echo trans('目的地');?></label></td>
                <td><span><?php echo $passenger['Destination'];?></span></td>
            </tr>
            <tr>
                <td><label><?php echo trans('座位号');?></label></td>
                <td><span><?php echo sprintf("%s(%s)", $passenger['Class'], $passenger['Seat']);?></span></td>
                <td><label><?php echo trans('序号');?></label></td>
                <td><span><?php echo $passenger['No'];?></td>
            </tr>
            <tr>
                <td><label><?php echo trans('登机口');?></label></td>
                <td><span><?php echo $passenger['Gate'];?></span></td>
                <td><label><?php echo trans('登机时间');?></label></td>
                <td><span><?php echo $passenger['BoardingTime'];?></span></td>
            </tr>
            <tr>
                <td><label><?php echo trans('证件类型');?></label></td>
                <td><span><?php echo $passenger['ID_Type'];?></span></td>
                <td><label><?php echo trans('证件号');?></label></td>
                <td><span><?php echo $passenger['ID_Number'];?></span></td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>