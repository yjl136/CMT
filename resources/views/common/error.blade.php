<div class="blockBox mtop10">
	<p class="message">
		<i class="<?php echo $icon_css;?>"></i>
		<span class="<?php echo $msg_css;?>"><?php echo $error_msg;?></span>
	</p>
	<p class="subBox">
		<?php foreach ($btn_list as $value):?>
		<a href="#" class="Buton" onclick="<?php echo sprintf("%s();",$value["btn_func"]);?>"><?php echo trans($value["btn_text"]);?></a>
		<?php endforeach;?>
	</p>
</div>