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
			if (rack01Array[2])=='0' {
    		// 執行關閉
        		image.src = "images/locker_close.png";
        	// $('#button'+id).html("開啟");
        	   $.get("http://192.168.43.240:8090/", {command:0});
        	
    		} else {
    		// 執行打開
        	image.src = "images/locker_open.png";
        	// $('#button'+id).html("關閉");
//    		}
		});


		jQuery.get('RACK02.txt', function(data) {
			rack02Array = data.split(',');
			setRack02Info();
			if (rack02Array[2])=='0' {
    		// 執行關閉
        		image.src = "images/locker_close.png";
        	// $('#button'+id).html("開啟");
        	 $.get("http://192.168.0.152:8090/", {command:0});
        	
    		} else {
    		// 執行打開
        	image.src = "images/locker_open.png";
        	// $('#button'+id).html("關閉");
    		}
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
		d2.setSeconds(d2.getSeconds() + 999999);
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


    	if (id == '01') {
    		$.get("http://192.168.43.240:8090/", {command:1});
    	}else {
    		$.get("http://192.168.43.152:8090/", {command:1});
    	}     
    	alert("開鎖命令已發送")

    	$.get(
    		"command_add.php", 
    		{ UID: array[1], ID: parseInt(id) }, 
    		// { UID: array[1], ID: parseInt(id) },
  			function(data){});

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
<body>
<p id="status">未認證</p>
<p id="authorityAll"></p>
<div id="div">
	<table border=1 width=400 cellpadding="5">
		<tr>
			<th width=70></th>
			<th>機櫃1</th>
			<th>機櫃2</th>
		</tr>
		<tr>
			<td></td>
			<td><img id="RACK01IMAGE" src="images/locker_close.png" width="125" height="272"></td>
			<td><img id="RACK02IMAGE" src="images/locker_close.png" width="125" height="272"></td>
		</tr>
		<tr>
			<td>權限</td>
			<td id="authority1"></td>
			<td id="authority2"></td>

		</tr>
		<tr>
			<td>磁簧</td>
			<td id="Door1"></td>
			<td id="Door2"></td>
		</tr>
		<tr>
			<td>鎖</td>
			<td><button id="button01" type="button" disabled onClick="openButtonPressed('01')">開鎖</button></td>
			<td><button id="button02" type="button" disabled onClick="openButtonPressed('02')">開鎖</button></td>
		</tr>
		<tr>
			<td>溫度</td>
			<td id="T1"></td>
			<td id="T2"></td>
		</tr>
		<tr>
			<td>濕度</td>
			<td id="H1"></td>
			<td id="H2"></td>
		</tr>
		<tr>
			<td>露點</td>
			<td id="Dow1"></td>
			<td id="Dow2"></td>
		</tr>
	</table>
</div>
<!-- <p>Click me away!</p>
<p>Click me too!</p>
<button>Get External Content</button> -->

</body>
</html>
<?php }

?> 
