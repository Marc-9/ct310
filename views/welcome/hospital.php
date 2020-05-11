<br>

<table id="table_id" class="display">
  <thead>
    <tr>
    	<th>Hospital MPN</th>
   		<th>Hospital Name</th>
    	<th>State</th> 
  	</tr>
  </thead>
  <tbody>
  <?php
		foreach($hospital as $h){
			$name = $h['name'];
			$id = $h['id'];
			$num_padded = sprintf("%06d", $id);
			$state = $h['state'];
  		echo "
  		<tr>
  			<td>$num_padded</td>
  			<td><a href=\"hospitaldetails?id=$num_padded\">$name</a></td>
  			<td>$state</td>
  		</tr>
  		";
  	}
  	?>
  </tbody>

</table>


<script>
$(document).ready( function () {
    $('#table_id').DataTable({
    "iDisplayLength": 20
    });
} );
</script>
