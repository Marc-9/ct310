<h1>DRG</h1>
<?php
    echo "<table>";
    foreach ($drg as $d) {
        $num = $d['drg_Number'];
        $def = $d['drg_definition'];
        
        echo "<tr><td>" . $num . "</td><td>" . $def . "</td></tr>";
    }
?> 