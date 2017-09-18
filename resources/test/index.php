<?php
header("Content-Type:text/plain ");
include('simple_html_dom.php');
$id=27080;
$link = "https://www.udemy.com/".$id."/preview/";
$html = file_get_html($link);
$e1 = $html->find('course-preview',0)->previews;

/*$e2 = str_get_html($e1);
$e3 = $e2->find('source[data-res="720"]',0);
$e11 = html_entity_decode(htmlspecialchars_decode($e1));*/
//echo $e11;
//$xx= json_decode($xx, true);WebHD_720p.mp4
//$e11 = html_entity_decode($e1);
/*preg_match_all('/&amp;quot;sources&amp;quot;:\[\{&amp;quot;src&amp;quot;:&amp;quot;(.*)WebHD_720p.mp4(.*)&amp;quot;/im', $e1,    $todosenlaces);*/
$xxx= htmlspecialchars_decode(html_entity_decode($e1, ENT_QUOTES | ENT_XML1, 'UTF-8'));
$xxx = str_replace("\'", '==', $xxx);
$xxx = str_replace("\"", "*7*", $xxx);
$xxx = str_replace("'", "\"", $xxx);
/*$x="<br>";
$xx = str_replace("\"", "*7*", $xx);
$xx = str_replace("'", '"', $xx);
$xx = str_replace("*7*", "'", $xx);
$xx = str_replace("\u0026", "&", $xx);
$xx = str_replace("  ", " ", $xx);
$xx = str_replace("  ", " ", $xx);
$xx = str_replace("  ", " ", $xx);
$xx = str_replace("  ", " ", $xx);
$xx = str_replace("  ", " ", $xx);
$xx = str_replace("\\n", "", $xx);
$xx= json_decode($xx,true);
$xx = explode("</react-video-player>",$xx);
$regex = '/"title": ".[^"}]+"/i';
$title=preg_match_all($regex, $xx[5],    $todosenlaces);
//$e2 = str_get_html($xx);
//$e1 = $e2->find('react-video-player',0)->plaintext;
//echo var_dump($e1);
*/
//echo var_dump($todosenlaces);
$xxx = json_decode($xxx,true);
//$xxx = str_replace("*7*", "\"", $xxx[2]);
for($i=0; $i<sizeof($xxx); $i++){
$xxx1 = str_replace("*7*{", "\"{", $xxx[$i]);
$xxx2 = str_replace("}*7*", "}\"", $xxx1);
$xxx3 = str_replace('==', "\'", $xxx2);
echo $xxx2["title"];
/*preg_match_all('/https?[a-zA-Z0-9\.\/\?\:@\-_=#]{5,}(WebHD_720p)([a-zA-Z0-9\&\.\/\?\:@\-_=#])+/im', $xxx["asset_html"],    $xxx);*/
//echo var_dump($xxx);
//echo var_dump($xxx);
//die();
//addslashes($xxx);
$e2 = str_get_html($xxx3["asset_html"]);
$xxx4 = $e2->find('react-video-player',0)->getAttribute("videojs-setup-data");
//echo var_dump($e1);
//$xxx = explode("videojs-setup-data",$xxx);
$xxx5 = str_replace("*7*", "\"", $xxx4);
$xxx6 = json_decode($xxx5,true);
print_r($xxx6) ;
echo "\n--------\n";
echo $xxx6["sources"][sizeof($xxx6["sources"])-1]["src"];
echo "\n--------\n";
}
//echo var_dump($xxx);
die();

?>