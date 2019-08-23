
<div id='notice_list'>
	<?php
		
		foreach ($weeks as $row) {

				echo '<div class="bubble" style="border-color: black; background: rgb(0, 12, 25);">';
    
              	echo "<h3><em>Week:".$row->week_id."</em></h3>"; 
              	echo "<p>".$row->description."<p><br />";
              				
				echo '</div>';
				if ($priv==5 || $priv==2) {
					echo "<button id='edit' onclick='tmpEdit(".$row->id.")' class='btn'><i class='icon-plus-sign'></i> Add</button>";
					echo "<div id='tmp_users_".$row->id."'></div>";
				}
              			
		}
	?>


</div>

<script>
	"use strict";


	function tmpEdit(id){
		
			
			var htmlContents = "<div id='txta'><textarea id='content' style='margin-left: 0px; margin-right: 0px; width: 300px; height: 200px;' >  </textarea>"+
								"<br /><button onclick='edit("+id+")'>Add</button> </div>";			
			$("#tmp_users_"+id).append(htmlContents);
			$('#content').htmlarea();

			
	}

	var content;
	function edit(id){
		
		content = $("#content").val();
		console.log(content);
		console.log(id);
		$.ajax({
		  type: "POST",
		  url: "/index.php/admin/updateWeekData",
		  data: { description: content, id:id },
		  success: function(data){
		  	$("#txta").hide();
		  	//window.location.replace("/admin/welcome/");
		  	alert("Done! Changes will be seen when you refresh");
		  	console.log("success");
		  },
		  error: function(e){
		  	alert("error");
		  }
		});
	}


</script>
