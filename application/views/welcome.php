<div class="container-fluid">
  <div class="row-fluid">
    <div class="span3">
      <!--Sidebar content-->
    	<?php
			$this->load->view('subjects');
		?>
    </div>
    <div class="span7">
      <!--Body content-->
      <?php
      	if ($content == "Support") {
      		$this->load->view('help');
      	}
      	else if ($content == "Announcements") {
      		$this->load->view('announcements');
      	}
      	else {
      		$this->load->view('course_view',$content);
      	}
      ?>	
      		
    </div>
    <div class="span2">
      <?php $this->load->view('sidebar'); ?>
  </div>
</div>

