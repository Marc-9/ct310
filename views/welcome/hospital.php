<table>
  <tr>
    <th>Hospital Name</th>
  </tr>
  <?php
		foreach($hospital as $h){
			$name = $h['name'];
  		echo "
  		<tr>
  			<td>$name</td>
  		</tr>
  		";
  	}
  	?>

</table>
