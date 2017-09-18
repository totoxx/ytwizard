<?php
//header("Content-Type:text/plain ");
ini_set('max_execution_time', 0);
include('simple_html_dom.php');

$link = "newx.html";
$html = file_get_html($link);
$ret = $html->find('div[id=dropdownButton]', 0);
//echo var_dump($ret);
//die();
$ret2 = $ret->find('ul[class="dropdown__menu-list"]', 0);
$ret3 = $ret2->find('li[class="menu__link"]');
//echo var_dump($ret3);
//die();
foreach($ret3 as $rr){
	$x1 = $rr->find('a[class="main-cat"]',0)->href;
	$x2 = $rr->find('a[class="main-cat"]',0)->plaintext;
	echo "<br>*******<br>".$x2." -- ".$x1."<br>*******<br>";
	$x2 = $rr->find('ul[class="menu__sub-list"]',0);
	$ret33 = $x2->find('li');
	foreach($ret33 as $rrr){
	$x11 = $rrr->find('a',0)->href;	
	$x12 = $rrr->find('a',0)->plaintext;
	$x13 = 	CatID($x11);
	echo $x12." -- ".$x11." -- ".$x13."<br>" ;
	}

}
function CatID($cat){
$link = "https://www.udemy.com".$cat;
$html = file_get_html($link);
preg_match_all('/\/api-2.0\/channels\/(\d+)\/\?format=json/', $html, $xxx);
return $xxx[1][0];	
}

?>