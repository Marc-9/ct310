<br>
<button onclick="history.go(-1);">Go Back</button>
<h1>DRG Details</h1>
<h3><?php echo $drgDetails[0]['drg_id'].'-'.$drgDetails[0]['drg_definition'] ?></h3>
<table id="table_id" class="display">
  <thead>
    <tr>
    	<th>Hospital MPN</th>
   		<th>Hospital Name</th>
    	<th>State</th> 
    	<th>Average Covered Charges</th>
   		<th>Average Total Payments</th>
    	<th>Average Medicare Payments</th> 
  	</tr>
  </thead>
  <tbody>
  <?php
		foreach($drgDetails as $d){
			$hospital = $d['name'];
			$mpn = $d['id'];
			$mpn= sprintf("%06d", $mpn);
			$state = $d['state'];
			$price1 = $d['average_covered_charges'];
			setlocale(LC_MONETARY, 'en_US');
			$price1 = money_format('%.2n',$price1);
			$price2 = $d['average_total_payments'];
			$price2 = money_format('%.2n',$price2);
			$price3 = $d['average_medicare_payments'];
			$price3 = money_format('%.2n',$price3);
  		echo
		"<tr>
			<td>$mpn</td>
			<td><a href=\"hospitaldetails?id=$mpn\">$hospital</a></td>
			<td>$state</td>
			<td>$price1</td>
			<td>$price2</td>
			<td>$price3</td>
		</tr>";
  	}
  	?>
  </tbody>

</table>


<script>
$(document).ready( function () {
    $('#table_id').DataTable({
    "iDisplayLength": 20
    })
} );
</script>

