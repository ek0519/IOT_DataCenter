<?php
header("Content-Type:text/html; charset=utf-8");

$db = new SQLite3('RFID.db');

$results = $db->query('select * from log order by time desc');

$finalArray;

while ($row = $results->fetchArray()) {
    // var_dump($row);
    // print_r($row);

    $finalArray[] = $row;
}
	// print_r($finalArray);

echo '
	<html><head><title>Log</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>
	<h1>log</h1>
	<h3>感測器紀錄</h3>
	<a href="add.php">add_User</a>  |  <a href="list.php">list</a>  |  <a href="login.php">login</a>  |  <a href="command.php">command</a>  |  <a href="index.php">dashboard</a><br><br>
<table cellpadding="5">
	<tr bgcolor="#facfa5">
		<th>time</th>
		<th>ID</th>
		<th>Door</th>
		<th>Lock</th>
		<th>T</th>
		<th>H</th>
		<th>Dow</th>
	</tr>';
	
	foreach ($finalArray as $rowData) {
			
			echo "
				<tr bgcolor='#e1e1e1'>
     				<td>$rowData[time]</td>
     				<td>$rowData[ID]</td>
     				<td>$rowData[Door]</td>
     				<td>$rowData[Lock]</td>
     				<td>$rowData[T]</td>
     				<td>$rowData[H]</td>
     				<td>$rowData[Dow]</td>
     			</tr>";
	}

echo '</table><br><br><br>

</body</html>';

?>
