
<div id='exam'>
	 <div class="clock">
        <canvas class="CoolClock:swissRail" id="_coolclock_auto_id_59" width="100" height="100" style="width: 100px; height: 100px;">
        </canvas>
    </div>
	<?php

		echo "Start Time:". $start_time."<br />";
		echo "End Time:".$end_time."<br />";

		
		foreach ($questions as $row) {

				echo '<div class="well">';
    
              	$attributes = array ('class' => 'form');
				 echo form_open('admin/updateUser', $attributes);		//attributes passed for bootstrap

				 echo $row->number.")  ". $row->question;
				 echo "<input type='text'name='email' value='".$row->email."' /></td>";
				 echo "<td><input type='text'name='password' value='' /></td>"; 
				 echo form_hidden('id',$row->id);

				 echo "<td>".form_submit('','Update', 'class=btn title=Update')."</td>";
				 echo form_close();
              			
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
