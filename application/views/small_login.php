<?php
	echo form_open('admin/login');
?>
	<div class="input-prepend">
		<span class="add-on"><i class="icon-user"></i></span>
		<input type = "text" id="inputIcon" name="email" placeholder="Email" />
	</div>
	<div class="input-prepend">
		<span class="add-on"><i class="icon-pencil"></i></span>
		<input type = "password" id="inputIcon" name="password" placeholder="Password" />
	</div>
	<button class="btn btn-primary" type="submit">Sign in</button>
	<input type="button" class="btn btn-inverse" value="Forgot" onClick="location.href='/admin/forgotpassword_form'" />
</form>