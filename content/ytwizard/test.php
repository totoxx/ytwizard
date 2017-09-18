<?php 
require_once __DIR__."/../../dao/Channel.php" ;
require_once __DIR__."/../../dao/Category.php" ;
//if(!@)) echo "Not fount !!!!!!!!!"; die();
/*$xx = '{ "kind": "youtube#channelListResponse", "etag": "\"m2yskBQFythfE4irbTIeOgYYfBU/dNqxiWVB8hOOYwCNFYP2ytOgcbo\"", "pageInfo": { "totalResults": 1, "resultsPerPage": 1 }, "items": [ { "kind": "youtube#channel", "etag": "\"m2yskBQFythfE4irbTIeOgYYfBU/-KSph1QSVjWLxhQ4EEuLFeNkX9s\"", "id": "UCFAJSAMeh7-dWQWRHa7Ejcw" } ] }';
$yy = json_decode($xx, true);*/
//var_dump($yy["items"][0]["id"]);addChannel($id, $token, $reftoken, $verified, $status="ok")
//echo "ddd  ";
//echo addChannel("gfhfgh", "hhhhh", "kkk","not", "ok");
//addCategoryList("test", "/test/cat1", 2356, 1000, 1); //ca marche !
// addCategoryChannel(22, 33); ca marche !
//$d = getCategoryList() ;
//var_dump($d);
$i = 1;
//$categories = '</ul></fieldset></div>'.(($i%3==0) ? 'kkkkkkkkk' : '').'<div';
//echo $categories;
/* $cats =[1640, 1656, 1658] ;
$data = getSelectedCategoryList($cats);
var_dump($data);*/
$x = addCategory(1235, 1) ;
echo 1111, $x ;
?>
