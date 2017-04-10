<div class="blockBox mtop10">
	<p class="redMessage">
		<i class="icoFail"></i><?php echo $error_msg;?>
	</p>
	<table cellpadding="0" cellspacing="0" border="0" class="mTable">
		<tr>
			<th><?php echo trans("版本信息");?>：</th>
			<td><?php echo $error_log["version"];?></td>
			<th><?php echo trans("节目创建时间");?>：</th>
			<td><?php echo $error_log["create_time"];?></td>
			<th><?php echo trans("节目更新时间");?>：</th>
			<td><?php echo $error_log["update_time"];?></td>
		</tr>
		<?php $resource_list = $error_log["resource_list"];?>
		<?php if(count($resource_list)):?>
		<tr>
			<th><?php echo trans("EPG文件错误");?>：</th>
			<td colspan="5"><b><?php echo count($resource_list);?></b></td>
		</tr>
		<tr>
			<td colspan="6" class="mtableshow">
				<?php foreach($resource_list as $file):?>
				<div>
					<i></i><?php echo $file;?>
				</div>
				<?php endforeach;?>
			</td>
		</tr>
		<?php endif;?>
		<?php $video_list = $error_log["video_list"];?>
		<?php if(count($video_list)):?>
		<tr>
			<th><?php echo trans("视频错误");?>：</th>
			<td colspan="5"><b><?php echo count($video_list);?></b></td>
		</tr>
		<tr>
			<td colspan="6" class="mtableshow">
				<?php foreach($video_list as $file):?>
				<div>
					<i></i><?php echo $file;?>
				</div>
				<?php endforeach;?>
			</td>
		</tr>
		<?php endif;?>
		<?php $audio_list = $error_log["audio_list"];?>
		<?php if(count($audio_list)):?>
		<tr>
			<th><?php echo trans("音频错误");?>：</th>
			<td colspan="5"><b><?php echo count($audio_list);?></b></td>
		</tr>
		<tr>
			<td colspan="6" class="mtableshow">
				<?php foreach($audio_list as $file):?>
				<div>
					<i></i><?php echo $file;?>
				</div>
				<?php endforeach;?>
			</td>
		</tr>
		<?php endif;?>
	</table>
</div>

<div class="subBox">
	<?php foreach ($btn_list as $value):?>
	<a href="#" class="Buton" onclick="<?php echo sprintf("%s();",$value["btn_func"]);?>"><?php echo trans($value["btn_text"]);?></a>
	<?php endforeach;?>
</div>
