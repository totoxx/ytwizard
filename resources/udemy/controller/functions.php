<?php
// Include the library
include('simple_html_dom.php');

//function get links
function getLink($str){
	$link = array();
	$html = str_get_html($str);
	$e = $html->find("a", 0);
	$link["url"] = $e->href;
	$img = $e->find("IMG", 0);
	$link["img"] = $img->src; 
	return $link;	
} 
function getUdemyInfo($link){
	$ud_info = array();
	$html = file_get_html($link);
	 if (!empty($html)) {
	$e1 = $html->find('source[data-res="720"]',0);
	$e2 = $html->find('source[data-res="480"]',0);	
	$e3 = $html->find('source[data-res="360"]',0);
	$t = $html->find('h1[data-purpose="course-title"]',0);
	$d = $html->find('div[id="desc"]',0);
	 if (!empty($d)) {
	$desc = $d->find('div[class="js-simple-collapse-inner"]',0);
	 }else{
		 return $ud_info;
	 }
	//get video link:
	if(isset($e1->src)){
		$ud_info['video'] = htmlspecialchars_decode($e1->src);
		$ud_info['size'] = intval(retrieve_remote_file_size($ud_info['video']));
	}
	elseif(isset($e2->src)){
		$ud_info['video'] = htmlspecialchars_decode($e2->src);
		$ud_info['size'] = intval(retrieve_remote_file_size($ud_info['video']));
	}
	elseif(isset($e3->src)){
		$ud_info['video'] = htmlspecialchars_decode($e3->src);
		$ud_info['size'] = intval(retrieve_remote_file_size($ud_info['video']));
	}else{
		$ud_info['video'] = 0;
		$ud_info['size'] = 0;
		} 
	//get title:	
	if(isset($t)){
		$ud_info['title'] = htmlspecialchars_decode($t->plaintext);
	}else{
		$ud_info['title'] = 0;
		}
	//get Description:	
	if(isset($desc)){
		//$ud_info['desc'] = htmlspecialchars_decode($desc->plaintext);
		$newLine = "
";
		$dd = strip_tags(htmlspecialchars_decode($desc->outertext), '<p>');
		$dd=str_replace("<p>", "", $dd);
		$dd=str_replace('<p style="">', "", $dd);
		$dd=str_replace("</p>", $newLine, $dd);
		$dd = preg_replace('/ +/', ' ', $dd);
		$ud_info['desc'] = trim($dd);
	}else{
		$ud_info['desc'] = 0;
		}		
	
	 }
return $ud_info;	 
}
function strip_single_tag($str,$tag){

    $str1=preg_replace('/<\/'.$tag.'>/i', '', $str);

    if($str1 != $str){

        $str=preg_replace('/<'.$tag.'[^>]*>/i', '', $str1);
    }

    return $str;
}
function make_bitly_url($url,$login='mrgauss',$appkey='R_ddbc157f82654c70ab2d970e269e340e',$format = 'json',$version = '2.0.1')
{
	//create the URL
	$bitly = 'http://api.bit.ly/shorten?version='.$version.'&longUrl='.urlencode($url).'&login='.$login.'&apiKey='.$appkey.'&format='.$format;
	
	//get the url
	//could also use cURL here
	//$response = file_get_contents($bitly);
	$curl_handle=curl_init();
	curl_setopt($curl_handle, CURLOPT_URL,$bitly);
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
	$response = curl_exec($curl_handle);
	curl_close($curl_handle);
	
	//parse depending on desired format
	if(strtolower($format) == 'json')
	{
		$json = @json_decode($response,true);
		return $json['results'][$url]['shortUrl'];
	}
	else //xml
	{
		$xml = simplexml_load_string($response);
		return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
	}
}
function retrieve_remote_file_size($url){
     $ch = curl_init($url);

     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
     curl_setopt($ch, CURLOPT_HEADER, TRUE);
     curl_setopt($ch, CURLOPT_NOBODY, TRUE);
	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

     $data = curl_exec($ch);
     $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

     curl_close($ch);
     return $size;
} 
 function getRemoteFilesize($url, $formatSize = true, $useHead = true)
{
    if (false !== $useHead) {
        stream_context_set_default(array('http' => array('method' => 'HEAD')));
    }
    $head = array_change_key_case(get_headers($url, 1));
    // content-length of download (in bytes), read from Content-Length: field
    $clen = isset($head['content-length']) ? $head['content-length'] : 0;

    // cannot retrieve file size, return "-1"
    if (!$clen) {
        return -1;
    }

    if (!$formatSize) {
        return $clen; // return size in bytes
    }

    $size = $clen;
    switch ($clen) {
        case $clen < 1024:
            $size = $clen .' B'; break;
        case $clen < 1048576:
            $size = round($clen / 1024, 2) .' KiB'; break;
        case $clen < 1073741824:
            $size = round($clen / 1048576, 2) . ' MiB'; break;
        case $clen < 1099511627776:
            $size = round($clen / 1073741824, 2) . ' GiB'; break;
    }
	//sleep (60);
    return $clen; // return formatted size
}
function getRedirectUrl ($url) {
    stream_context_set_default(array(
        'http' => array(
            'method' => 'HEAD'
        )
    ));
    $headers = get_headers($url, 1);
    if ($headers !== false && isset($headers['Location'])) {
        return is_array($headers['Location']) ? array_pop($headers['Location']) : $headers['Location'];
    }
    return false;
}
//echo retrieve_remote_file_size("https://udemy-images.udemy.com/course/100x100/147314_92f4_3.jpg");
//echo "<br>";
//echo retrieve_remote_file_size("https://udemy-assets-on-demand2.udemy.com/2016-10-31_23-19-07-9f5c1d632c9c6a1262203b3da2b01126/WebHD.mp4?nva=20161122193724&token=0eac8d3072ef8a94bc9d0");
//echo "<br>";
//echo retrieve_remote_file_size("https://udemy-assets-on-demand.udemy.com/2016-11-13_07-23-00-31fea871319381cd9abf02a3bedd8ff1/WebHD.mp4?nva=20161122194349&token=04ab326ef49f6e9c06483");
?>