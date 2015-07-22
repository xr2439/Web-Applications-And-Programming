<?php
ini_set("display_errors", "off");
$uesd = 0;
if($_REQUEST['user'])
{
	include "./mysql_config.php";
	$result= mysql_query("SELECT * FROM `userdata` WHERE username='$_REQUEST[user]'", $link);
	if($rows= mysql_fetch_array($result,MYSQL_ASSOC))
	{
		$uesd = 1;
	}
	else
	{
		print '此帳號註冊成功，3秒後將自動轉至'.'<a href="./login.php">'.'登入</a>'.'畫面';		
		$r=md5($_POST['pw']);
		$result=mysql_query("INSERT INTO `userdata` (`id` ,`username` ,`password`, `email`, `nickname`) VALUES ( NULL , '$_REQUEST[user]', '$r', '', '');", $link);
		print '
			<script language="javascript">
			var t = 4;
			function Goto()
			{
				t--;
				if (t==0)
					location.href="./login.php";
				setTimeout("Goto()",1000);
			}
			Goto();
		</script>
			';
		exit;
	}
}

print '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
print '<link rel=stylesheet type="text/css" href="./res/css/reg.css">';
print '		
		<script language="javascript">
		function Change_Reg()
		{
			document.getElementsByClassName("nav5")[0].innerHTML = "登入";
		}
		function Change_Login()
		{
			document.getElementsByClassName("nav5")[0].innerHTML = "註冊";
		}
		</script>
	';
print'
		<div class="nav">
		<a class="nav1" href="index.php">書籤</a>
		<a class="nav2" href="metasearch.php">搜尋</a>
		<a class="nav3" href="profile.php">會員中心</a>
		<a class="nav4" href="modify.php">管理書籤</a>
		<a class="nav5" href="login.php" onmouseover="Change_Reg()" onmouseout="Change_Login()">註冊</a></div><br><br><br>';
print '
	<form action="reg.php" method="post">
	帳號: <input type="text" name="user" /><br/>
	密碼: <input type="password" name="pw" />
	<input type="submit" value="註冊" />	
	</form>
	  '; 
	  
if ($uesd == 1)
	print '<br><br><div class="info">此帳號有人使用</div>';
?>
