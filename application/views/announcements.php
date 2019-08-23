<?php
		$i = 0;
		foreach ($notices as $row) {
		 
			if ($i % 2 == 0) { 
				
              		
              			echo '<div class="bubble" style="border-color: white; background: rgb(0, 0, 0)">';
    
              					echo "<em>".$row->timeStamp."</em><br />"; 
              					echo "<h3>".$row->title."</h3>";
              					echo "<p>".$row->content."<p><br />";
              				
						echo '</div>';
              		
            	}
			else if($i%2 == 1) { 
				
              		  	echo '<div class="bubble" style="border-color: black; background: rgb(0, 12, 25);">';
              				
              					echo "<em>".$row->timeStamp."</em><br />"; 
              					echo "<h3>".$row->title."</h3>";
              					echo "<p>".$row->content."<p>";
              				
						echo '</div>';
              		
			}
			$i++;
		}
		