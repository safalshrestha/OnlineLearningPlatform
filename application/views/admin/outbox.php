
<div class="row-fluid">
	<div class="span6">
	<br />
	<button id='newUser' onclick="location.href='/admin/sendMessage'" class='btn'><i class="icon-plus-sign"></i> Add</button>
	<br />
	</div>
	<div class="span6">
			<?php
			$attributes = array ('class' => 'form');
			echo form_open('admin/searchMessageSent', $attributes);		?>	
				<input type = "text" name="title" placeholder="Subject/Email to Search For" />
				<br />
				<input type = "submit" class= 'btn' value="Search" />
			</form>
		</div>
</div>


<div id='tmp_users'></div>

<div id='notice_list'>
	<table class='table table-striped'>
		<tr> <th>Id</th>  <th> Time Stamp </th> <th> To </th> <th> Subject </th> <th> </th><th> </th> </tr>
 
		<?php
			foreach ($messages as $row) {
				echo "<tr>";
				 $attributes = array ('class' => 'form');
				 echo form_open('admin/deleteMessage', $attributes);		//attributes passed for bootstrap

				 echo "<td>".$row->id."</td>";
				 echo "<td>".$row->timeStamp."</td>";
				 echo "<td>".$row->to."</td>";
				 echo "<td>".$row->subject."</td>";
				 echo form_hidden('id',$row->id);
				 echo "<td>".form_submit('','Delete!', 'class=btn title="Delete Message"')."</td>";
				 echo form_close();

				 echo form_open('admin/viewMessage', $attributes);
			     echo form_hidden('id',$row->id);
				 echo "<td>".form_submit('','View >>', 'class=btn title="View Message"')."</td>";
				 echo "</tr>";
				 echo form_close();
			}
		?>

		
	</table>


</div>
