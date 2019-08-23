
	<div class="row-fluid">
	  <div class="span4">
	  	<!--profile pic-->


	  </div>
	  <div class="span8">

	  	<!-- profile user -->
	  		<h4> Message: </h4>
		  	
		  		<input type="hidden" name="id" value="<?php echo $id; ?>" /> <br />
		  		From:  <span class="input-xlarge uneditable-input"><?php echo $from; ?></span> 
		  		<input type="hidden" value="<?php echo $from; ?>" name='from' /> <br />
			  	
			  	To: <span class="input-xlarge uneditable-input"><?php echo $to; ?></span> 
			  	<input type="hidden" value="<?php echo $to; ?>" name='to' /> <br />

			  	To: <span class="input-xlarge uneditable-input"><?php echo $subject; ?></span> 
			  	<textarea readonly name="message" style="margin-left: 0px; margin-right: 0px; width: 500px;"> <?php echo $message; ?> </textarea> <br />
			
	  </div>
	</div>

<script>
  	$(function() {
    	$('#content').htmlarea();
  	});
</script>