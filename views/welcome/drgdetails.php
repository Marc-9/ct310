<h1>DRG Details</h1>
<?php
	echo "<h2>DRG: " . $_GET['drg'] . "</h2>";
	echo "<table>";
	echo "<tr><th>Hospital MPN</th><th>Hospital Name</th><th>Hospital State</th>";
	
	foreach($drgDetails as $d) {
		$hospital = $d['provider_name'];
		$mpn = $d['provider_id'];
		$state = $d['provider_state'];
		
		echo
		"<tr>" .
			"<td>" . $mpn . "</td>" .
			"<td>" . $hospital . "</td>" .
			"<td>" . $state . "</td>" .
		"</tr>";
	}
?>