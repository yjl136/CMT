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
    <div class="left rightCont">
    	<table class="Table">
            <tr>
                <th><?php echo trans('姓名');?></th>
                <th><?php echo trans('航班号');?></th>
                <th><?php echo trans('出发地');?></th>
                <th><?php echo trans('目的地');?></th>
                <th><?php echo trans('飞行日期');?></th>
                <th><?php echo trans('座位号');?></th>
                <th><?php echo trans('操作');?></th>
            </tr>
            <?php foreach ($list as $passenger): ?>
            <tr>
                <td><?php echo sprintf("%s(%s)", $passenger['ChineseName'], $passenger['EnglishName']);?></td>
                <td><?php echo $passenger['FlightNumber'];?></td>
                <td><?php echo $passenger['Origin'];?></td>
                <td><?php echo $passenger['Destination'];?></td>
                <td><?php echo $passenger['FlightDate'];?></td>
                <td><?php echo sprintf("%s(%s)", $passenger['Class'], $passenger['Seat']);?></td>
                <td>
                	<a class="Buton" href="index.php?group=flight&menu=passenger&module=flight&action=passengerInfo&id=<?php echo $passenger['ID'];?>"><?php echo trans('查看详情');?></a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
        
        <div class="mtop15">
        	<?php echo $page_nav;?>
        </div>
    </div>
</div>
</body>
</html>