
<div class="row-fluid">
	<div class="span6">
	  	<!--profile pic-->
	  	<div class="input-prepend">
			<span class="add-on"><i class="icon-pencil"></i></span>
			<input type='number' id="qty" class="appendedInputButtons" placeholder='Qty' name='qty' id='qty'> <br />
		</div>
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

		<select id='batch'>
			<!-- get batch id's -->
			<?php
			foreach($batch as $b){
				echo "<option value='".$b->id."'>Id: ".$b->id." Starts: ".$b->start_date."</option>"; 
			}
			?>
		</select> <br />

		<br />
		<button id='newUser'  onclick="tmpUser()" class='btn btn-primary'><i class="icon-plus-sign"></i> Add</button>
	</div>
	<div class="span6">
		<?php
		$attributes = array ('class' => 'form');
		echo form_open('admin/searchUser', $attributes);		?>	
			<input type = "hidden" name = "priv" value = "8" />
			<div class="input-prepend">
			<span class="add-on"><i class="icon-search"></i></span>
			<input type = "text" id="inputIcon" name="email" placeholder="Email/Reg.No to Search" />
			</div>
			<br />
			<input type = "submit" class= 'btn btn-primary' value="Search" />
		</form>
	</div>
</div>
<hr />
<div id='tmp_users'></div>

<hr />
<div id='user_list'>
	<table class='table table-striped'>
		<tr> <th>Id</th>  <th> Email </th> <th> Password </th> <th> </th><th> </th>  <th> </th> </tr>

		<?php
			foreach ($users as $row) {
				echo "<tr>";
				 $attributes = array ('class' => 'form');
				 echo form_open('admin/updateUser', $attributes);		//attributes passed for bootstrap

				 echo "<td>".$row->reg_no."</td>";
				 echo "<td><input type='text'name='email' value='".$row->email."' /></td>";
				 echo "<td><input type='text'name='password' value='' /></td>"; 
				 echo form_hidden('id',$row->id);

				 echo "<td>".form_submit('','Update', 'class=btn title=Update')."</td>";
				 echo form_close();

				 echo form_open('admin/deleteStudents', $attributes);
			     echo form_hidden('id',$row->id);
				 echo "<td>".form_submit('','Delete!', 'class=btn title="Delete Student"')."</td>";
				 echo form_close();

				 echo form_open('admin/userProfile2', $attributes);
			     echo form_hidden('id',$row->id);
			     echo form_hidden('priv', 8);
				 echo "<td>".form_submit('','Profile >>', 'class=btn title="Edit Profile"')."</td>";
				 echo "</tr>";
				 echo form_close();
			}
		?>

		
	</table>








</div>



<script>
	"use strict";

	var qty,course_id,batch_id;

	function tmpUser(){
		qty = parseInt($("#qty").val());
		course_id = $("#course").val();
		batch_id = $("#batch").val();

		for(var i = 0; i < qty; i++){
			console.log(i);
			var htmlContents = "<div id="+i+"><input id='email_"+i+"' placeholder='Email'></input> <button onclick='addUser("+i+")'>Add</button> </div>";
			$("#tmp_users").append(htmlContents);
		}
	}
	var email,priv;
	function addUser(htmlId){
		course_id = $("#course").val();
		batch_id = $("#batch").val();

		email = $("#email_"+htmlId).val();
		priv = 8;

		$.ajax({
		  type: "POST",
		  url: "/index.php/admin/addStudents",
		  data: { email: email, privilege: priv, course_id: course_id, batch_id:batch_id },
		  success: function(data){
		  	$("#"+htmlId).hide();
		  	console.log("success");
		  	window.location.replace("/admin/Students");

		  },
		  error: function(e){
		  	alert("error");
		  }
		});
	}


</script>