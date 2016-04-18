<?php
header("Content-Type:text/html; charset=utf-8");

$db = new SQLite3('RFID.db');

$results = $db->query('select * from login order by time desc');

$finalArray;

while ($row = $results->fetchArray()) {
    // var_dump($row);
    // print_r($row);

    $finalArray[] = $row;
}
	// print_r($finalArray);

echo '
	<html><head><title>Login</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>
	<h1>login</h1>
	<h3>人員進出紀錄</h3>
	<a href="add.php">add_User</a>  |  <a href="list.php">list</a>  |  <a href="log.php">log</a>  |  <a href="command.php">command</a>  |  <a href="index.php">dashboard</a><br><br>
<table cellpadding="5">
	<tr bgcolor="#facfa5">
		<th>item</th>
		<th>time</th>
		<th>UID</th>
		<th>status</th>
	</tr>';

	foreach ($finalArray as $rowData) {
			if ($rowData[status] == 'Denied') {
				echo '<tr bgcolor="#f3afdb">';
			}else {
				echo '<tr bgcolor="#e1e1e1">';
			}
			echo "
     				<td>$rowData[item]</td>
     				<td>$rowData[time]</td>
     				<td>$rowData[UID]</td>
     				<td>$rowData[status]</td>
     			</tr>";
	}

echo '</table><br><br><br>

</body</html>';

?>
