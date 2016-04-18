<?php
// $myfile = fopen("web.txt", "r") or die("Unable to open file!");
// $content = fread($myfile,filesize("web.txt"));
// fclose($myfile);

// $part = explode(",", $content);

// print_r($part);

// 	if ($part[1] == "None") {
// 		echo "錯誤";
// 	}else {
// 		echo "已登入";
// 	}

$finalArray;

function readFromDB() {
	global $finalArray;
    $db = new SQLite3('RFID.db');

	$results = $db->query("SELECT * 
FROM log 
WHERE time=(
    SELECT max(time) FROM log WHERE ID ='1'
    )
	
UNION

SELECT * 
FROM log 
WHERE time=(
    SELECT max(time) FROM log WHERE ID ='2'
    )");

  	while ($row = $results->fetchArray()) {
    	// var_dump($row);
    	// print_r($row);

    	$finalArray[] = $row;
	}
	// print_r($finalArray);
} 

if(1) { ?>
     <!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<style type="text/css">
	#p1 {
		color:red;
	}
	#div {
		visibility:hidden;
	}
	td {
		text-align:center;
	}
</style>
<script src="/js/jquery-1.11.3.min.js"></script>
<script src="/js/sql.js"></script>
<script>


	$.ajaxSetup({ cache: false });


	var ttt;
	var array;
	var rack01Array;
	$(document).ready(function(){
    	// $("p").click(function(){
    	//     $(this).hide();
    	// });

		// jQuery.get('web.txt', function(data) {

  //  			$('#p1').html(data);
  //  			if (data) {
  //  				check();
  //  			};
   			
		// });

	read();

	}); 

	var tid = setInterval(reload_identify, 1000);
	function reload_identify() {

		jQuery.get('web.txt', function(data) {
			ttt = data;
   			//process text file line by line
   			$('#authorityAll').html(data);
   			array = ttt.split(',');
   			check();
		});

		jQuery.get('RACK01.txt', function(data) {
			rack01Array = data.split(',');
			setRack01Info();
		});


		jQuery.get('RACK02.txt', function(data) {
			rack02Array = data.split(',');
			setRack02Info();
		});

		<?php }

		// $test1 ="11";
		// $test2 =  $test1 . "22";

		// $aaa = readFromDB();
		// readFromDB();

		if(1) { ?>


		// var htmlString="<?php echo $test2 . '33'; ?>";
		// alert(htmlString);
		// alert("<?php echo $aaa[1]['time']; ?>");
		// alert("<?php echo $finalArray[1]['time']; ?>");
		// var aaa = "<?php echo readFromDB(); ?>"
		// setInfo();
	}

	function abortTimer() { // to be called when you want to stop the timer
  		clearInterval(tid);
	}


	function stringToDate(dateString) {

		var t = dateString.split(/[- :]/);
		var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
		return d;
	}

	function check() {

		var d1 = new Date;
		// alert(d1);

		var d2 = stringToDate(array[0]);
		d2.setSeconds(d2.getSeconds() + 60);
		// alert(d2);

		console.log(d1 + " " +d2);

			if (d2 > d1 && array[2] != 'None') {

				console.log('success');
				$("#div").css("visibility","visible");
				$('#status').html("認證成功  <b>" + array[2] + "</b>  <a href='login.php'>管理頁面</a>");

				// if (array[2]) {
				// 	$('#button1').prop('disabled', array[2]);
				// };
				
				$('#authority1').html(array[3]);
				$('#authority2').html(array[4]);
				$('#button01').prop('disabled', array[3] == 0);
				$('#button02').prop('disabled', array[4] == 0);
			}else {
				console.log('failure');
				$("#div").css("visibility","hidden");
				$('#status').html("認證失敗");
			}

	}

	function openButtonPressed(id) {

		var image = document.getElementById("RACK"+id+"IMAGE");

    	if (image.src.match("open")) {
    		// 執行關閉
        	image.src = "images/locker_close.png";
        	// $('#button'+id).html("開啟");
        	
    	} else {
    		// 執行打開
        	image.src = "images/locker_open.png";
        	// $('#button'+id).html("關閉");

    	}
    	
    	
	}

	// function setInfo() {
	// 	$('#Door1').html("<?php echo $finalArray[0]['Door']; ?>");
	// 	$('#Door2').html("<?php echo $finalArray[1]['Door']; ?>");
	// 	$('#Lock1').html("<?php echo $finalArray[0]['Lock']; ?>");
	// 	$('#Lock2').html("<?php echo $finalArray[1]['Lock']; ?>");
	// 	$('#T1').html("<?php echo $finalArray[0]['T']; ?>");
	// 	$('#T2').html("<?php echo $finalArray[1]['T']; ?>");
	// 	$('#H1').html("<?php echo $finalArray[0]['H']; ?>");
	// 	$('#H2').html("<?php echo $finalArray[1]['H']; ?>");
	// 	$('#Dow1').html("<?php echo $finalArray[0]['Dow']; ?>");
	// 	$('#Dow2').html("<?php echo $finalArray[1]['Dow']; ?>");
	// }

	function setRack01Info() {

		$('#Door1').html(rack01Array[2]);
		// if (rack01Array[3]) {
		// 	$('#button01').html('關閉');
		// }else {
		// 	$('#button01').html('開啟');
		// }
		$('#T1').html(rack01Array[4]);
		$('#H1').html(rack01Array[5]);
		$('#Dow1').html(rack01Array[6]);
		
	}

	function setRack02Info() {

		$('#Door2').html(rack02Array[2]);
		// if (rack02Array[3]) {
		// 	$('#button02').html('關閉');
		// }else {
		// 	$('#button02').html('開啟');
		// }
		$('#T2').html(rack02Array[4]);
		$('#H2').html(rack02Array[5]);
		$('#Dow2').html(rack02Array[6]);
	}


</script>
</head>
<body background="./images/bg.png">
<p id="status">未認證</p>
<p id="authorityAll"></p>
<table id="Table_01" width="1025" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="1024" height="50" colspan="24">
			<img src="images/spacer.gif" width="1024" height="50" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="50" alt="" /></td>
	</tr>
	<tr>
		<td width="47" height="718" rowspan="19">
			<img src="images/spacer.gif" width="47" height="718" alt="" /></td>
		<td colspan="3">
			<img id="status_01" src="images/status_01.png" width="250" height="75" alt="" /></td>
		<td width="40" height="718" rowspan="19">
			<img src="images/spacer.gif" width="40" height="718" alt="" /></td>
		<td colspan="3">
			<img id="status_02" src="images/status_02.png" width="250" height="75" alt="" /></td>
		<td width="437" height="216" colspan="16" rowspan="2">
			<img src="images/spacer.gif" width="437" height="216" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="75" alt="" /></td>
	</tr>
	<tr>
		<td colspan="3" rowspan="13">
			<img id="rack_01" src="images/rack_01.png" width="250" height="550" alt="" /></td>
		<td colspan="3" rowspan="13">
			<img id="rack_02" src="images/rack_02.png" width="250" height="550" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="141" alt="" /></td>
	</tr>
	<tr>
		<td colspan="7">
			<img id="THD" src="images/THD.png" width="203" height="38" alt="" /></td>
		<td width="13" height="502" rowspan="17">
			<img src="images/spacer.gif" width="13" height="502" alt="" /></td>
		<td colspan="7" rowspan="2">
			<img id="THD2" src="images/THD2.png" width="203" height="39" alt="" /></td>
		<td width="18" height="502" rowspan="17">
			<img src="images/spacer.gif" width="18" height="502" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="38" alt="" /></td>
	</tr>
	<tr>
		<td rowspan="10">
			<img id="THD008" src="images/THD-08.png" width="21" height="159" alt="" /></td>
		<td colspan="2" rowspan="4">
			<img id="THD_num1" src="images/THD_num1.png" width="35" height="35" alt="" /></td>
		<td colspan="4" rowspan="2">
			<img id="THD010" src="images/THD-10.png" width="147" height="3" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="1" alt="" /></td>
	</tr>
	<tr>
		<td rowspan="9">
			<img id="THD2011" src="images/THD2-11.png" width="22" height="158" alt="" /></td>
		<td colspan="2" rowspan="4">
			<img id="THD_num2" src="images/THD_num2.png" width="35" height="35" alt="" /></td>
		<td colspan="4">
			<img id="THD2013" src="images/THD2-13.png" width="146" height="2" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="2" alt="" /></td>
	</tr>
	<tr>
		<td rowspan="4">
			<img id="THD014" src="images/THD-14.png" width="38" height="49" alt="" /></td>
		<td colspan="2">
			<img id="THD_Dew1" src="images/THD_Dew1.png" width="40" height="30" alt="" /></td>
		<td rowspan="8">
			<img id="THD016" src="images/THD-16.png" width="69" height="156" alt="" /></td>
		<td rowspan="4">
			<img id="THD2017" src="images/THD2-17.png" width="36" height="49" alt="" /></td>
		<td colspan="2">
			<img id="THD_Dew2" src="images/THD_Dew2.png" width="40" height="30" alt="" /></td>
		<td rowspan="8">
			<img id="THD2019" src="images/THD2-19.png" width="70" height="156" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="30" alt="" /></td>
	</tr>
	<tr>
		<td colspan="2" rowspan="3">
			<img id="THD020" src="images/THD-20.png" width="40" height="19" alt="" /></td>
		<td colspan="2" rowspan="3">
			<img id="THD2021" src="images/THD2-21.png" width="40" height="19" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="2" alt="" /></td>
	</tr>
	<tr>
		<td colspan="2" rowspan="2">
			<img id="THD022" src="images/THD-22.png" width="35" height="17" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="1" alt="" /></td>
	</tr>
	<tr>
		<td colspan="2">
			<img id="THD2023" src="images/THD2-23.png" width="35" height="16" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="16" alt="" /></td>
	</tr>
	<tr>
		<td rowspan="4">
			<img id="THD024" src="images/THD-24.png" width="31" height="107" alt="" /></td>
		<td colspan="3">
			<img id="THD_T1" src="images/THD_T1.png" width="70" height="35" alt="" /></td>
		<td rowspan="4">
			<img id="THD026" src="images/THD-26.png" width="12" height="107" alt="" /></td>
		<td rowspan="4">
			<img id="THD2027" src="images/THD2-27.png" width="29" height="107" alt="" /></td>
		<td colspan="3">
			<img id="THD_T2" src="images/THD_T2.png" width="70" height="35" alt="" /></td>
		<td rowspan="4">
			<img id="THD2029" src="images/THD2-29.png" width="12" height="107" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="35" alt="" /></td>
	</tr>
	<tr>
		<td colspan="3">
			<img id="THD030" src="images/THD-30.png" width="70" height="16" alt="" /></td>
		<td colspan="3">
			<img id="THD2031" src="images/THD2-31.png" width="70" height="16" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="16" alt="" /></td>
	</tr>
	<tr>
		<td colspan="3">
			<img id="THD_H1" src="images/THD_H1.png" width="70" height="35" alt="" /></td>
		<td colspan="3">
			<img id="THD_H2" src="images/THD_H2.png" width="70" height="35" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="35" alt="" /></td>
	</tr>
	<tr>
		<td colspan="3">
			<img id="THD034" src="images/THD-34.png" width="70" height="21" alt="" /></td>
		<td colspan="3">
			<img id="THD2035" src="images/THD2-35.png" width="70" height="21" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="21" alt="" /></td>
	</tr>
	<tr>
		<td width="203" height="305" colspan="7" rowspan="6">
			<img src="images/spacer.gif" width="203" height="305" alt="" /></td>
		<td width="203" height="305" colspan="7" rowspan="6">
			<img src="images/spacer.gif" width="203" height="305" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="212" alt="" /></td>
	</tr>
	<tr>
		<td width="250" height="12" colspan="3">
			<img src="images/spacer.gif" width="250" height="12" alt="" /></td>
		<td width="250" height="12" colspan="3">
			<img src="images/spacer.gif" width="250" height="12" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="12" alt="" /></td>
	</tr>
	<tr>
		<td colspan="3">
			<img id="tagBar_01" src="images/tagBar_01.png" width="250" height="3" alt="" /></td>
		<td colspan="3">
			<img id="tagBar_02" src="images/tagBar_02.png" width="250" height="3" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="3" alt="" /></td>
	</tr>
	<tr>
		<td rowspan="2">
			<img id="tagBar_01038" src="images/tagBar_01-38.png" width="15" height="43" alt="" /></td>
		<td>
			<img id="tag_num_01" src="images/tag_num_01.png" width="40" height="40" alt="" /></td>
		<td rowspan="2">
			<img id="tagBar_01040" src="images/tagBar_01-40.png" width="195" height="43" alt="" /></td>
		<td rowspan="2">
			<img id="tagBar_02041" src="images/tagBar_02-41.png" width="15" height="43" alt="" /></td>
		<td>
			<img id="tag_num_02" src="images/tag_num_02.png" width="40" height="40" alt="" /></td>
		<td rowspan="2">
			<img id="tagBar_02043" src="images/tagBar_02-43.png" width="195" height="43" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="40" alt="" /></td>
	</tr>
	<tr>
		<td>
			<img id="tagBar_01044" src="images/tagBar_01-44.png" width="40" height="3" alt="" /></td>
		<td>
			<img id="tagBar_02045" src="images/tagBar_02-45.png" width="40" height="3" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="3" alt="" /></td>
	</tr>
	<tr>
		<td width="250" height="35" colspan="3">
			<img src="images/spacer.gif" width="250" height="35" alt="" /></td>
		<td width="250" height="35" colspan="3">
			<img src="images/spacer.gif" width="250" height="35" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="1" height="35" alt="" /></td>
	</tr>
	<tr>
		<td>
			<img src="images/spacer.gif" width="47" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="15" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="40" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="195" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="40" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="15" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="40" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="195" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="21" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="31" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="4" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="38" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="28" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="12" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="69" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="13" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="22" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="29" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="6" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="36" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="28" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="12" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="70" height="1" alt="" /></td>
		<td>
			<img src="images/spacer.gif" width="18" height="1" alt="" /></td>
		<td></td>
	</tr>
</table>
</body>
</html>
<?php }






?> 