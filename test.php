
<?php

$db = new SQLite3('RFID.db');

$results = $db->query('SELECT * FROM list');

$finalArray;

while ($row = $results->fetchArray()) {
    // var_dump($row);
    print_r($row);
    echo "<br><br>" . $row['useremail'];

    $finalArray[] = $row;
}

echo "<br>總共有 " . count($finalArray) . "筆<br><br>";

print_r($finalArray);

echo "<br><br>第二筆的 NAME " . $finalArray[1]['NAME'];
echo "<br><br>第二筆的 NAME " . $finalArray[1][1];

?>
