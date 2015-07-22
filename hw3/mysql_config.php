<?php

	$host="140.116.245.148";//please modify as "140.116.245.148" when you upload

	$user="f74024062";//your student id.

	$pw="roy840118";//your pw.

	$db="f74024062";//your student id.

	$link=mysql_connect($host,$user,$pw) or die ("Unable to connect!");

	mysql_select_db($db, $link) or die ("Unable to select database!");



?>