<?php
	include_once "./func.php";
	if($_REQUEST['action'] == addbookmark)
	{
		if ($_REQUEST[name] && $_REQUEST[url])
		{
			include "./mysql_config.php";
			$result= mysql_query("SELECT * FROM `userdata` WHERE username='$_COOKIE[user]'", $link);
			$rows= mysql_fetch_array($result,MYSQL_ASSOC);
			$id = $rows['id'];
			mysql_query("INSERT INTO `bookmark` (`id`, `userid`, `name`, `url`) VALUES (NULL, '$id', '$_REQUEST[name]', '$_REQUEST[url]');");
			print "<script>location.href='modify.php';</script>";
			exit;
		}
	}
?>

<?php
	if($_REQUEST['action'] == delbookmark)
	{
		include "./mysql_config.php";
		foreach ($_REQUEST[bookmarkids] as $ids) 
			mysql_query("DELETE FROM `bookmark` WHERE `bookmark`.`id` = $ids;");
		print "<script>location.href='modify.php';</script>";
		exit;
	}
?>
<?php
	print '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
	print '<link rel=stylesheet type="text/css" href="./res/css/modify.css">';
	print'
			<div class="nav">
			<a class="nav1" href="index.php">書籤</a>
			<a class="nav2" href="metasearch.php">搜尋</a>
			<a class="nav3" href="profile.php">會員中心</a>
			<a class="nav4" href="modify.php">管理書籤</a>
	    ';
	if (is_login())
	{
		print '<a class="nav5" href="login.php?action=logout">登出</a></div><br><br><br>';
	}
	else
	{
		print '<a class="nav5" href="login.php">登入</a></div><br><br><br>';
		print '<div class="info"><br><br><br>&nbsp&nbsp&nbsp&nbsp請由上方登入</div>';
		exit;
	}
?>
<?php

	print '<form action="modify.php" method="post">
	名稱: <input type="text" name="name" /><br/>
	網址: <input type="text" name="url" />
	<input type="hidden" name="action" value="addbookmark">
	<input type="submit" value="新增書籤" />	</form>';
	
	include "./mysql_config.php";
	/* search for the user id */
	$result= mysql_query("SELECT * FROM `userdata` WHERE username='$_COOKIE[user]'", $link);
	$rows= mysql_fetch_array($result,MYSQL_ASSOC);
	$id = $rows['id'];
	
	
	//  http://sofree.cc/php-checkbox/
	// http://article.denniswave.com/1082
	
	$result= mysql_query("SELECT * FROM `bookmark` WHERE userid='$id'", $link);
	$rows= mysql_fetch_array($result,MYSQL_ASSOC);
	if (!$rows)
	{
		print '<div class="data"><br><br><br>&nbsp&nbsp&nbsp&nbsp你還沒有建立書籤</div>';
	}
	else
	{	
		print '<form action="modify.php" method="post">';
		print "<br>"."<input type=\"checkbox\" name=\"bookmarkids[]\" value=\"$rows[id]\"><label><a class=\"link\" href=\"".$rows[url]."\">".$rows[name]."</a></label><br>";
		while ($rows= mysql_fetch_array($result,MYSQL_ASSOC))
			print "<br>"."<input type=\"checkbox\" name=\"bookmarkids[]\" value=\"$rows[id]\"><label><a class=\"link\" href=\"".$rows[url]."\">".$rows[name]."</a></label><br>";
		print '<input type="hidden" name="action" value="delbookmark">
		<br><input type="submit" value="刪除書籤" />	</form>';
	}

?>