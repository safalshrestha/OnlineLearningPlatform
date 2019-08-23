<?php 
	$this->load->helper('html'); 
	echo br(5);
?>

<?php $this->load->helper('form'); 
$attributes = array('class'=>'form-signin','id' => 'login', 'enctype' => 'multipart/form-data');
echo form_open('admin/login', $attributes);?>

<!--      <form class="form-signin"> -->
	<h2 class="form-signin-heading">Please sign in</h2>
	<input type="text" name="email" class="input-block-level" placeholder="Email address">
	<?= form_input('email', set_value('email')) ?>
	<?= form_error('email')?>

	<input type="password" name="password" class="input-block-level" placeholder="Password">
	<?= form_input('password', set_value('password')) ?>
	<?= form_error('password')?>

	<label class="checkbox">
	<input type="checkbox" value="remember-me"> Remember me
	</label>
	
		<?php
			if ($status !="") {
				echo '<div class="alert alert-error">';
				echo '<h4>Warning!</h4><em>';
  				echo $status;
				echo '</em></div>';

			}
		?>
	<button class="btn btn-large btn-primary" type="submit">Sign in</button>
	
	<input type="button" class="btn btn-large btn-inverse" onClick="location.href='/admin/forgotpassword_form'" value="Forgot Password" />
	</div>
</form>