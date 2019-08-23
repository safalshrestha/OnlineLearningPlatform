<div class="row-fluid">
	<div class="span6">
	<br />
	<button id='newUser' onclick="tmpUser()" class='btn'><i class="icon-plus-sign"></i> Add</button>
	<br />
	</div>
	<div class="span6">
			<?php
			$attributes = array ('class' => 'form');
			echo form_open('admin/searchNotice', $attributes);		?>	
				<input type = "text" name="title" placeholder="Title to Search For" />
				<br />
				<input type = "submit" class= 'btn' value="Search" />
			</form>
		</div>
</div>


<div id='tmp_users'></div>

<div id='notice_list'>
	<table class='table table-striped'>
		<tr> <th>Id</th>  <th> Time Stamp </th> <th> Title </th> <th> </th><th> </th> </tr>
 
		<?php
			foreach ($notices as $row) {
				echo "<tr>";
				 $attributes = array ('class' => 'form');
				 echo form_open('admin/deleteNotice', $attributes);		//attributes passed for bootstrap

				 echo "<td>".$row->id."</td>";
				 echo "<td>".$row->timeStamp."</td>";
				 echo "<td>".$row->title."</td>"; 
				 echo form_hidden('id',$row->id);
				 echo "<td>".form_submit('','Delete!', 'class=btn title="Delete Notice"')."</td>";
				 echo form_close();

				 echo form_open('admin/viewNotice', $attributes);
			     echo form_hidden('id',$row->id);
				 echo "<td>".form_submit('','Edit >>', 'class=btn title="Edit Notice"')."</td>";
				 echo "</tr>";
				 echo form_close();
			}
		?>

		
	</table>


</div>

<script>
	"use strict";


	function tmpUser(){
		
			
			var htmlContents = "<div id='txta'><input type='text' id='title' placeholder='Title' / ><textarea id='content' style='margin-left: 0px; margin-right: 0px; width: 300px;''> Enter Text Here </textarea>"+
								"<br /><button onclick='addNotice()'>Add</button> </div>";			
			$("#tmp_users").append(htmlContents);
			$('#content').htmlarea();

			
	}

	var content, title;
	function addNotice(){
		
		title = $("#title").val();
		content = $("#content").val();
		console.log(content);

		$.ajax({
		  type: "POST",
		  url: "/index.php/admin/addNotice",
		  data: { title:title, content: content },
		  success: function(data){
		  	$("#txta").hide();
		  	window.location.replace("/admin/notice");
		  	//alert("Done!");
		  	console.log("success");
		  },
		  error: function(e){
		  	alert("error");
		  }
		});
	}


</script>
