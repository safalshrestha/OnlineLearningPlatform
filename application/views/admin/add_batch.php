<div class="row-fluid">
	<div class="span6">
		<input type='number' placeholder='Qty' name='qty' id='qty'>
		<br />
		<button id='newUser' onclick="tmpUser()" class='btn'><i class="icon-plus-sign"></i> Add</button>
		</div>
	<div class="span6">
			<?php
			$attributes = array ('class' => 'form');
			echo form_open('admin/searchBatch', $attributes);		?>	
				<input type = "text" name="name" placeholder="Batch Name/ID to Search For" />
				<br />
				<input type = "submit" class= 'btn' value="Search" />
			</form>
		</div>
</div>


<div id='tmp_users'></div>


<div id='batch_list'>
	<table class='table table-striped'>
		<tr> <th>Id</th>  <th> Start Date </th> <th> End Date </th> <th> name </th><th> </th> <th> </th> </tr>
 
		<?php
			foreach ($batches as $row) {
				echo "<tr>";
				 $attributes = array ('class' => 'form');
				 echo form_open('admin/updateBatch', $attributes);		//attributes passed for bootstrap

				 echo "<td>".$row->id."</td>";
				 echo "<td><input type='text' name='start' class='datepicker' value='".$row->start_date."' /></td>";
				 echo "<td><input type='text' name='end' class='datepicker' value='".$row->end_date."' /></td>"; 
				 echo "<td><input type='text' name='name' value='".$row->name."' /></td>";
				 echo form_hidden('id',$row->id);
				 echo "<td>".form_submit('','Update!', 'class=btn title="Update Batch"')."</td>";
				 echo form_close();

				 echo form_open('admin/deleteBatch', $attributes);
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

	var qty;

	function tmpUser(){
		qty = parseInt($("#qty").val());
		for(var i = 0; i < qty; i++){
			console.log(i);
			
			var htmlContents = "<div id="+i+">"+"<input type='hidden' id='id_"+i+"' value='<?php echo date('Y-m-d'); ?>'></input>" +
								"<input type='text' id='name_"+i+"' placeholder='Batch Name'></input>"+
								"<input type='text' id='start_"+i+"' placeholder='yyyy-mm-dd'></input>"+
								"<input type='text' id='end_"+i+"' placeholder='yyyy-mm-dd'></input>"+
								"<button onclick='addBatch("+i+")'>Add</button> </div>";			
			$("#tmp_users").append(htmlContents);
			$("#start_"+i).datepicker({ dateFormat: 'yy-mm-dd' });
			$("#end_"+i).datepicker({ dateFormat: 'yy-mm-dd' });
		}	
	}

	var id, name, start, end;
	function addBatch(htmlId){
		
		id = $("#id_"+htmlId).val();
		name = $("#name_"+htmlId).val();
		start = $("#start_"+htmlId).val();
		end = $("#end_"+htmlId).val();

		$.ajax({
		  type: "POST",
		  url: "/index.php/admin/addBatch",
		  data: { id: id, start_date: start, end_date: end, name: name },
		  success: function(data){
		  	$("#"+htmlId).hide();
		  	console.log("success");
		  },
		  error: function(e){
		  	alert("error");
		  }
		});
	}
	$(function() {
    	$( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
  	});

</script>