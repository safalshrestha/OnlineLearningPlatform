<div class="row-fluid">
	<div class="span6">

		<input type='number' placeholder='Qty' name='qty' id='qty'> <br />
		<select id='course'>
			<!-- list of faculty -->
			<?php
				foreach($faculty as $f){
					
					foreach($courses as $course){
						if($f->id == $course->faculty_id) echo "<option value='".$course->id."'>".$f->name."-".$course->name."</option>";
					}
				}
			?>
		</select> <br />

		<select id='available'>
			"<option value='1'>Yes</option>"; 
			"<option value='0'>No</option>"; 
		</select>

		<br />
		<button id='newUser' onclick="tmpUser()" class='btn'><i class="icon-plus-sign"></i> Add</button>
		</div>
	<div class="span6">
			<?php
			$attributes = array ('class' => 'form');
			echo form_open('admin/searchSubject', $attributes);		?>	
				<input type = "text" name="name" placeholder="Subject Name to Search For" />
				<br />
				<input type = "submit" class= 'btn' value="Search" />
			</form>
		</div>
</div>


<div id='tmp_users'><br /></div>

<div id='subject_list'>
	<hr />
	<table class='table table-striped'>
		<tr> <th>Id</th>  <th> Course ID </th> <th> Name </th> <th> Status </th><th> </th> <th> </th> </tr>
 
		<?php
			foreach ($subjects as $row) {
				echo "<tr>";
				 $attributes = array ('class' => 'form');
				 echo form_open('admin/updateSubject', $attributes);		//attributes passed for bootstrap

				 echo "<td>".$row->id."</td>";

				 echo "<td><select name='cid'>";
				 foreach($courses as $c){
					echo "<option value='".$c->id."'";
					if ($c->id == $row->course_id) echo "selected='yes'";
					echo ">".$c->name."</option>";
				 }
				 echo "</select></td>";

				 //echo "<td><input type='text' name='cid' value='".$row->course_id."' /></td>";
				 echo "<td><input type='text' name='name' value='".$row->name."' /></td>"; 

				 echo "<td><select name='state'>";
				 echo "<option value='1' ";
					if ($row->status == 1) echo "selected='yes'";
				echo ">Yes</option>";
				 echo "<option value='0' ";
					if ($row->status == 0) echo "selected='yes'";
				 echo ">No</option>";

				 echo "</select></td>";
				 
				 //echo "<td><input type='text' name='state' value='".$row->status."' /></td>";

				 echo form_hidden('id',$row->id);
				 echo "<td>".form_submit('','Update!', 'class=btn title="Update Batch"')."</td>";
				 echo form_close();

				 echo form_open('admin/deleteSubject', $attributes);
			     echo form_hidden('id',$row->id);
				 echo "<td>".form_submit('','Delete!', 'class=btn title="Delete Batch"')."</td>";
				 echo "</tr>";
				 echo form_close();
			}
		?>

		
	</table>
</div>


<script>
	"use strict";

	var qty,course_id,available;

	function tmpUser(){
		qty = parseInt($("#qty").val());
		course_id = $("#course").val();
		available = $("#available").val();

		for(var i = 0; i < qty; i++){
			console.log(i);
			var htmlContents = "<div id="+i+"><input id='name_"+i+"' placeholder='Subject Name'></input> <button onclick='addSubject("+i+")'>Add</button> </div>";
			$("#tmp_users").append(htmlContents);
		}
	}
	var name;
	function addSubject(htmlId){
		course_id = $("#course").val();
		available = $("#available").val();

		name = $("#name_"+htmlId).val();

		$.ajax({
		  type: "POST",
		  url: "/index.php/admin/addSubject",
		  data: { name: name, course_id: course_id, available:available },
		  success: function(data){
		  	$("#"+htmlId).hide();
		  	console.log("success");
		  	window.location.replace("/admin/subject");

		  },
		  error: function(e){
		  	alert("error");
		  }
		});
	}


</script>