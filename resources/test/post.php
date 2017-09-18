<?php
//header("Content-Type:text/plain ");
include('simple_html_dom.php');
$link = "https://www.udemy.com/api-2.0/channels/1670/courses?is_angular_app=true&p=3";
$posts = json_decode(file_get_contents($link), true);
//echo var_dump($posts);
//echo var_dump($posts['pagination']['total_page']);
echo var_dump($posts["results"]);
?>