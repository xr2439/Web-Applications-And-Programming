<?php
// 編碼設定

ini_set("display_errors", "off");
function vaild($users,$pws)
{
	if($users and $pws)
	{
		include "./mysql_config.php";
		$result = mysql_query("SELECT * FROM `userdata` WHERE username='$users'", $link);
		if($rows= mysql_fetch_array($result,MYSQL_ASSOC))
			if($rows['password'] == $pws)
				return 1;
	}
	return 0;
}
function login(){
	print '<meta charset="UTF-8">
	<form action="login.php" method="post">
	帳號: <input type="text" name="user" /><br/>
	密碼: <input type="password" name="pw" />
	<input type="submit" value="登入" />
	</form>
	'; 
}

function is_login()
{
	if ( $_COOKIE['user'] == "")
		return false;
	$users = $_COOKIE['user'];
	$pws = $_COOKIE['pw'];
	if($users and $pws)
	{
		include "./mysql_config.php";
		$result = mysql_query("SELECT * FROM `userdata` WHERE username='$users'", $link);
		if($rows= mysql_fetch_array($result,MYSQL_ASSOC))
			if($rows['password'] == $pws)
				return true;
	}
}
?>
