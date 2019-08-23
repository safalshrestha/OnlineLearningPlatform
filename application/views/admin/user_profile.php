
	<div class="row-fluid">
	  <div class="span4">
	  	<!--profile pic-->

	  	<?php 
	  		foreach($users as $user){
	  			
	  			if ($user->profilePic == 0) {
	  				if ($priv==5) { ?>
	  					<img src="/uploads/profile/default_lecturer.png"  class="img-polaroid" />
	  				<?php } 
	  				if ($priv==8) { ?>
	  					<img src="/uploads/profile/default_student.jpg"  class="img-polaroid" />
	  				<?php } 
	  				if ($priv==1 || $priv==2) { ?>
	  					<img src="/uploads/profile/default_admin.jpg"  class="img-polaroid" />
	  				<?php }
	  			} 
	  			else if ($user->profilePic == 1) { ?>
					<img src="/uploads/<?php echo $user->user_id; ?>/profile/profile.jpg"  class="img-polaroid" />
				<?php }	
				
	  	?>

	  		<?php echo form_open_multipart('upload/do_upload'); ?>
		  		<input type="hidden" value="<?php echo $user->user_id; ?>" name="id" />
		  		<input type="hidden" value="<?php echo $priv; ?>" name="priv" />
		  		<input type="file" name="userfile" /> <br />
		  		<input type="submit" value="Change Pic" name="Submit" />
		  	</form>
	  	<?php } ?>


	  	<?php echo "<h3>".$course."</h3>"; 
		  	foreach($subjects as $subject){
		  		foreach($subject_name as $name) {
		  			if ($subject->subject_id == $name->id) echo "<i class='icon-ok'></i> ".$name->name."<br />";
		  		}
		  	}
	  	?>

	  </div>
	  <div class="span4">

	  	<!-- profile user -->
	  	<?php 
	  		foreach($users as $user){
	  	?>
	  		<h4> Edit Profile </h4>
	  		
		  	<?php 	
		  		$attributes = array ('class' => 'form');
		  		echo form_open_multipart('/admin/editProfile', $attributes); ?>
		  		<input type="hidden" value="<?php echo $priv; ?>" name="priv" /> <br />
		  		<input type="hidden" name="id" value="<?php echo $user->user_id; ?>" /> <br />
			  	<input placeholder="Title" type="text" value="<?php echo $user->title; ?>" name='title' /> <br />
			  	<input placeholder="First name" type="text" value="<?php echo $user->first_name;?>" name='first_name' /> <br />
			  	<input placeholder="Family name" type="text" value="<?php echo $user->family_name;?>" name='family_name' /> <br />
			  	<input placeholder="Date of birth" id="datepicker" type="text" value="<?php echo $user->dob;?>" name='dob' /> <br />
			  	<input placeholder="Address: House number" type="text" value="<?php echo $user->add1;?>" name='add1' /> <br />
			  	<input placeholder="Address: Street address" type="text" value="<?php echo $user->add2;?>" name='add2' /> <br />
			  	<input placeholder="Address: Area/Town" type="text" value="<?php echo $user->add3;?>" name='add3' /> <br />
			  	<input placeholder="Address: County" type="text" value="<?php echo $user->add4;?>" name='add4' /> <br />
			  	<input placeholder="Phone" type="text" value="<?php echo $user->phone;?>" name='phone' /> <br />
			  	<input placeholder="Mobile" type="text" value="<?php echo $user->mobile;?>" name='mobile' /> <br />
			  	<input placeholder="Nationality" type="text" value="<?php echo $user->nationality;?>" name='nationality' /> <br />
			  	<input placeholder="Birth country" type="text" value="<?php echo $user->birth_country;?>" name='birth_country' /> <br />
			  	<input placeholder="PPS Number" type="text" value="<?php echo $user->pps_no;?>" name='pps_no' /> <br />
			  	<input type="submit" value="Change" name="Submit" />
			</form>
		<?php } ?>
	  </div>
	  <div class="span4">
	  		<?php 
	  			foreach($users as $user){
	  		?>
	  		<h4> Change Password </h4>
	  		<form action="admin/changePassword" method="POST">
	  			<input type="hidden" name="id" value="<?php echo $user->user_id; ?>" /> <br />
			  	<input placeholder="Current Password" type="password" value="" name='cpassword' /> <br />
			  	<input placeholder="New Password" type="password" value="" name='npassword' /> <br />
			  	<input placeholder="Confirm Password" type="password" value="" name='cnpassword' /> <br />
			  	<input type="submit" value="Change" />
			</form>
			<?php } ?>
	  </div>


	</div>

<script>
  	$(function() {
    	$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
  	});
</script>