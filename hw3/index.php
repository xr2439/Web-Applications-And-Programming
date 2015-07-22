<?php
include_once "./func.php";
print '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
print '<link rel=stylesheet type="text/css" href="./res/css/index.css">';
print'
		<div class="nav">
		<a class="nav1" href="index.php">書籤</a>
		<a class="nav2" href="metasearch.php">搜尋</a>
		<a class="nav3" href="profile.php">會員中心</a>
		<a class="nav4" href="modify.php">管理書籤</a>
	 ';

if (is_login())
{
	print '<a class="nav5" href="login.php?action=logout">登出</a></div>';
}
else
{
	print '<a class="nav5" href="login.php">登入</a></div><br><br><br>';
	print '<div class="info"><br><br><br>&nbsp&nbsp&nbsp&nbsp請由上方登入</div>';
	exit;
}
?>
<?php
	include "./mysql_config.php";
	
	/* search for the user id */
	$result= mysql_query("SELECT * FROM `userdata` WHERE username='$_COOKIE[user]'", $link);
	$rows= mysql_fetch_array($result,MYSQL_ASSOC);
	$id = $rows['id'];
	
	/* search for the user's bookmark and print out it*/
	$result= mysql_query("SELECT * FROM `bookmark` WHERE userid='$id'", $link);
	$rows= mysql_fetch_array($result,MYSQL_ASSOC);
	if (!$rows)
	{
		print '<div class="info">&nbsp&nbsp&nbsp&nbsp無書籤資料</div>';
	}
	else
	{
		print '<div class="data">你的書籤：</div><form>';
		print '<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.'<a class="info" href="'.$rows['url'].'">'.$rows['name'].'</a><br>';
		while ($rows= mysql_fetch_array($result,MYSQL_ASSOC))
			print '<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.'<a class="info" href="'.$rows['url'].'">'.$rows['name'].'</a><br>';
		print '</form>';
	}
		
	
	
	
?>