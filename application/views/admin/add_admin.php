<div class="row-fluid">
	<div class="span6">
		<input type='number' placeholder='Qty' name='qty' id='qty'>

		<br />
		<button id='newUser' onclick="tmpUser()" class='btn'><i class="icon-plus-sign"></i> Add</button>
	</div>
	<div class="span6">
			<?php
			$attributes = array ('class' => 'form');
			echo form_open('admin/searchUser', $attributes);		?>	
				<input type = "hidden" name = "priv" value = "2" />
				<input type = "text" name="email" placeholder="Email/Reg.number to Search" />
				<br />
				<input type = "submit" class= 'btn' value="Search" />
			</form>
		</div>
</div>

<div id='tmp_users'></div>

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

				 echo form_open('admin/deleteHead', $attributes);
			     echo form_hidden('id',$row->id);
				 echo "<td>".form_submit('','Delete!', 'class=btn title="Delete Student"')."</td>";
				 echo form_close();

				 echo form_open('admin/userProfile2', $attributes);
			     echo form_hidden('id',$row->id);
			     echo form_hidden('priv', 2);
				 echo "<td>".form_submit('','Profile >>', 'class=btn title="Edit Profile"')."</td>";
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
		//get courses from db
			$.ajax({
			  type: "GET",
			  url: "/index.php/admin/getAllCourses",
			  dataType: "json",
			  success: function(json){
			  	console.log(json);
			  	var coursesList = "";
				$.each(json, function(i, v) {
				   console.log(json[i].name);
				   coursesList += "<input id='"+json[i].id+"' name='"+json[i].name+"'  type='checkbox'>"+json[i].name+"</input> <br />";
				   console.log(coursesList);
				});



			  	
			  	for(var i = 0; i < qty; i++){
					console.log(i);

					var htmlContents = 
						"<div id=div_"+i+">"+
							"<input id='email_"+i+"' placeholder='Email'></input> "+
							"<button onclick='addAdmin("+i+")'>Add</button>"+ 
							"<div style='max-width:800px;' id='list"+i+"'>"+coursesList+"</div>";
						"</div>"; 
					$("#tmp_users").append(htmlContents);
					console.log(htmlContents);
				}


			  	
			  },
			  error: function(e){
			  	alert("error");
			  }
			});
		
		
	}
	var email,priv;
	function addAdmin(htmlId){
		//course_id = $("#course").val();

		var courses = new Array();

		$('#div_'+htmlId).find(':checkbox').each(function(){

           if($(this).attr('checked')) courses.push($(this).attr('id'));

   		});

		console.log(courses);
		
		email = $("#email_"+htmlId).val();
		



		$.ajax({
		  type: "POST",
		  url: "/index.php/admin/addHeads",
		  data: { email: email, course: courses },
		  success: function(data){
		  	$("#div_"+htmlId).hide();
		  	console.log("success");
		  },
		  error: function(e){
		  	alert(e);
		  }
		});
	}


</script>