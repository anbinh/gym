<div style="text-align:center;height:286px;position: relative;">
	<div style="display: inline-block;margin: auto;  
		  position: absolute;
		  left:0;
		  right: 0;
		  top: 70px;
		  bottom: 0;">
	<?php echo __('You are about to');?> <br>
	<?php echo __('remove the program.');?><br>
	<?php echo __('Are you sure');?><br>
	<?php echo __('you want to delete it?');?><br>
	<br>
	<input ng-click="delete_program();" type="button" class="btn button_white" value="<?php echo __('DELETE');?>"> 
	<input style="font-weight: bold;" ng-click="cancel();" type="button" class="btn button_green" value="<?php echo __('CANCEL');?>"> 
	<div>
</div>