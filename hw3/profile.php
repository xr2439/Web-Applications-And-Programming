<?php
	include_once "./func.php";
	if($_REQUEST['action'] == "profile")
	{
		if ($_REQUEST[email] || $_REQUEST[nickname])
		{
		include "./mysql_config.php";
		$result= mysql_query("SELECT * FROM `userdata` WHERE username='$_COOKIE[user]'", $link);
		$rows= mysql_fetch_array($result,MYSQL_ASSOC);
		$id = $rows['id'];
		if ($_REQUEST[email] && $_REQUEST[nickname])
			mysql_query("UPDATE `userdata` SET `email` = '$_REQUEST[email]', `nickname` = '$_REQUEST[nickname]' WHERE `id` = '$id'");
		else if ($_REQUEST[email])
			mysql_query("UPDATE `userdata` SET `email` = '$_REQUEST[email]' WHERE `id` = '$id'");
		else
			mysql_query("UPDATE `userdata` SET `nickname` = '$_REQUEST[nickname]' WHERE `id` = '$id'");
		print "<script>location.href='profile.php';</script>";
		exit;
		}
	}
	if($_REQUEST['action'] == "profile_pw")
	{
		include "./mysql_config.php";
		$result= mysql_query("SELECT * FROM `userdata` WHERE username='$_COOKIE[user]'", $link);
		$rows= mysql_fetch_array($result,MYSQL_ASSOC);
		$id = $rows['id'];
		$r = md5($_REQUEST['pw']);
		mysql_query("UPDATE `userdata` SET `password` = '$r' WHERE `id` = '$id'");
		print "<script>location.href='profile.php';</script>";
		exit;
	}
?>

<?php
print '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
print '<link rel=stylesheet type="text/css" href="./res/css/profile.css">';
print'
		<div class="nav">
		<a class="nav1" href="index.php">書籤</a>
		<a class="nav2" href="metasearch.php">搜尋</a>
		<a class="nav3" href="profile.php">會員中心</a>
		<a class="nav4" href="modify.php">管理書籤</a>
	    ';
?>

<?php
	if (is_login())
	{
		print '<a class="nav5" href="login.php?action=logout">登出</a></div><br><br><br>';
	}
	else
	{
		print '<a class="nav5" href="login.php">登入</a></div><br><br><br>';
		print '<div class="info"><br><br><br>&nbsp&nbsp&nbsp&nbsp請由上方登入</div>';
	}

?>

<?php
	if (!is_login())
		exit;
	
	include "./mysql_config.php";
	$result= mysql_query("SELECT * FROM `userdata` WHERE username='$_COOKIE[user]'", $link);
	$rows= mysql_fetch_array($result,MYSQL_ASSOC);
	
	print '<div class="data">你的資料：<br>';
	print '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp暱稱：'.$rows[nickname].'<br>';
	print '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp信箱：'.$rows[email].'</div><br><br><br>';
		
	print '<form action="profile.php" method="post">
	暱稱: <input type="text" name="nickname" /><br/>
	信箱: <input type="email" name="email" /><br/>
	<input type="hidden" name="action" value="profile">
	<input type="submit" value="更改" />	</form><br><br><br>';
	
	print '<form action="profile.php" method="post">
	新密碼: <input type="text" name="pw" />
	<input type="hidden" name="action" value="profile_pw">
	<input type="submit" value="更改密碼" />	</form>';
?>