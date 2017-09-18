<?php
header("Content-Type:text/plain ");
include('simple_html_dom.php');

$link = "https://www.udemy.com/courses/photography/";
$html = file_get_html($link);
preg_match_all('/\/api-2.0\/channels\/(\d+)\/\?format=json/', $html, $xxx);

echo var_dump($xxx[1][0]);
die();

?>