<div class="row-fluid">
	<div class="span6">
	</div>
	<div class="span6">
			<?php
			$attributes = array ('class' => 'form');
			echo form_open('admin/searchHelp', $attributes);		?>	
				<input type = "text" name="title" placeholder="Title/Email to Search For" />
				<br />
				<input type = "submit" class= 'btn' value="Search" />
			</form>
		</div>
</div>


<div id='tmp_users'></div>

<div id='help_list'>
	<table class='table table-striped'>
		<tr> <th>Id</th>  <th> Time Stamp </th> <th> From </th> <th> Title </th> <th> </th><th> </th> </tr>
 
		<?php
			foreach ($help as $row) {
				echo "<tr>";
				 $attributes = array ('class' => 'form');
				 echo form_open('admin/deleteHelp', $attributes);		//attributes passed for bootstrap

				 echo "<td>".$row->id."</td>";
				 echo "<td>".$row->timestamp."</td>";
				 echo "<td>".$row->email."</td>";
				 echo "<td>".$row->title."</td>"; 
				 echo form_hidden('id',$row->id);
				 echo "<td>".form_submit('','Delete!', 'class=btn title="Delete Message"')."</td>";
				 echo form_close();

				 echo form_open('admin/viewHelp', $attributes);
			     echo form_hidden('id',$row->id);
				 echo "<td>".form_submit('','View >>', 'class=btn title="View Message"')."</td>";
				 echo "</tr>";
				 echo form_close();
			}
		?>

		
	</table>


</div>