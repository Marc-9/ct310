
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
			$name = $h['provider_name'];
			$id = $h['provider_id'];
			$num_padded = sprintf("%06d", $id);
			$state = $h['provider_state'];
  		echo "
  		<tr>
  			<td>$num_padded</td>
  			<td>$name</td>
  			<td>$state</td>
  		</tr>
  		";
  	}
  	?>
  </tbody>

</table>

<script>
$(document).ready( function () {
    $('#table_id').DataTable();
} );
</script>
