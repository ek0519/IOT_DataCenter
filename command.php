<?php
header("Content-Type:text/html; charset=utf-8");

$db = new SQLite3('RFID.db');

$results = $db->query('select * from command order by time desc');

$finalArray;

while ($row = $results->fetchArray()) {
    // var_dump($row);
    // print_r($row);

    $finalArray[] = $row;
}
	// print_r($finalArray);

echo '
	<html><head><title>Command</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>
	<h1>command</h1>
	<h3>操作紀錄</h3>
	<a href="add.php">add_User</a>  |  <a href="list.php">list</a>  |  <a href="log.php">log</a>  |  <a href="login.php">login</a>  |  <a href="index.php">dashboard</a><br><br>
<table cellpadding="5">
	<tr bgcolor="#facfa5">
		<th>time</th>
		<th>UID</th>
		<th>ID</th>
		<th>Lock</th>
	</tr>';

	foreach ($finalArray as $rowData) {
			echo "
				<tr bgcolor='#e1e1e1'>
     				<td>$rowData[time]</td>
     				<td>$rowData[UID]</td>
     				<td>$rowData[ID]</td>
     				<td>$rowData[Lock]</td>
     			</tr>";
	}

echo '</table><br><br><br>

</body</html>';

?>
