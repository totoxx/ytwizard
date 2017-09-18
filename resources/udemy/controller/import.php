<?php
//
session_start();
ini_set('max_execution_time', 0);
//header("Content-Type:text/plain");
//die(var_dump($_SESSION["hh"]));
//include('youtube.php');
include('functions.php');
require '../dao/youtubeDAO.php';

$message = null;

$allowed_extensions = array('csv');

$upload_path = '../upload';
if (!isset($_FILES['file'])) {
	$_FILES['file'] = $_SESSION['file'];
}
if (!empty($_FILES['file'])) {
	$_SESSION['file'] = $_FILES['file'];
	//die(var_dump($_SESSION['file']));
        if ($_FILES['file']['error'] == 0) {
                        
                // check extension
                $file = explode(".", $_FILES['file']['name']);
                $extension = array_pop($file);
                
                if (in_array($extension, $allowed_extensions)) {
        
                        if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path.'/'.$_FILES['file']['name'])) {
                
                                if (($handle = fopen($upload_path.'/'.$_FILES['file']['name'], "r")) !== false) {
                                        
                                        $keys = array();
                                        $out = array();
                                        
                                        $insert = array();
                                        
                                        $line = 1;
                                        
                                        while (($row = fgetcsv($handle, 0, ',', '"')) !== FALSE) {
                                        
                                        foreach($row as $key => $value) {
                                                if ($line === 1) {
                                                        $keys[$key] = $value;
                                                } else {
                                                        $out[$line][$key] = $value;
                                                        
                                                }
                                        }
                                        
                                        $line++;
                                      
                                    }
                                    
      fclose($handle);    
                                    
    if (!empty($keys) && !empty($out)) {
		//$userinfo = explode(";",$out[2][0]);
$i=0;
 //die(var_dump($out));	
 foreach($out as $key => $value) {
$listAds = explode(";",$value[0]);
//$link = getRedirectUrl(getLink($listAds[0]));
$linkInfo = getLink($listAds[0]);
$link = $linkInfo["url"];
//echo "links ".$link."<br/>";
$shortenLink = make_bitly_url(htmlspecialchars_decode($link));
$info = getUdemyInfo($link);

if(isset($info['size'])){
$size = $info['size'];
//echo "size1 ".$size."<br/>";
if($size>0){
//echo $shortenLink.' - '.$link.'<br/>';
//echo '****************************<br/>';
$video = $info['video'];
$newLine = "
";	
$desc = $shortenLink.$newLine.$shortenLink.$newLine.$newLine.$info['desc'];
$tags = array($info['title'], "udemy", "udemy review", "udemy discount");
$t = trim($info['title']);
$rd = mt_rand(1,9);
$discount = 50+$rd*5; 
//$title = $t.' '.$discount.'% discount';
//$title=$t;
//$title=$t." review & discount";
//$title=$t." review";
$title=$t." course";
//upload_video_to_yt($video, $title, "test", $tags);
$_SESSION['thumb'][$i]=$linkInfo['img'];
$_SESSION['video'][$i]=$info['video'];
$_SESSION['title'][$i]= $title;
$_SESSION['description'][$i]= $desc;
$_SESSION['link'][$i]= $shortenLink;
$_SESSION['size'][$i]=$size;
//echo "size2 ".$size."<br/>";
addYtData($link, $shortenLink, $info['video'], $size, $t, $title, $info['desc'], $desc, $linkInfo['img'], "none");
$i++;
}
}
//echo $video.'<br/>'.$title.'<br/>'.$desc.'<br/>';	
//echo $desc;
//die();	
//
}
//die(var_dump($_SESSION['thumb']));  
 $message = '<br/><span class="green">Le fichier a été téléchargé avec succès</span>'; 
}       
                                    
}
                                
}
                        
} else {
      $message = '<br/><span class="red">Seul le format .csv fichier est autorisé</span>';
       }
                
} else {
      $message = '<br/><span class="red">Il y avait un problème avec votre fichier</span>';
	   }
        
}else {
      $message = '<br/><span class="red">Le fichier est vide</span>';
	  }

echo $message." fin" ;
//header("Location: youtube.php"); 
exit();
?>