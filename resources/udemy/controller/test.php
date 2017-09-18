<?php
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_YouTubeService.php';

// Set your cached access token. Remember to replace $_SESSION with a real database or memcached.
session_start();

// Connect to the Account you want to upload the video to (Note: When Remembering your access code you only need to do this once)
$client = new Google_Client();
$client->setApplicationName('udemy');
$client->setClientId('877081627189-4f5of171mi2t81a3jfps9oq7dvv3841q.apps.googleusercontent.com');
$client->setClientSecret('KUWnowr-nwoEuRwzpxnxw9SK');
$client->setRedirectUri('http://localhost/udemy/controller/test.php');
$client->setDeveloperKey('AIzaSyALprw718mMyjOiHTiJjrwgJE58KBVx4ew');

// Load the Youtube Service Library
$youtube = new Google_YouTubeService($client);

// Authenticate the user when he comes back with the access code
if (isset($_GET['code']))
{
    $client->authenticate();
    $_SESSION['token'] = $client->getAccessToken();
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

// Check if the Token is set in the Session. If so set it to the client
if (isset($_SESSION['token']))
{
    $client->setAccessToken($_SESSION['token']);
}

// Check if the client has an access Token elke Give him a login Link
if ($client->getAccessToken())
{
    // Upload the youtube Video
    try
    {
        $path_to_video_to_upload = 'https://udemy-assets-on-demand.udemy.com/2016-05-25_16-36-59-63262563f6746d3820fe0b11181b9790/WebHD.mp4?nva=20161106214929&amp;token=0c86f831bc742d438da31';

        // Get the Mimetype of your video
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $path_to_video_to_upload);

        // Build the Needed Video Information
        $snippet = new Google_VideoSnippet();
        $snippet->setTitle('Title Of Video');
        $snippet->setDescription('Description Of Video');
        $snippet->setTags(array('Udemy', 'Review', 'discount', 'Udemy coupon', 'Udemy course'));
        $snippet->setCategoryId(27);

        // Build the Needed video Status
        $status = new Google_VideoStatus();
        $status->setPrivacyStatus('private'); // or public, unlisted

        // Set the Video Info and Status in the Main Tag
        $video = new Google_Video();
        $video->setSnippet($snippet);
        $video->setStatus($status);

        // Send the video to the Google Youtube API
        $created_file = $youtube->videos->insert('snippet,status', $video, array(
            'data' => file_get_contents($path_to_video_to_upload),
            'mimeType' => $mime_type,
        ));

        // Get the information of the uploaded video
        print_r($createdFile);
    }
    catch (Exception $ex)
    {
        echo $ex;
    }

    // We're not done yet. Remember to update the cached access token.
    // Remember to replace $_SESSION with a real database or memcached.
    $_SESSION['token'] = $client->getAccessToken();
}
else
{
    $authUrl = $client->createAuthUrl();
    print "<a href='$authUrl'>Connect Me!</a>";
}

?> 