<?php
header("Content-Type:text/html; charset=utf-8");

$db = new SQLite3('RFID.db');

$results = $db->query('SELECT * FROM list');

$finalArray;

while ($row = $results->fetchArray()) {
    // var_dump($row);
    // print_r($row);

    $finalArray[] = $row;
}
	// print_r($finalArray);

echo '
	<html><head><title>List</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>
	<h1>list</h1>
	<h3>使用者權限</h3>
	<a href="add.php">add_User</a>  |  <a href="log.php">log</a>  |  <a href="login.php">login</a>  |  <a href="command.php">command</a>  |  <a href="index.php">dashboard</a><br><br>
<table cellpadding="5">
	<tr bgcolor="#facfa5">
		<th>UID</th>
		<th>NAME</th>
		<th>RACK01</th>
		<th>RACK02</th>
	</tr>';
	
	foreach ($finalArray as $rowData) {
			
			echo "
				<tr bgcolor='#e1e1e1'>
     				<td>$rowData[UID]</td>
     				<td>$rowData[NAME]</td>
     				<td>$rowData[RACK01]</td>
     				<td>$rowData[RACK02]</td>
     			</tr>";
	}

echo '</table><br><br><br>

</body</html>';

?>
