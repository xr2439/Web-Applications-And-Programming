<?php
include_once "./func.php";
$login_success = 1; 
if($_REQUEST['action']=="logout")
{
	setcookie("user","");
	setcookie("pw","");
	print "<script>location.href='login.php';</script>";
	exit;
}
if($_REQUEST['user'])
{
	$r=md5($_POST['pw']);
	if(vaild($_REQUEST['user'],$r))
	{
		setcookie("user",$_REQUEST['user']);
		setcookie("pw",$r);
		print "登入成功";
		print "<script>location.href='index.php';</script>";
		exit;
	}
	else
	{  
		$login_success = 0; 
	}
}
print '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
print '<link rel=stylesheet type="text/css" href="./res/css/login.css">';
print '		
		<script language="javascript">
		function Change_Reg()
		{
			document.getElementsByClassName("nav5")[0].innerHTML = "註冊";
		}
		function Change_Login()
		{
			document.getElementsByClassName("nav5")[0].innerHTML = "登入";
		}
		</script>
	  ';
print'
		<div class="nav">
		<a class="nav1" href="index.php">書籤</a>
		<a class="nav2" href="metasearch.php">搜尋</a>
		<a class="nav3" href="profile.php">會員中心</a>
		<a class="nav4" href="modify.php">管理書籤</a>
	    <a class="nav5" href="reg.php" onmouseover="Change_Reg()" onmouseout="Change_Login()">登入</a></div><br><br><br>';
login();
if ($login_success == 0)
	print '<br><br><div class="info">登入失敗</div>';
?>
