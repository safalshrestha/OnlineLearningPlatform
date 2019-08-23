<div class="well" style="max-width: 340px; padding: 8px 0;">
              <ul class="nav nav-list">
                <li class="nav-header">My Profile:</li>
                <li><?php 
		  			foreach($users as $user){
			  			if ($user->profilePic == 0) {
			  				if ($priv==5) { 
			  					echo '<img src="/uploads/profile/default_lecturer.png"  class="img-polaroid" />';
			  				 } 
			  				if ($priv==8) { 
			  					echo '<img src="/uploads/profile/default_student.jpg"  class="img-polaroid" />';
			  				 } 
			  				if ($priv==1 || $priv==2) { 
			  					echo '<img src="/uploads/profile/default_admin.jpg"  class="img-polaroid" />';
			  				 }
			  			} 
			  			else if ($user->profilePic == 1) { ?>
							<img src="/uploads/<?php echo $user->user_id; ?>/profile/profile.jpg"  class="img-polaroid" />
						<?php }
					}
					?>		
	  			</li>
	  			<li><strong><?php 	if ($priv==5) echo "Lecturer";
                			if ($priv==8) echo "Student";
                			if ($priv==1 || $priv==2) echo "Adminstrator";
                	?>
                </strong></li>
                <li><?php echo "<strong>Name:</strong><em> ".$user->first_name." ".$user->family_name ?></em></li>
                <li> <strong> Exam Id: </strong> <em> <?php echo $this->session->userdata['user_id']; ?></em> </li>

                
                <li><a href="/admin/userProfile/<?php echo $this->session->userdata['user_id'].'/'.$priv; ?>/">Edit Profile</a></li>
                <li class="divider"></li>
                <li class="nav-header">My Courses</li>
                <?php 
		  			foreach($subjects as $subject){
		  				foreach($subject_name as $name) {
		  				if ($subject->subject_id == $name->id) echo "<li><a href='/admin/welcome2/".$name->id."'><i class='icon-book'></i>".$name->name."</a></li>";
		  				}
		  			}
	  			?>
                <li class="nav-header">Messaging</li>
                <li class="divider"></li>
                <li><a href="/admin/welcome2/send_message"><i class="icon-file"></i>Compose</a></li>
                <li><a href="/admin/messageInbox"><i class="icon-inbox"></i>Inbox</a></li>
                <li><a href="/admin/messageSent"><i class="icon-check"></i>Sent</a></li>

                <li class="divider"></li>
                <li><a href="/admin/welcome2/help"><i class="icon-question-sign"></i>Help</a></li>
              </ul>
</div>