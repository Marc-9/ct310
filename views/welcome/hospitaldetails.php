<br>
<button onclick="history.go(-1);">Go Back</button>
<h1><?php echo $hospitalDetails[0]['provider_name'] ?></h1>
<h3>Address:</h3>
<p><?php echo $hospitalDetails[0]['provider_street'].' '.$hospitalDetails[0]['provider_state'].' '.$hospitalDetails[0]['provider_zipCode'].' '.$hospitalDetails[0]['provider_city'] ?></p>
<h3>Total Discharge #:</h3>
<p><?php echo $hospitalDetails[0]['total_discharge'] ?></p>
<h3>Hospital Referral Region:</h3>
<p><?php echo $hospitalDetails[0]['hospital_referral_region'] ?></p>
<h3>Provider ID:</h3>
<p><?php
$num_padded = sprintf("%06d", $hospitalDetails[0]['provider_id']);
 echo $num_padded ?></p>

<h3>DRG Info:</h3>

<table id="table_id" class="display">
  <thead>
    <tr>
    	<th>DRG Number</th>
   		<th>Average Covered Charges</th>
   		<th>Average Total Payments</th>
    	<th>Average Medicare Payments</th> 
    	<th>Description</th>
  	</tr>
  </thead>
  <tbody>
  <?php
		foreach($hospitalDetails as $drginfo){
			$id = $drginfo['drg_Number'];
			$price1 = $drginfo['average_covered_charges'];
			setlocale(LC_MONETARY, 'en_US');
			$price1 = money_format('%.2n',$price1);
			$price2 = $drginfo['average_total_payments'];
			$price2 = money_format('%.2n',$price2);
			$price3 = $drginfo['average_medicare_payments'];
			$price3 = money_format('%.2n',$price3);
			$desc = $drginfo['drg_definition'];
  		echo
		"<tr>
			<td><a href=\"drgdetails?drg=$id\">$id</a></td>
			<td> $price1</td>.
			<td>$price2</td>
			<td>$price3</td>
			<td>$desc</td>

		</tr>";
  	}
  	?>

  </tbody>

</table>

<script>
$(document).ready( function () {
    $('#table_id').DataTable();
} );
</script>