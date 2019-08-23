<?php
$attributes = array('class'=>'form-signin','id' => 'login',);
echo form_open('/admin/addMessage', $attributes);?>

<!--      <form class="form-signin"> -->
	<h2 class="form-signin-heading">Enter your message:</h2>
	<input type="text" name="email" class="input-block-level" placeholder="Email address">
	<?= form_hidden('email', set_value('email')) ?>

	<input type="text" name="subject" class="input-block-level" placeholder="Subject" style="margin-left: 0px; margin-right: 0px; width: 300px;">
	<?= form_input('subject', set_value('subject')) ?>

	<br />
	<textarea id="content" name="message" rows="15" style="margin-left: 0px; margin-right: 0px; width: 300px;"> Type your message here </textarea>	
	<?= form_input('message', set_value('message')) ?>

	<br />
	
	<button class="btn btn-large btn-primary" type="submit">Send</button>
</form>

<script>
  	$(function() {
    	$('#content').htmlarea();
  	});
</script>