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
			$num = $d['id'];
			$def = $d['drg_definition'];
  		echo "
  		<tr>
  			<td><a href=\"drgdetails?drg=$num\">$num</a></td>
  			<td>$def</td>
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
