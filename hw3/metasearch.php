<?php

include_once "./func.php";

print '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';

print '<link rel=stylesheet type="text/css" href="./res/css/metasearch.css">';

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

	}



?>



<?php

	if ($_REQUEST[searchiteam] != $_REQUEST[presearchitem])

		$_REQUEST[page] = "";

	if ($_REQUEST[searchbtn])

		if ($_REQUEST[page])

			$_REQUEST[page] = "";

	if ($_REQUEST[downbtn] || $_REQUEST[upbtn] || $_REQUEST[searchbtn])

	{

	if ($_REQUEST[downbtn])

		if ($_REQUEST[page])

			$_REQUEST[page] = $_REQUEST[page]+1;

	if ($_REQUEST[upbtn])

		if ($_REQUEST[page])

			$_REQUEST[page] = $_REQUEST[page]-1;

			

	if (!$_REQUEST[page] || $_REQUEST[page] < 1)

		$_REQUEST[page] = 1;

	}

		//echo $_REQUEST[page];

//print "<em>Test</em> your Internet connection bandwidth to locations around the world with this interactive broadband speed <em>test</em> from Ookla.";

	print '<form action="metasearch.php" method="post">

	<input type="text" name="searchiteam" value="'.$_REQUEST["searchiteam"].'"/><br/>

	<input type="hidden" name="action" value="search">

	<input type="hidden" name="presearchitem" value="'.$_REQUEST["searchiteam"].'">

	<input name="searchbtn" type="submit" value="搜尋" />	

	<input type="hidden" name="page" value="'.$_REQUEST[page].'"> ';

	print '<input name="upbtn" type="submit" value="上一頁" />  ';

	print '<input name="downbtn" type="submit" value="下一頁" />';

	

	print '</form>';

?>

<?php

if (!$_REQUEST['action'] == "search")

	exit;







$url = "https://www.google.com.tw/search?hl=zh-TW&ei=SmN3VJzXKYHOmwWszIHABA&oe=utf-8&q=" . urlencode($_REQUEST['searchiteam']) . "&start=" . ($_REQUEST[page]-1) ."0";

//echo $url;

$content = file_get_contents($url);

//$content = iconv ("", "UTF-8", $content);





//echo $content;

//$filename= "./searchtmp.txt";

//$fp = fopen($filename,"w+") or die("Can't open file $filename");

//$fout = fwrite($fp, $content);

//if ($fout != strlen($content))

//{

//  echo "file write failed!";

//}

//fclose($fp);

$html = new DOMDocument('1.0','UTF-8');

//

//@$html->loadHtmlFile("./searchtmp.txt");

@$html->loadHtml($content);



/*

$nodes = $html->getElementsByTagName('span');

foreach($nodes as $node) {

    $classes = $node->getAttribute('class');

    if ($classes == 'st')

		echo $nodes->nodeValue.'<br><br>';

}*/







$xpath = new DOMXPath( $html );

$titles = $xpath->query("//html/body/table/tbody/tr/td/div/div/div/div/ol/li/h3");

$urls = $xpath->query("//html/body/table/tbody/tr/td/div/div/div/div/ol/li/h3/a/@href");

$contents = $xpath->query("//html/body/table/tbody/tr/td/div/div/div/div/ol/li/div/span");



for ($i = 0; $i < $urls->length; $i++)

	$tmp[$i] = $urls->item($i)->childNodes->item(0)->nodeValue;



$n = rawurldecode(implode ("\n\n" , $tmp));

preg_match_all("/\/url\?q\=http[s]*\:\/\/.+&sa/", $n, $tmpurls);



//echo "<br>test".count($tmpurls[0])."test";

//echo "<br>test".count($tmp)."test";

//echo "<br>title".$titles->length."test";

//echo "<br>urls ".$urls->length."test";

//echo "<br>conte".$contents->length."test";



unset ($n); 

$j = 0;

for ($i = 0, $k = 0; $i < $urls->length; $i++)

{

	if (strpos ("0".$tmp[$i], "/url?q="))

	{

		$gtitle[$j] = $titles->item($i)->firstChild->nodeValue;

		foreach ($contents->item($j)->childNodes as $node)

			$gcontent[$j] = $gcontent[$j] . $node->nodeValue;

		$gurl[$j] = substr ( $tmpurls[0][$i] , 7, strlen($tmpurls[0][$i]) -10);

		$j++;

		//$//k++;

	//$j++;

	}//else if (strpos ("0".$tmp[$i], "/images?hl="))

	//	$k++;

	//echo "hi<br>";

}

	//preg_match_all("/\/url\?q\=http[s]*\:\/\/.+&sa/", $n, $gurls);



//echo "<br>test".count($tmpurls[0])."test";

//echo "<br>test".count($tmp)."test";

//echo "<br>title".count($gtitle)."test";

//echo "<br>urls ".count($gurl)."test";

//echo "<br>conte".count($gcontent)."test";



for ($i = 0; $i < sizeof($gurl); $i++)

{

	print '<form>';

    print '<a class="link" href="'.$gurl[$i].'">';

	print '<div class="data">';

	print $gtitle[$i].'</a><br>';

	print $gcontent[$i].'...<br><br><br><br>';

	print '</div></form>';

}



//exit;

/* yahoo 修正 */

$url = "https://tw.search.yahoo.com/search?p=" . urlencode($_REQUEST['searchiteam']) . "&b=" . ($_REQUEST[page]-1) ."1";

$content = file_get_contents($url);

//$content = iconv ("", "UTF-8", $content);

//$filename= "./searchtmp.txt";

//$fp = fopen($filename,"w+") or die("Can't open file $filename");

//$fout = fwrite($fp, $content);

//if ($fout != strlen($content)){

//  echo "file write failed!";

//}

//fclose($fp);





$html = new DOMDocument('1.0','UTF-8');

//@$html->loadHtmlFile("./searchtmp.txt");

@$html->loadHtml($content);



$xpath = new DOMXPath( $html );

$titles = $xpath->query("//html/body/div/div/div/div/div/div/div/ol/li/div/div/h3/a[@id]");

$urls = $xpath->query("//html/body/div/div/div/div/div/div/div/ol/li/div/div/h3/a[@id]/@href");

$contents = $xpath->query("//html/body/div/div/div/div/div/div/div/ol/li/div/div[@class='abstr']");



$j=0;

for ($i = 0; $i < $titles->length; $i++)

{

	$same = 0;

	

	for ($k =0; $k < sizeof($gurl); $k++)

	{

		if ($urls->item($i)->childNodes->item(0)->nodeValue == $gurl[$k])

			$same = 1;

	}

	if ($same == 0)

	{

		$ytitle[$j] = $titles->item($i)->childNodes->item(0)->nodeValue;

		foreach ($contents->item($i)->childNodes as $node)

			$ycontent[$j] = $ycontent[$j] . $node->nodeValue;

		$yurl[$j] = $urls->item($i)->childNodes->item(0)->nodeValue;

		$j++;

	}

	//echo "hi<br>";

}

for ($i = 0; $i < sizeof($yurl); $i++)

{

	print '<form>';

    print '<a class="link" href="'.$yurl[$i].'">';

	print '<div class="data">';

	print $ytitle[$i].'</a><br>';

	print $ycontent[$i].'...<br><br><br><br>';

	print '</div></form>';

}



?>