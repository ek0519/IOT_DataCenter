<?php
	header("Content-Type:text/html; charset=utf-8");
	date_default_timezone_set('Asia/Taipei');

	$rawString = $_GET['raw'];
	if ($rawString) {
		
		// $rawString = '1,0,0,167.58,2.20,56.67';
		$array = explode(",", $rawString);

		$db = new SQLite3('RFID.db');
		$queryString = "insert into log values (datetime('now','localtime'), '" . $array[0] . "', '" . $array[1] . "', '" . $array[2] . "', '" . $array[3] . "', '" . $array[4] . "', '" . $array[5] . "');";
		$results = $db->query($queryString);

		$dt = new DateTime("now");

		$fileName = "RACK0" . $array[0] . ".txt";
		$myfile = fopen($fileName, "w") or die("Unable to open file!");
		$txt = $dt->format('Y-m-d H:i:s') . ',' . $rawString;
		fwrite($myfile, $txt);
		fclose($myfile);
	}

?>