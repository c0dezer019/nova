<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($label['text'], 'p');?>

<?php echo form_open('update/check', ['class' => 'mt-8']);?>
	<div>
		<label><?php echo $label['email'];?></label>
		<?php echo form_input($inputs['email']);?>
	</div>

	<div>
		<label><?php echo $label['password'];?></label>
		<?php echo form_password($inputs['password']);?>
	</div>

	<div>
		<?php echo form_button($inputs['submit']);?>
	</div>
<?php echo form_close();?>