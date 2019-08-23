<?php
	echo form_open('admin/userProfile2');
?>
	<input type = "hidden" name="id" value="<?php echo $this->session->userdata("user_id"); ?>" />
	<input type = "hidden" name="priv" value="<?php echo $this->session->userdata("privilege"); ?>" />
	<div class="input-prepend">
		<span class="add-on"><i class="icon-user"></i></span>
		<button class="btn btn-primary" id="inputIcon" type="submit"><?php echo $this->session->userdata("email"); ?></button>
	</div>
</form>
	<div class="input-prepend">
		<span class="add-on"><i class="icon-off"></i></span>
		<input type="button" class="btn" id="inputIcon" onClick="location.href='/admin/logout'" value="Log Out" name="logout" />
	</div>
	
