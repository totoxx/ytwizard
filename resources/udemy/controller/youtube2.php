<?php
session_start();
ini_set('max_execution_time', 0);
//die(var_dump($_SESSION['title'][0]));
//header("Content-type: video/mp4");
/**
 * Library Requirements
 *
 * 1. Install composer (https://getcomposer.org)
 * 2. On the command line, change to this directory (api-samples/php)
 * 3. Require the google/apiclient library
 *    $ composer require google/apiclient:~2.0
 */
 /*function file_get_contents_curl($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}*/

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
  throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
}
require '../dao/youtubeDAO.php';
require_once __DIR__ . '/vendor/autoload.php';
//session_start();

/*
 * You can acquire an OAuth 2.0 client ID and client secret from the
 * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
 * For more information about using OAuth 2.0 to access Google APIs, please see:
 * <https://developers.google.com/youtube/v3/guides/authentication>
 * Please ensure that you have enabled the YouTube Data API for your project.
 */
//function upload_video_to_yt($link, $title, $desc, $tags){
$key = file_get_contents('token.txt');	
$OAUTH2_CLIENT_ID = '877081627189-4f5of171mi2t81a3jfps9oq7dvv3841q.apps.googleusercontent.com';
$OAUTH2_CLIENT_SECRET = 'KUWnowr-nwoEuRwzpxnxw9SK';

$client = new Google_Client();
$guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
$client->setHttpClient($guzzleClient);
$client->setClientId($OAUTH2_CLIENT_ID);
$client->setClientSecret($OAUTH2_CLIENT_SECRET);
$client->setAccessType('offline');
$client->setApprovalPrompt('force');
$client->setAccessToken($key);
//$client->setScopes('https://www.googleapis.com/auth/youtube');
/*$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
    FILTER_SANITIZE_URL);
$client->setRedirectUri($redirect);*/


// Define an object that will be used to make all API requests.
$youtube = new Google_Service_YouTube($client);
/*
// Check if an auth token exists for the required scopes
$tokenSessionKey = 'token-' . $client->prepareScopes();
if (isset($_GET['code'])) {
  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
    die('The session state did not match.');
  }

  $client->authenticate($_GET['code']);
  $_SESSION[$tokenSessionKey] = $client->getAccessToken();
  $refreshToken = $client->getRefreshToken();
  $_SESSION["token"] = $refreshToken;
  header('Location: ' . $redirect);
}

if (isset($_SESSION[$tokenSessionKey])) {
  $client->setAccessToken($_SESSION[$tokenSessionKey]);
}
*/
// Check to ensure that the access token was successfully acquired.
if ($client->getAccessToken()) {
	$data= getYtData();
for($i=0; $i<sizeof($data);$i++){
	echo "Upload video -***- ".$i."<br/>";
	$vsize = array();
 $link= $data[$i]["linkVideo"];
 $shortenLink = $data[$i]["shortenLinkAffiliate"];
 $title= $data[$i]["titleModified"];
 $newLine = "
";	
$desc = $shortenLink.$newLine.$shortenLink.$newLine.$newLine.$data[$i]["descOrgine"];
 $size=$data[$i]["sizeVideo"];
 $thumb=$data[$i]["thumb"];
 if($client->isAccessTokenExpired()) {
			$key = file_get_contents('token.txt');
			$newToken = json_decode($key);
			//die(var_dump($newToken)."ffffffffffffff");
            //$newToken = json_decode($client->getAccessToken());
            $client->refreshToken($newToken->refresh_token);
			//die(var_dump($client->getAccessToken()["access_token"])."ffffffffffffff");
			$newtk = '{"access_token":"'.$client->getAccessToken()["access_token"].'","token_type":"Bearer","expires_in":3600,"refresh_token":"1\/BwEW_x3KufMhTpQVEPOJsIqijn4RBfsYzS8nq-fk1y0","created":1481462282}';
			$guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
			$client->setHttpClient($guzzleClient);
            file_put_contents('token.txt', $newtk);
        }else{
			$key = file_get_contents('token.txt');
			$client->setAccessToken($key);
			$guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
			$client->setHttpClient($guzzleClient);
		}
 $tags= array("udemy", "udemy course", "online tutorial", "online learning", "udemy review", "udemy coupon", "udemy voucher", "udemy discount");
  $htmlBody = '';
  try{
    // REPLACE this value with the path to the file you are uploading.
    $videoPath = $link;

    // Create a snippet with title, description, tags and category ID
    // Create an asset resource and set its snippet metadata and type.
    // This example sets the video's title, description, keyword tags, and
    // video category.
    $snippet = new Google_Service_YouTube_VideoSnippet();
    $snippet->setTitle($title);
    $snippet->setDescription($desc);
    $snippet->setTags($tags);
	//array("tag1", "tag2")
    // Numeric video category. See
    // https://developers.google.com/youtube/v3/docs/videoCategories/list
    $snippet->setCategoryId("27");

    // Set the video's status to "public". Valid statuses are "public",
    // "private" and "unlisted".
    $status = new Google_Service_YouTube_VideoStatus();
    $status->privacyStatus = "public";

    // Associate the snippet and status objects with a new video resource.
    $video = new Google_Service_YouTube_Video();
    $video->setSnippet($snippet);
    $video->setStatus($status);

    // Specify the size of each chunk of data, in bytes. Set a higher value for
    // reliable connection as fewer chunks lead to faster uploads. Set a lower
    // value for better recovery on less reliable connections.
    $chunkSizeBytes = 10 * 1024 * 1024;

    // Setting the defer flag to true tells the client to return a request which can be called
    // with ->execute(); instead of making the API call immediately.
    $client->setDefer(true);

    // Create a request for the API's videos.insert method to create and upload the video.
    $insertRequest = $youtube->videos->insert("status,snippet", $video);

    // Create a MediaFileUpload object for resumable uploads.
    $media = new Google_Http_MediaFileUpload(
        $client,
        $insertRequest,
        'video/*',
        null,
        true,
        $chunkSizeBytes
    );
	/*$s = strlen(file_get_contents($videoPath));
	if (in_array($s, $vsize)) {
        continue;
	}else{
		$vsize[]= $s;
	}*/
   //$media->setFileSize($s); 
	$media->setFileSize($size);

	// sleep (10);
	//die(getRemoteFilesize($videoPath));
    // Read the media file and upload it chunk by chunk.
    $status = false;
	//$videoPath = file_get_contents_curl($videoPath);
    $handle = fopen($videoPath, "rb");
	//sleep (10);
	//die($handle);
    while (!$status && !feof($handle)) {
      $chunk = fread($handle, $chunkSizeBytes);
      $status = $media->nextChunk($chunk);
    }
	 //$chunk = fread($handle, getRemoteFilesize($videoPath));
	 //$chunk = readfile($videoPath);
      //$status = $media->nextChunk($chunk);
    fclose($handle);
	$vsize[]= $status['id'];
    // If you want to make other calls after the file upload, set setDefer back to false
	/* added code */
	// REPLACE this value with the video ID of the video being updated.
    $videoId = $status['id'];

    // REPLACE this value with the path to the image file you are uploading.
    $imagePath = $thumb;

    // Specify the size of each chunk of data, in bytes. Set a higher value for
    // reliable connection as fewer chunks lead to faster uploads. Set a lower
    // value for better recovery on less reliable connections.
    $chunkSizeBytes = 1 * 1024 * 1024;

    // Setting the defer flag to true tells the client to return a request which can be called
    // with ->execute(); instead of making the API call immediately.
    //$client->setDefer(true);

    // Create a request for the API's thumbnails.set method to upload the image and associate
    // it with the appropriate video.
    $setRequest = $youtube->thumbnails->set($videoId);

    // Create a MediaFileUpload object for resumable uploads.
    $media = new Google_Http_MediaFileUpload(
        $client,
        $setRequest,
        'image/png',
        null,
        true,
        $chunkSizeBytes
    );
    $media->setFileSize(strlen(file_get_contents($imagePath)));


    // Read the media file and upload it chunk by chunk.
    $status2 = false;
    $handle = fopen($imagePath, "rb");
    while (!$status2 && !feof($handle)) {
      $chunk = fread($handle, $chunkSizeBytes);
      $status2 = $media->nextChunk($chunk);
    }

    fclose($handle);
	/* endof added code */
    $client->setDefer(false);
	/*if (sizeof($vsize) == sizeof($_SESSION['video'])) {
        header("Location: fin.php"); 
		exit();
	}*/

    $htmlBody .= "<h3>Video Uploaded</h3><ul>";
    $htmlBody .= sprintf('<li>%s (%s)</li>',
        $status['snippet']['title'],
        $status['id']);

    $htmlBody .= '</ul>';
//die(var_dump($status));
  } catch (Google_Service_Exception $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  }
  updateYtUpload("uploaded", $status['snippet']['title']);
  if($i==2){
	exit();  
  }
}
  //$_SESSION[$tokenSessionKey] = $client->getAccessToken();
} elseif ($OAUTH2_CLIENT_ID == 'REPLACE_ME') {
  $htmlBody = <<<END
  <h3>Client Credentials Required</h3>
  <p>
    You need to set <code>\$OAUTH2_CLIENT_ID</code> and
    <code>\$OAUTH2_CLIENT_ID</code> before proceeding.
  <p>
END;
} else {
  // If the user hasn't authorized the app, initiate the OAuth flow
  $state = mt_rand();
  $client->setState($state);
  $_SESSION['state'] = $state;

  $authUrl = $client->createAuthUrl();
  $htmlBody = <<<END
  <h3>Authorization Required</h3>
  <p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
}
?>
<!doctype html>
<html>
<head>
<title>Video Uploaded</title>
</head>
<body>
  <?=$htmlBody?>
</body>
</html>
<?php 

/*$_SESSION[$i]['video']
$_SESSION[$i]['title']
$_SESSION[$i]['description']
$_SESSION[$i]['link']*/

//upload_video_to_yt($_SESSION['video'][0], $_SESSION['title'][0], 'test desc', array("tag1", "tag2"));
//upload_video_to_yt($_SESSION['video'][1], $_SESSION['title'][1], 'test desc', array("tag1", "tag2"));
//$videoPath = 'https://udemy-assets-on-demand2.udemy.com/2015-09-02_23-53-06-92d3971567ccee47432f8e1a1d4a9399/WebHD.mp4?nva=20161111230756&amp;token=0605f7a05ebed2be68028';
//echo strlen(file_get_contents($videoPath));
//echo '<br>';
//echo getRemoteFilesize($videoPath);
?>

