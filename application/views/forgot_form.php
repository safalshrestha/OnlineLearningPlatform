<?php 
	$this->load->helper('html'); 
	echo br(5);
?>

<?php $this->load->helper('form'); 
$attributes = array('class'=>'form-signin','id' => 'login', 'enctype' => 'multipart/form-data');
echo form_open('admin/retrievePassword', $attributes);?>

<!--      <form class="form-signin"> -->
	<h2 class="form-signin-heading">Enter Your Detail</h2>
	<input type="text" name="email" class="input-block-level" placeholder="Email address">
	<?= form_input('email', set_value('email')) ?>

	<input type="password" name="id" class="input-block-level" placeholder="Unique ID">
	<?= form_input('password', set_value('id')) ?>

	
		<?php
			if ($status =="verification") {
				echo '<div class="alert alert-error">';
				echo '<h4>Invalid Credentials!</h4><em>';
				echo '</em></div>';

			}
			else if ($status == "validation") {
				echo '<div class="alert alert-error">';
				echo '<h4>Invalid Data!</h4><em>';
				echo '</em></div>';
			}
			else if ($status !="") {
				echo '<div class="alert alert-success">';
				echo '<h4>New Password!</h4><em>';
				echo $status;
				echo '</em></div>';

			}
		?>
	<button class="btn btn-large btn-primary" type="submit">Sign in</button>
</form>