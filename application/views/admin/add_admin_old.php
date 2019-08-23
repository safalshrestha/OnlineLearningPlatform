

<input type='number' placeholder='Qty' name='qty' id='qty'> </input>
<select id='privilege'>
	<!-- list of faculty -->
	<option value='2'>Faculty Head</option>
	<option value='3'>Year Head</option>"
	<option value='4'>Course Admin</option>"

			}
		}
	?>
</select>

<br />
<button id='newUser' onclick="tmpUser()" class='btn'><i class="icon-plus-sign"></i> Add</button>


<div id='tmp_users'></div>

<script>
	"use strict";

	var qty,priv;

	function tmpUser(){
		qty = parseInt($("#qty").val());
		priv = $("#privilege").val();

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
		priv = $("#priv_"+htmlId).val();

		$.ajax({
		  type: "POST",
		  url: "/index.php/main/addStudents",
		  data: { email: email, privilege: priv, course_id: course_id, batch_id:batch_id },
		  success: function(data){
		  	$("#"+htmlId).hide();
		  	console.log("success");
		  },
		  error: function(e){
		  	alert("error");
		  }
		});
	}


</script>