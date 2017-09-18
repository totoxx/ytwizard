<?php
// Include the library
include('simple_html_dom.php');
class Utils{
	//function get links
	public static function getLink($str){
		$link = array();
		$html = str_get_html($str);
		$e = $html->find("a", 0);
		$link["url"] = $e->href;
		$img = $e->find("IMG", 0);
		$link["img"] = $img->src; 
		return $link;	
	} 
	public static function getUdemyInfo($link){
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
	public static function strip_single_tag($str,$tag){

		$str1=preg_replace('/<\/'.$tag.'>/i', '', $str);

		if($str1 != $str){

			$str=preg_replace('/<'.$tag.'[^>]*>/i', '', $str1);
		}

		return $str;
	}
	public static function make_bitly_url($url,$login='mrgauss',$appkey='R_ddbc157f82654c70ab2d970e269e340e',$format = 'json',$version = '2.0.1')
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
	public static function retrieve_remote_file_size($url){
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
	 public static function getRemoteFilesize($url, $formatSize = true, $useHead = true)
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
	public static function getRedirectUrl ($url) {
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
	 public static function getVideosFromLink($link)
	{
	$html = file_get_html($link);
	$e1 = $html->find('course-preview',0)->previews;

	$xxx= htmlspecialchars_decode(html_entity_decode($e1, ENT_QUOTES | ENT_XML1, 'UTF-8'));
	$xxx = str_replace("\'", '==', $xxx);
	$xxx = str_replace("\"", "*7*", $xxx);
	$xxx = str_replace("'", "\"", $xxx);

	$xxx = json_decode($xxx,true);
	for($i=0; $i<sizeof($xxx); $i++){
	$xxx1 = str_replace("*7*{", "\"{", $xxx[$i]);
	$xxx2 = str_replace("}*7*", "}\"", $xxx1);
	$xxx3 = str_replace('==', "\'", $xxx2);
	//echo $xxx2["title"];
	$e2 = str_get_html($xxx3["asset_html"]);
	$xxx4 = $e2->find('react-video-player',0)->getAttribute("videojs-setup-data");
	$xxx5 = str_replace("*7*", "\"", $xxx4);
	$xxx6 = json_decode($xxx5,true);
	//print_r($xxx6) ;
	//echo "\n--------\n";
	$videos =  $xxx6["sources"][sizeof($xxx6["sources"])-1]["src"];
	//echo "\n--------\n";
	}	
	return $videos ;	
	}
	//Get all posts for a specific categories 
	public static function getAllCategoryPosts($catID,$p=1){
	$link = "https://www.udemy.com/api-2.0/channels/$catID/courses?is_angular_app=true&p=$p";
	$posts = json_decode(file_get_contents($link), true);	
	return $posts["results"] ;	
	}
}

?>