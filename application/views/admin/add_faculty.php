<div class="row-fluid">
	<div class="span6">

		<input type='number' placeholder='Qty' name='qty' id='qty'>
		<br />
		<button id='newUser' onclick="tmpUser()" class='btn'><i class="icon-plus-sign"></i> Add</button>
		</div>
	<div class="span6">
			<?php
			$attributes = array ('class' => 'form');
			echo form_open('admin/searchFaculty', $attributes);		?>	
				<input type = "text" name="name" placeholder="Name of faculty to Search" />
				<br />
				<input type = "submit" class= 'btn' value="Search" />
			</form>
		</div>
</div>


<div id='tmp_users'></div>

<div id='notice_list'>
	<table class='table table-striped'>
		<tr> <th>Id</th>  <th> Name </th> <th> </th><th> </th> </tr>
 
		<?php
			foreach ($faculty as $row) {
				echo "<tr>";
				 $attributes = array ('class' => 'form');
				 echo form_open('admin/updateFaculty', $attributes);		//attributes passed for bootstrap

				 echo "<td>".$row->id."</td>";
				 echo "<td><input type='text' name='name' value='".$row->name."' /></td>";
				 echo form_hidden('id',$row->id);
				 echo "<td>".form_submit('','Update!', 'class=btn title="Update Faculty"')."</td>";
				 echo form_close();

				 echo form_open('admin/deleteFaculty', $attributes);
			     echo form_hidden('id',$row->id);
				 echo "<td>".form_submit('','Delete !!', 'class=btn title="Delete Faculty"')."</td>";
				 echo "</tr>";
				 echo form_close();
			}
		?>

		
	</table>


</div>

<script>
	"use strict";

	var qty;

	function tmpUser(){
		qty = parseInt($("#qty").val());

		for(var i = 0; i < qty; i++){
			console.log(i);
			var htmlContents = "<div id="+i+"><input id='faculty_"+i+"' placeholder='Name'></input> <button onclick='addFaculty("+i+")'>Add</button> </div>";
			$("#tmp_users").append(htmlContents);
		}
	}
	function addFaculty(htmlId){
		var faculty;
		faculty = $("#faculty_"+htmlId).val();

		$.ajax({
		  type: "POST",
		  url: "/index.php/admin/addFaculty",
		  data: { name:faculty },
		  success: function(data){
		  	$("#"+htmlId).hide();
		  	console.log("success");
		  	window.location.replace("/admin/faculty");

		  },
		  error: function(e){
		  	alert("error");
		  }
		});
	}


</script>