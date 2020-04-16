<h1>DRG</h1>
<table id="table_id" class="display">
  <thead>
    <tr>
    	<th>DRG Number</th>
   		<th>DRG Description</th>
  	</tr>
  </thead>
  <tbody>
    <?php
		foreach($drg as $d){
			$num = $d['drg_Number'];
			$def = $d['drg_definition'];
  		echo "
  		<tr>
  			<td><a href=\"https://cs.colostate.edu:4444/~ch85/ct310/index/welcome/drgdetails?drg=$num\">$num</a></td>
  			<td>$def</td>
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
