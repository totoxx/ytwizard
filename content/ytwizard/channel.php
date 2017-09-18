<?php

require_once 'vendor/autoload.php';
if(!@require_once(__DIR__."/../../dao/Channel.php")) die("Not fount !!!!!!!!!");
if(!@require_once(__DIR__."/../../dao/Category.php")) die("Not fount !!!!!!!!!");


session_start();

/*
 * You can acquire an OAuth 2.0 client ID and client secret from the
 * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
 * For more information about using OAuth 2.0 to access Google APIs, please see:
 * <https://developers.google.com/youtube/v3/guides/authentication>
 * Please ensure that you have enabled the YouTube Data API for your project.
 */
//$OAUTH2_CLIENT_ID = '877081627189-4f5of171mi2t81a3jfps9oq7dvv3841q.apps.googleusercontent.com'; // Enter your Client ID here
$OAUTH2_CLIENT_ID = '452089079637-cvm4co5gb1954ai86iunp63lb1h3la69.apps.googleusercontent.com'; // Enter your Client ID here
//$OAUTH2_CLIENT_SECRET = 'KUWnowr-nwoEuRwzpxnxw9SK'; // Enter your Client Secret here
$OAUTH2_CLIENT_SECRET = 'uEeMxi0cCq2jDILASl7M710i'; // Enter your Client Secret here
$REDIRECT = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], FILTER_SANITIZE_URL);
$APPNAME = "WhiteWare Web";

$client = new Google_Client();
$guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
$client->setHttpClient($guzzleClient);
$client->setClientId($OAUTH2_CLIENT_ID);
$client->setClientSecret($OAUTH2_CLIENT_SECRET);
$client->setScopes('https://www.googleapis.com/auth/youtube');
$client->setRedirectUri($REDIRECT);
$client->setApplicationName($APPNAME);
$client->setAccessType('offline');
$client->setApprovalPrompt('force');
    
// Define an object that will be used to make all API requests.
$youtube = new Google_Service_YouTube($client);
if (isset($_GET['error']) && $_GET['error']=="access_denied" ) {
	header("location: ../../index.php");
}
if (isset($_GET['code']) && !isset($_SESSION['token2'])) {
    if (strval($_SESSION['state']) !== strval($_GET['state'])) {
        die('The session state did not match.');
    }

    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
	$_SESSION['token2'] = $_SESSION['token'] ;
}

if (isset($_SESSION['token'])) {
    $client->setAccessToken($_SESSION['token']);
	$token = $_SESSION['token']["access_token"];
	$refToken = $_SESSION['token']["refresh_token"];
	//die(var_dump($_SESSION['token']));
	//-------
	/*$youtube = new Google_Service_YouTube_ChannelStatus($client);
	 $parts = "id,status,snippet";
    $opts = array("mine" => true);
    $channels = $youtube->longUploadsStatus;
	//--------
	die(var_dump($channels));*/
	$url = "https://www.googleapis.com/youtube/v3/channels?part=id,status,snippet&mine=true&access_token=$token";
   //echo "Access Token: " . json_encode($_SESSION['token']);
   $channelData =  @file_get_contents($url);
   
   $channelDataArray = json_decode($channelData, true);  
   //die();
   if(is_array($channelDataArray)){
	$idChannel = $channelDataArray["items"][0]["id"];
	$verified =  $channelDataArray["items"][0]["status"]["longUploadsStatus"] ;
	if($verified != "allowed" ){ $message = "You will not receive videos, because your channel is not verified by phone number. check <a href=\"https://support.google.com/youtube/answer/171664?hl=en\" target=\"_blank\">here</a> how to verify your channel by phone and connect your channel again. Thank you." ; }else{
		$message = "";
	}
   }	
	else
	{
	$idChannel = null ;	
	$verified = null ;	
	}
    $id = Channel::addChannel($idChannel, $token, $refToken, $verified, "ok");

   //die();
   unset($_SESSION['token']);
}
	if($id == null ){
		//header("location : ../../index.php") ;
		header("Location: ../../index.php"); 
	}
?>
<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7 "> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9]><html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
	<!--<![endif]-->
	<head>

		<!-- Basic Page Needs -->
		<meta charset="utf-8">
		<title>Youtube Wizard</title>
		<meta name="description" content="" >
		<meta name="author" content="">

		<!-- Mobile Specific Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<!-- Favicons -->
		<link rel="shortcut icon" href="images/favicon.ico">

		<!-- FONTS -->
		<link rel='stylesheet' id='Roboto-css' href='http://fonts.googleapis.com/css?family=Roboto:100,300,400,400italic,700'>
		<link rel='stylesheet' id='Patua+One-css' href='http://fonts.googleapis.com/css?family=Patua+One:100,300,400,400italic,700'>
		
		<!-- CSS -->
		<link rel='stylesheet' id='global-css' href='../../css/global.css'>
		<link rel='stylesheet' id='structure-css' href='css/structure.css'>
		<link rel='stylesheet' id='local-css' href='css/insurance.css'>
		<link rel='stylesheet' id='custom-css' href='css/custom.css'>
<style>
.cattab {
	width : 24% ;
	display: inline-block ;
	float: left ;
}
</style>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

	</head>
	<body class=" layout-full-width header-classic minimalist-header header-menu-right sticky-header sticky-white subheader-both-center no-content-padding">
	<script>
	$(document).ready(function() {
	// Whenever the parent checkbox is checked/unchecked
	$(".parentcheckbox").on("change", function() {
		// save state of parent
		c = $(this).is(':checked');
		//console.log("testiiiii" + $(this).closest("div").find("input[type=checkbox]"));
		$(this).parents("fieldset:first").find("input[type=checkbox]").each(function() {
			// set state of siblings
			if($(this).is(':checked'))
			$(this).attr('checked', false);
		else
			$(this).attr('checked', true);
		});
	});
	
	// Update parent checkbox based on children
	/*$("input[type=checkbox]:not('.parentcheckbox')").change(function() {
		if ($(this).closest("div").find("input[type=checkbox]:not('.parentcheckbox')").not(':checked').length < 1) {
			$(this).closest("div").find(".parentcheckbox").attr('checked', true);
		} else {
			$(this).closest("div").find(".parentcheckbox").attr('checked', false);
		}
	});*/
});
	</script>
		<!-- Main Theme Wrapper -->
				<div id="Wrapper">
			<!-- Header Wrapper -->
				<div id="Header_wrapper" >
				<!-- Header -->
				<header id="Header">
					
					<!-- Header -  Logo and Menu area -->
				<div id="Top_bar">
						<div class="container">
							<div class="column one">
								<div class="top_bar_left clearfix">
									<!-- Logo-->
									<div class="logo">
										<a id="logo" href="../../index.php" title="YTwizard - BeTheme"><img class="scale-with-grid" src="images/insurance.png" alt="YTwizard - BeTheme" /></a>
									</div>
									<!-- Main menu-->
						<div class="menu_wrapper">
										 <nav id="menu">
                                        <ul id="menu-main-menu" class="menu">
                                            <li class=" current_page_item">
                                                <a href="../../index.php"><span><i class="icon-home"></i></span></a>
                                            </li>
                                            <li>
                                                <a href="howitwork.php"><span>How it works</span></a>
                                            </li>
                                            <li>
                                                <a href="newchannel.php"><span>New channel</span></a>
                                            </li>
                                            <li>
                                                <a href="faq.php"><span>FAQ</span></a>
                                            </li>
                                            <li>
                                                <a href="contact.php"><span>Contact us</span></a>
                                            </li>
                                        </ul>
                                    </nav><a class="responsive-menu-toggle " href="#"><i class="icon-menu"></i></a>
									</div>
									<!-- Header Searchform area-->
				<div class="search_wrapper">
										<form method="get" action="#">
											<i class="icon_search icon-search"></i><a href="#" class="icon_close"><i class="icon-cancel"></i></a>
											<input type="text" class="field" name="s" placeholder="Enter your search" />
											<input type="submit" class="submit flv_disp_none" value="" />
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</header>
				<!--Subheader area - only for certain pages -->
				<div id="Subheader">
					<div class="container">
						<div class="column one">
							<h1 class="title">Choose categories</h1>
							<h1 class="title" style="color:red;"><?= @$message ?></h1>
						</div>
					</div>
				</div>
			</div>
			<!-- Main Content -->
				<div id="Content">
				<div class="content_wrapper clearfix">
					<div class="sections_group">
						<div class="entry-content" >
							<div class="section sections_style_4" >
								<div class="section_wrapper clearfix">
									<div class="items_group clearfix">
										<!-- One full width row-->
				<div class="column one column_column">
											<div class="column_attr align_center" >
												<h3 class="hrmargin_0">Lists of currently available categories.</h3>
												<h5 class="hrmargin_0">choose what categories of videos you want to receive.</h5>
											</div>
										</div>
										<hr>
										<!-- One Third (1/3) Column -->
		
										<!-- Two Third (2/3) Column -->
						<div style="width:99%">
											<div class="jq-tabs tabs_wrapper tabs_horizontal">
											<!-- hhh -->
											<form method="post" action="thanks.php">
											<!-- cat 1 -->
											<input name="channelid" type="hidden" value="<?= $id ?>" />
											<?php 
											$i = 0 ;
											$categories = "";
											$data = Category ::getCategoryList() ;
											foreach($data as $row){
												if($row["number"]==$row["isParentCat"] && $i==0){
												$categories .= '<div class="cattab"><fieldset> <p style=" font-weight: bolder; color: #3f4044; "> <label class ="tandc"> <input class="tac parentcheckbox" type="checkbox" value="'.$row["number"].'" name="'.$row["name"].'" tabindex="30" autocomplete="off" /> '.$row["name"].'</label> </p> <ul>' ;	$i++;
												}elseif($row["number"]==$row["isParentCat"] && $i!=0){
												if($i%4==0){$var="<hr>";}else{$var="";}
												$categories .= '</ul></fieldset></div>'.$var.'<div class="cattab"><fieldset> <p style=" font-weight: bolder; color: #3f4044; "> <label class ="tandc"> <input class="tac parentcheckbox" type="checkbox" value="'.$row["number"].'" name="'.$row["name"].'" tabindex="30" autocomplete="off" /> '.$row["name"].'</label> </p> <ul>' ; $i++;	
												}else{
												$categories .= '<li><label class ="tandc"><input class="tac" type="checkbox" value="'.$row["number"].'" name="'.$row["name"].'" tabindex="30" autocomplete="off" />'.$row["name"].'</label></li>';
												}
												
											}
											echo $categories ;
											?>
											<br>
											<hr>
											<input type="submit" value="Submit Form" />
											<!--div class="cattab">
											<fieldset>
											<p style=" font-weight: bolder; color: #3f4044; ">
											<label class ="tandc">
											<input class="tac parentcheckbox"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Development</label>
											</p>
												<ul>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Web Development</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Mobile Apps</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Programming Languages</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Game Development</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Databases</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Software Testing</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Software Engineering</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Development Tools</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											E-Commerce</label></li>
												</ul>
											</fieldset>	
											</div>
												
											<div class="cattab">
											<fieldset>
											<p style=" font-weight: bolder; color: #3f4044; ">
											<label class ="tandc"><input class="tac parentcheckbox"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Business </label>
											</p>
												<ul>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Finance</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Entrepreneurship</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Communications</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Management</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Sales </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Strategy </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Operations </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Project Management</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Business Law</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Data & Analytics</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Home Business</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Human Resources</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Industry </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Media </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Real Estate</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Other </label></li>
												</ul>
											</fieldset>	
											</div>
												
											<div class="cattab">
											<fieldset>
											<p style=" font-weight: bolder; color: #3f4044; ">
											<label class ="tandc"><input class="tac parentcheckbox"type="checkbox"  name="tandc " tabindex="30" autocomplete="off" />
											IT & Software</label>
											</p>
												<ul>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											IT Certification</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Network & Security</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Hardware</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Operating Systems</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Other</label></li>
												</ul>
											</fieldset>	
											</div>
												
											<div class="cattab">
											<fieldset>
											<p style=" font-weight: bolder; color: #3f4044; ">
											<label class ="tandc"><input class="tac parentcheckbox"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Office Productivity</label>
											</p>
												<ul>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Microsoft </label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Apple </label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Google</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											SAP </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Intuit </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Salesforce  </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Oracle </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Other  </label></li>
												</ul>
											</fieldset>	
											</div>
											<hr>
											
											<div class="cattab">
											<fieldset>
											<p style=" font-weight: bolder; color: #3f4044; ">
											<label class ="tandc">
											<input class="tac parentcheckbox"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Personal Development</label>
											</p>
												<ul>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Personal Transformation</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Productivity </label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Leadership </label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Personal Finance</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Career Development</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Parenting & Relationships</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Happiness</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Religion & Spirituality</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Personal Brand Building</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Creativity </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Influence </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Self Esteem</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Stress Management</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Memory & Study Skills</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Motivation </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Other </label></li>
												</ul>
											</fieldset>	
											</div>
												
											<div class="cattab">
											<fieldset>
											<p style=" font-weight: bolder; color: #3f4044; ">
											<label class ="tandc"><input class="tac  parentcheckbox"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Design </label>
											</p>
												<ul>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Web Design</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Graphic Design</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Design Tools</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											User Experience</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Game Design</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Design Thinking</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											3D & Animation</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Fashion</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Architectural Design</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Interior Design</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Other</label></li>
												</ul>
											</fieldset>	
											</div>
												
											<div class="cattab">
											<fieldset>
											<p style=" font-weight: bolder; color: #3f4044; ">
											<label class ="tandc"><input class="tac parentcheckbox"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Marketing </label>
											</p>
												<ul>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Digital Marketing</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Search Engine Optimization</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Social Media Marketing</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Branding </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Marketing Fundamentals </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Analytics & Automation </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Public Relations </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Advertising  </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Video & Mobile Marketing </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Content Marketing </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Non-Digital Marketing </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Growth Hacking </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Affiliate Marketing </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Product Marketing </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Other </label></li>
												</ul>
											</fieldset>	
											</div>
												
											<div class="cattab">
											<fieldset>
											<p style=" font-weight: bolder; color: #3f4044; ">
											<label class ="tandc"><input class="tac parentcheckbox"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Lifestyle </label>
											</p>
												<ul>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Arts & Crafts</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Food & Beverage</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Beauty & Makeup</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Travel </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Gaming  </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Home Improvement </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Pet Care & Training </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Other  </label></li>
											
												</ul>
											</fieldset>	
											</div>
											<hr>
											
											<div class="cattab">
											<fieldset>
											<p style=" font-weight: bolder; color: #3f4044; ">
											<label class ="tandc">
											<input class="tac parentcheckbox"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Photography </label>
											</p>
												<ul>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Digital Photography</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Photography Fundamentals</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Portraits </label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Landscape</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Black & White</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Photography Tools</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Mobile Photography</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Travel Photography</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Commercial Photography</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Wedding Photography</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Wildlife Photography</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Video Design</label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Other </label></li>
												</ul>
											</fieldset>	
											</div>
												
											<div class="cattab">
											<fieldset>
											<p style=" font-weight: bolder; color: #3f4044; ">
											<label class ="tandc"><input class="tac parentcheckbox"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Health & Fitness</label>
											</p>
												<ul>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Fitness</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											General Health</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Sports </label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Nutrition </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Yoga  </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Mental Health </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Dieting  </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Self Defense </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Safety & First Aid </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Dance  </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Meditation  </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Other  </label></li>
												</ul>
											</fieldset>	
											</div>
												
											<div class="cattab">
											<fieldset>
											<p style=" font-weight: bolder; color: #3f4044; ">
											<label class ="tandc"><input class="tac parentcheckbox"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Teacher Training </label>
											</p>
												<ul>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Instructional Design</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Educational Development</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Teaching Tools</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Other </label></li>
												</ul>
											</fieldset>	
											</div>
												
											<div class="cattab">
											<fieldset>
											<p style=" font-weight: bolder; color: #3f4044; ">
											<label class ="tandc"><input class="tac parentcheckbox"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Academics </label>
											</p>
												<ul>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Social Science</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Math & Science</label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Humanities </label></li>
												<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											English </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Spanish  </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											German  </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											French  </label></li>
											<li><label class ="tandc"><input class="tac"type="checkbox"  name="tandc" tabindex="30" autocomplete="off" />
											Japanese  </label></li>
												</ul>
											</fieldset>	
											</div-->
												<!-- cat 4 -->
											
											</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="section " style="padding-top:0px; padding-bottom:10px; ">
								<div class="section_wrapper clearfix">
									<div class="items_group clearfix">
									
										<!-- Page devider -->
					<!-- One full width row-->
				<div class="column one column_divider">
											<hr class="hrmargin_b_40" />
										</div>
				
										<!-- One full width row-->
				<br>
									</div>
								</div>
							</div>
							<div class="section dark " style="padding-top:40px; padding-bottom:0px; background-color:#0067af" >
								<div class="section_wrapper clearfix">
									<div class="items_group clearfix">
										<!-- Two Third (2/3) Column -->
						<div class="column two-third column_column">
											<div class="column_attr " >
												<ul class="flv_list_ul_10">
                                                <li class="flv_list_1">
                                                    <a href="../../index.php">Home</a>
                                                </li>
                                                <li class="flv_list_1">
                                                    <a href="howitwork.php">How it works</a>
                                                </li>
                                                <li class="flv_list_1">
                                                    <a href="newchannel.php">New channel</a>
                                                </li>
                                                <li class="flv_list_1">
                                                    <a href="faq.php">FAQ</a>
                                                </li>
                                                <li class="flv_list_1">
                                                    <a href="contact.php">Contact us</a>
                                                </li>
                                            </ul>
												<p style="margin: 0 0 0 10px;">
													© 2017 YTwizard - BeTheme. Beantownthemes - HTML by <a href="http://themeforest.net/item/betheme-html-responsive-multipurpose-template/13925633?ref=beantownthemes" target="_blank">BeantownThemes</a>
												</p>
											</div>
										</div>
										<!-- One Third (1/3) Column -->
			<div class="column one-third column_image">
											<div class="image_frame no_link scale-with-grid no_border alignright" >
												<div class="image_wrapper"><img class="scale-with-grid" src="images/insurance.png" alt="" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Footer-->
			<footer id="Footer" class="clearfix">
				<!-- Footer copyright-->
			<div class="footer_copy">
					<div class="container">
						<div class="column one">
							<a id="back_to_top" href="#" class="button button_left button_js"><span class="button_icon"><i class="icon-up-open-big"></i></span></a>
							<div class="copyright">
								&copy; 2015 YTwizard - BeTheme. All Rights Reserved. <a target="_blank" rel="nofollow" href="http://themeforest.net/item/betheme-html-responsive-multipurpose-template/13925633?ref=beantownthemes">Beantownthemes</a>
							</div><!--Social info area-->
				<ul class="social"></ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
		<!-- JS -->

		<script type="text/javascript" src="../../js/jquery-2.1.4.min.js"></script>

		<script type="text/javascript" src="../../js/mfn.menu.js"></script>
		<script type="text/javascript" src="../../js/jquery.plugins.js"></script>
		<script type="text/javascript" src="../../js/jquery.jplayer.min.js"></script>
		<script type="text/javascript" src="../../js/animations/animations.js"></script>
		<script type="text/javascript" src="../../js/scripts.js"></script>
		<script type="text/javascript" src="../../js/email.js"></script>

		<script>
			jQuery(window).load(function() {
				var retina = window.devicePixelRatio > 1 ? true : false;
				if (retina) {
					var retinaEl = jQuery("#logo img");
					var retinaLogoW = retinaEl.width();
					var retinaLogoH = retinaEl.height();
					retinaEl.attr("src", "images/retina-insurance.png").width(retinaLogoW).height(retinaLogoH)
				}
			});
		</script>
	</body>
</html>
