
	<div class="row-fluid">
	  <div class="span4">
	  	<!--profile pic-->


	  </div>
	  <div class="span8">

	  	<!-- profile user -->
	  		<h4> Edit Notice </h4>
		  	<?php echo form_open_multipart('/admin/editNotice'); ?>
		  		<input type="hidden" name="id" value="<?php echo $id; ?>" /> <br />
			  	<input placeholder="Title" type="text" value="<?php echo $title; ?>" name='title' /> <br />
			  	<textarea id="content" name="content" style="margin-left: 0px; margin-right: 0px; width: 500px;"> <?php echo $content; ?> </textarea> <br />
			  	<input type="submit" value="Change" name="Submit" />
			</form>
	  </div>
	</div>

<script>
  	$(function() {
    	$('#content').htmlarea();
  	});
</script>