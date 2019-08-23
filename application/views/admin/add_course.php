<div class="row-fluid">
	<div class="span6">
		<input type='number' placeholder='Qty' name='qty' id='qty'> <br />
		<select id='faculty'>
			<!-- list of faculty -->
			<?php
				foreach($faculty as $f){
					echo "<option value=".$f->id.">".$f->name."</option>";
				}
			?>
		</select>
		<br />
		<button id='newUser' onclick="tmpUser()" class='btn'><i class="icon-plus-sign"></i> Add</button> 
	</div>
	<div class="span6">
			<?php
			$attributes = array ('class' => 'form');
			echo form_open('admin/searchCourse', $attributes);		?>	
				<input type = "text" name="id" placeholder="Course ID to Search For" />
				<br />
				<input type = "submit" class= 'btn' value="Search" />
			</form>
		</div>
</div>

<br />


<div id='tmp_users'></div>

<div id='notice_list'>
	<table class='table table-striped'>
		<tr> <th>Course ID</th>  <th> Faculty </th> <th> Course Name </th> <th> </th><th> </th> </tr>
 
		<?php
			foreach ($courses as $row) {
				echo "<tr>";
				 $attributes = array ('class' => 'form');
				 echo form_open('admin/updateCourse', $attributes);		//attributes passed for bootstrap
				 echo "<td><input type='text' name='id' value='".$row->id."' /> </td>";

				 echo "<td><select name='faculty_id'>";
				 foreach($faculty as $f){
					echo "<option value='".$f->id."'";
					if ($f->id == $row->faculty_id) echo "selected='yes'";
					echo ">".$f->name."</option>";
				 }
				 echo "</select></td>";

				 echo "<td><input type='textarea' name='name' value='".$row->name."' /></td>"; 
				 echo "<td>".form_submit('','Update', 'class=btn title="Update Course"')."</td>";
				 echo form_close();

				 echo form_open('admin/deleteCourse', $attributes);
			     echo form_hidden('id',$row->id);
				 echo "<td>".form_submit('','Delete !!', 'class=btn title="Delete this Course"')."</td>";
				 echo "</tr>";
				 echo form_close();
			}
		?>

		
	</table>


</div>

<script>
	"use strict";

	var qty, id, name, faculty;

	function tmpUser(){
		qty = parseInt($("#qty").val());
		id = $("#faculty").val();

		for(var i = 0; i < qty; i++){
			console.log(i);
			var htmlContents = "<div id="+i+">"+id+":"+"<input id='name_"+i+"' placeholder='Course Name'></input><input id='id_"+i+"' placeholder='Course ID'></input> <button onclick='addCourse("+i+")'>Add</button> </div>";
			$("#tmp_users").append(htmlContents);
		}
	}
	function addCourse(htmlId){
		faculty = $("#faculty").val();
		id = $("#id_"+htmlId).val();
		name = $("#name_"+htmlId).val();

		$.ajax({
		  type: "POST",
		  url: "/index.php/admin/addCourse",
		  data: { id: id, faculty_id: faculty, name: name },
		  success: function(data){
		  	$("#"+htmlId).hide();
		  	console.log("success");
		  	window.location.replace("/admin/course");
		  },
		  error: function(e){
		  	alert("error");
		  }
		});
	}


</script>