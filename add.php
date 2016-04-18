<html>
<head>
<script src="/js/jquery-1.11.3.min.js"></script>
<script src="/js/sql.js"></script>
<script src="/js/load.js"></script>
</head>
<body>
<H1>ADD USER</H1>
<h3>新增使用者</h3>
<a href="list.php">list</a>  |  <a href="log.php">log</a>  |  <a href="login.php">login</a>  |  <a href="command.php">command</a>  |  <a href="index.php">dashboard</a><br><br>
<?php

if(isset($_POST['submit'])){
if(is_null($_POST['UID'])){
echo "UID是必須填寫的";
}

if(is_null($_POST['NAME'])){
echo "NAME 名字是必須填寫的";
}
if(is_null($_POST['RACK01'])){
echo "RACK01 權限1是必須填寫的";
}
if(is_null($_POST['RACK02'])){
echo "RACK02 權限2是必須填寫的";
}
}
?>

<?php

$UID   = $_POST[UID];
$NAME  = $_POST[NAME];
$RACK01= $_POST[RACK01];
$RACK02= $_POST[RACK02];

//判斷UID是否在資料庫中已被使用

$db = new SQLite3('RFID.db');
$SQL = 'SELECT UID FROM list' ;
$compare = $db->exec($compare);
$db->close();
//------------------------------

// 檢查 1.表單是否有缺 2.UID是否已存在資料庫 3. 寫入資料庫
if($UID=="" or $NAME=="" or $RACK01=="" or $RACK02==""){
    echo "請填滿表單內容";
}elseif ($compare =!"") 
{
    echo "該使用卡號已經註冊";
}
else{
  $db = new SQLite3('RFID.db') or die('Unable to open database');
  $SQL = "INSERT INTO list (UID,NAME,RACK01,RACK02) VALUES ('$UID','$NAME','$RACK01','$RACK02')";
  $db->exec($SQL);
  $db->close();
}
?>

<form action="add.php" name="form" method="post">
  <ol>
		<li>UID</li>
        <input type="text" name="UID" value=""><br/>
		<li>NAME</li>
        <input type="text" name="NAME"><br/>
		<li>RACK01</li>
        <input type="radio" name="RACK01" value="0" checked> 不允許 <input type="radio" name="RACK01" value="1"> 允許 <br/>
		<li>RACK02</li>
        <input type="radio" name="RACK02" value="0" checked> 不允許 <input type="radio" name="RACK02" value="1"> 允許 <br/>
		<input type="reset" name="reset"><input type="submit" name="submit" value="Send">
  </ol>
</form>

<script type="text/javascript">
  $.ajaxSetup({ cache: false });
var tid = setInterval(reload_identify, 1000);
  function reload_identify() {
    $.get('web.txt', function(data){
        var array =data.split(',');
    	var UID=array[1];
    document.form.UID.value = UID;
    });
}
function abortTimer() { // to be called when you want to stop the timer
      clearInterval(tid);
  }
</script>

</body>
</html>
