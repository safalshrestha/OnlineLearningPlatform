<?php
$attributes = array('class'=>'form-signin','id' => 'login',);
echo form_open('/admin/addHelp', $attributes);?>

<!--      <form class="form-signin"> -->
	<h2 class="form-signin-heading">Enter your message:</h2>
	<input type="hidden" name="email" class="input-block-level" placeholder="Email address" value="<?php echo $this->session->userdata['email']; ?>">
	<?= form_hidden('email', set_value('email')) ?>

	<input type="text" name="subject" class="input-block-level" placeholder="Subject" style="margin-left: 0px; margin-right: 0px; width: 300px;">
	<?= form_hidden('subject', set_value('subject')) ?>

	<br />
	<textarea name="message" rows="15" style="margin-left: 0px; margin-right: 0px; width: 300px;"> Type your message here </textarea>	
	<?= form_input('message', set_value('message')) ?>

	<br />
	
	<button class="btn btn-large btn-primary" type="submit">Send</button>
</form>