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
                <td><label><?php echo trans("航班号");?></label></td>
                <td><span><?php echo $flight["FlightNumber"];?></span></td>
                <td><label><?php echo trans("飞机序列号");?> </label></td>
                <td><span><?php echo $flight["AircraftID"];?></span></td>
            </tr>
            <tr>
                <td><label><?php echo trans("飞机标识");?></label></td>
                <td><span><?php echo $flight["AirplaneID"];?></span></td>
                <td><label><?php echo trans("飞机类型");?></label></td>
                <td><span><?php echo $flight["AircraftType"];?></span></td>
            </tr>
            <tr>
                <td><label><?php echo trans("飞机尾翼号");?></label></td>
                <td><span><?php echo $flight["AircraftTail"];?></span></td>
                <td><label><?php echo trans("航空公司");?></label></td>
                <td><span><?php echo $flight["AirlineID"];?></span></td>
            </tr>
            <tr>
                <td><label><?php echo trans("出发地");?></label></td>
                <td><span><?php echo $flight["Origin"];?></span></td>
                <td><label><?php echo trans("目的地");?></label></td>
                <td><span><?php echo $flight["Destination"];?></span></td>
            </tr>
            <tr>
                <td><label><?php echo trans("预计起飞时间");?></label></td>
                <td><span><?php echo $flight["PlanDepartureTime"];?></span></td>
                <td><label><?php echo trans("预计到达时间");?></label></td>
                <td><span><?php echo $flight["PlanArrivalTime"];?></span></td>
            </tr>
            <tr>
                <td><label><?php echo trans("实际起飞时间");?></label></td>
                <td><span><?php echo $flight["ActualDepartureTime"];?></span></td>
                <td><label><?php echo trans("实际到达时间");?></label></td>
                <td><span><?php echo $flight["ActualArrivalTime"];?></span></td>
            </tr>
            <tr>
                <td><label><?php echo trans("目的地介绍");?></label></td>
                <td colspan="3"><span><pre><?php echo $flight["DestinationIntro"];?></pre></span></td>
            </tr>
            <tr>
                <td><label><?php echo trans("航班优惠信息");?></label></td>
                <td colspan="3"><span><pre><?php echo $flight["DiscountInfo"];?></pre></span></td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>