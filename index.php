<?php 

require_once 'content/ytwizard/vendor/autoload.php';

session_start();

/*
 * You can acquire an OAuth 2.0 client ID and client secret from the
 * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
 * For more information about using OAuth 2.0 to access Google APIs, please see:
 * <https://developers.google.com/youtube/v3/guides/authentication>
 * Please ensure that you have enabled the YouTube Data API for your project.
 */
$OAUTH2_CLIENT_ID = '452089079637-cvm4co5gb1954ai86iunp63lb1h3la69.apps.googleusercontent.com'; // Enter your Client ID here
$OAUTH2_CLIENT_SECRET = 'uEeMxi0cCq2jDILASl7M710i'; // Enter your Client Secret here
$REDIRECT = "http://localhost/ytwizard/content/ytwizard/channel.php";
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
  $state = mt_rand();
    $client->setState($state);
	 $_SESSION['state'] = $state;
    $authUrl = $client->createAuthUrl();
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
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Favicons -->
    <link rel="shortcut icon" href="content/ytwizard/images/favicon.png">

    <!-- FONTS -->
    <link rel='stylesheet' id='Roboto-css' href='http://fonts.googleapis.com/css?family=Roboto:100,300,400,400italic,700'>
    <link rel='stylesheet' id='Patua+One-css' href='http://fonts.googleapis.com/css?family=Patua+One:100,300,400,400italic,700'>

    <!-- CSS -->
    <link rel='stylesheet' id='global-css' href='css/global.css'>
    <link rel='stylesheet' id='structure-css' href='content/ytwizard/css/structure.css'>
    <link rel='stylesheet' id='local-css' href='content/ytwizard/css/insurance.css'>
    <link rel='stylesheet' id='custom-css' href='content/ytwizard/css/custom.css'>

</head>

<body class="home page layout-full-width header-classic minimalist-header header-menu-right sticky-header sticky-white subheader-both-center no-content-padding">
    <!-- Main Theme Wrapper -->
    <div id="Wrapper">
        <!-- Header Wrapper -->
        <div id="Header_wrapper">
            <!-- Header -->
            <header id="Header">

                <!-- Header -  Logo and Menu area -->
                <div id="Top_bar">
                    <div class="container">
                        <div class="column one">
                            <div class="top_bar_left clearfix">
                                <!-- Logo-->
                                <div class="logo">
                                    <h1><a id="logo" href="index.php" title="YTwizard - BeTheme"><img class="scale-with-grid" src="content/ytwizard/images/insurance.png" alt="YTwizard - BeTheme" /></a></h1>
                                </div>
                                <!-- Main menu-->
                                <div class="menu_wrapper">
                                    <nav id="menu">
                                        <ul id="menu-main-menu" class="menu">
                                            <li class=" current_page_item">
                                                <a href="index.php"><span><i class="icon-home"></i></span></a>
                                            </li>
                                            <li>
                                                <a href="content/ytwizard/howitwork.php"><span>How it works</span></a>
                                            </li>
                                            <li>
                                                <a href="content/ytwizard/newchannel.php"><span>New channel</span></a>
                                            </li>
                                            <li>
                                                <a href="content/ytwizard/faq.php"><span>FAQ</span></a>
                                            </li>
                                            <li>
                                                <a href="content/ytwizard/contact.php"><span>Contact us</span></a>
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
        </div>
        <!-- Main Content -->
        <div id="Content">
            <div class="content_wrapper clearfix">
                <div class="sections_group">
                    <div class="entry-content">
                        <div class="section column-margin-0px" id="intro" style="padding-top:30px; padding-bottom:0px; ">
                            <div class="section_wrapper clearfix">
                                <div class="items_group clearfix">
                                    <!-- One full width row-->
                                    <div class="column one column_tabs">
                                        <div class="jq-tabs tabs_wrapper tabs_horizontal">
                                      
                                            <div id="-1">
                                                <!-- One Second (1/2) Column -->
                                                <div class="column one-second">
                                                    <hr class="no_line hrmargin_b_40" />
                                                    <h2>Youtube Wizard</h2>
                                                    <hr class="no_line hrmargin_b_30" />
                                                    <h4>Connect your Youtube channel to our system and start receiving PLR videos into your channel for FREE.</h4>
													<h4>We are crawling more than 100 video directories, and our database contient more than 2M videos.</h4>
                                                    <hr class="no_line hrmargin_b_30" />
                                                    <a class="button button_right button_large button_js" href="<?= $authUrl ?>" style=" background-color:#90ce33 !important; color:#fff;"><span class="button_icon"><i class="icon-retweet"></i></span><span class="button_label">Connect your channel</span></a>
                                                </div>
                                                <!-- One Second (1/2) Column -->
                                                <div class="column one-second">
                                                    <div class="image_frame no_link scale-with-grid no_border aligncenter">
                                                        <div class="image_wrapper"><img class="scale-with-grid" src="content/ytwizard/images/image11.png" alt="" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                        </div>
                                    </div>
                                    <!-- One full width row-->
                                    <div class="column one column_column">
                                        <div class="column_attr ">
                                            <div class="dark" style="background: #0168b0; overflow: hidden; padding: 37px 15px;">
                                                <!-- One Fourth (1/4) Column -->
                                                <div class="column one-fourth">
                                                    <h4 style="text-align: right; margin-bottom: 3px;">How it works?</h4>
                                                    <h5 style="text-align: right; margin: 0;">do it in just 3 simple steps</h5>
                                                </div>
                                                <!-- One Fourth (1/4) Column -->
                                                <div class="column one-fourth">
                                                    <div style="background: url(content/ytwizard/images/home_insurance_step_1.png) no-repeat left 6px; padding-left: 85px; margin-top: 6px;">
                                                        <h5 class="hrmargin_0">Connect your Youtube channel.
															</h5>
                                                    </div>
                                                </div>
                                                <!-- One Fourth (1/4) Column -->
                                                <div class="column one-fourth">
                                                    <div style="background: url(content/ytwizard/images/home_insurance_step_2.png) no-repeat left 6px; padding-left: 90px; margin-top: 6px;">
                                                        <h5 class="hrmargin_0">Choose your channel categories.
															</h5>
                                                    </div>
                                                </div>
                                                <!-- One Fourth (1/4) Column -->
                                                <div class="column one-fourth">
                                                    <div style="background: url(content/ytwizard/images/home_insurance_step_3.png) no-repeat left 6px; padding-left: 90px; margin-top: 6px;">
                                                        <h5 class="hrmargin_0">Start receiving new viddeos weekly.</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="section " style="padding-top:30px; padding-bottom:0px; ">
                            <div class="section_wrapper clearfix">
                                <div class="items_group clearfix">
                                    <!-- One Fourth (1/4) Column -->
                                    <div class="column one-fourth column_image">
                                        <div class="image_frame no_link scale-with-grid no_border">
                                            <div class="image_wrapper"><img class="scale-with-grid" src="content/ytwizard/images/home_insurance_question.jpg" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- One Fourth (1/4) Column -->
                                    <div class="column one-fourth column_column">
                                        <div class="column_attr ">
                                            <hr class="no_line hrmargin_b_40" />
                                            <h3>What are available
												video categories ?</h3>
                                            <p class="big" style=" font-size: 126%; text-align: justify; ">
                                               Currently we have only educational content including IT development, design, marketing... Sports vdeios will be disponible soon. Check how it work section for more details.
                                            </p>                                           
                                        </div>
                                    </div>
                                    <!-- One Fourth (1/4) Column -->
                                    <div class="column one-fourth column_image">
                                        <div class="image_frame no_link scale-with-grid no_border">
                                            <div class="image_wrapper"><img class="scale-with-grid" src="content/ytwizard/images/home_insurance_find_agent.jpg" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- One Fourth (1/4) Column -->
                                    <div class="column one-fourth column_column">
                                        <div class="column_attr ">
                                            <hr class="no_line hrmargin_b_40" />
                                            <h3>What 's the pricing for this service?</h3>
                                            <p class="big" style=" font-size: 126%; text-align: justify; ">
                                                Our service are currently 100% FREE with no hidden fees, we are planning to monitize our content by creating a youtube network in the future.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="section " style="padding-top:30px; padding-bottom:10px; ">
                            <div class="section_wrapper clearfix">
                                <div class="items_group clearfix">
                                    <!-- One full width row-->
                                    <div class="column one column_column">
                                        <div class="column_attr align_center">
                                            <div style="padding-left: 80px; background: url(content/ytwizard/images/home_insurance_blockquote_left.png) no-repeat left center; margin: 0 2%;">
                                                <div style="padding-right: 80px; background: url(content/ytwizard/images/home_insurance_blockquote_right.png) no-repeat right center;">
                                                    <h3 style="font-weight: 300;"> Our set and forgot system use artificial intellegence to save you a lot of time & effort.</h3>
													<a class="button button_right button_large button_js kill_the_icon" href="<?= $authUrl ?>" style=" background-color:#90ce33 !important; color:#fff;"><span class="button_icon"><i class="icon-retweet"></i></span><span class="button_label">Connect your channel</span></a>
                                                    <div class="hr_zigzag">
                                                        <i class="icon-down-open"></i><i class="icon-down-open"></i><i class="icon-down-open"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="section " style="padding-top:0px; padding-bottom:10px; ">
                            <div class="section_wrapper clearfix">
                                <div class="items_group clearfix">
                                    <!-- One Third (1/3) Column -->
                                    <div class="column one-second column_column">
                                        <div class="column_attr ">
                                            <h3>Why you use Youtube Wizard ?</h3>
                                            <p class="big">
                                                You can use Youtube Wizard to make money with Youtube partner, increase your channel autority, send traffic to your website...
                                            </p>
                                        </div>
                                    </div>                                 
                                    <!-- One Third (1/3) Column -->
                                    <div class="column one-second column_column">
                                        <div class="column_attr ">
                                            <h3>We love to hear from you !</h3>
                                            <p>
                                                Contact us and we will be happy to answer you as soon as possible.
                                            </p>

                                            <div id="contactWrapper">
                                                <form id="contactform">
                                                    <div class="column one">
                                                        <input placeholder="Your e-mail" type="email" name="email" id="email" size="40" aria-required="true" aria-invalid="false" />
                                                    </div>
                                                    <!-- One Second (1/2) Column -->
                                                    <div class="column one-second">
                                                        <input placeholder="Your first name" type="text" name="name" id="name" size="40" aria-required="true" aria-invalid="false" />
                                                    </div>
                                                    <!-- One Second (1/2) Column -->
                                                    <div class="column one-second">
                                                        <input placeholder="Your last name" type="text" name="subject" id="subject" size="40" aria-invalid="false" />
                                                    </div>

                                                    <div class="column one" style="text-align: right;">
                                                        <input type="button" value="Apply now" id="submit" onClick="return check_values();">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Page devider -->
                                    
                                </div>
                            </div>
                        </div>
                        <div class="section dark " style="padding-top:40px; padding-bottom:0px; background-color:#0067af">
                            <div class="section_wrapper clearfix">
                                <div class="items_group clearfix">
                                    <!-- Two Third (2/3) Column -->
                                    <div class="column two-third column_column">
                                        <div class="column_attr ">
                                            <ul class="flv_list_ul_10">
                                                <li class="flv_list_1">
                                                    <a href="../../index.php">Home</a>
                                                </li>
                                                <li class="flv_list_1">
                                                    <a href="content/ytwizard/howitwork.php">How it works</a>
                                                </li>
                                                <li class="flv_list_1">
                                                    <a href="content/ytwizard/newchannel.php">New channel</a>
                                                </li>
                                                <li class="flv_list_1">
                                                    <a href="content/ytwizard/faq.php">FAQ</a>
                                                </li>
                                                <li class="flv_list_1">
                                                    <a href="content/ytwizard/contact.php">Contact us</a>
                                                </li>
                                            </ul>
                                            <p style="margin: 0 0 0 10px;">
                                                © 2017 YTwizard - All rights resereved
                                            </p>
                                        </div>
                                    </div>
                                    <!-- One Third (1/3) Column -->
                                    <div class="column one-third column_image">
                                        <div class="image_frame no_link scale-with-grid no_border alignright">
                                            <div class="image_wrapper"><img class="scale-with-grid" src="content/ytwizard/images/insurance.png" alt="" />
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
                            &copy; 2015 YTwizard - BeTheme. Muffin group - HTML by <a target="_blank" rel="nofollow" href="http://themeforest.net/item/betheme-html-responsive-multipurpose-template/13925633?ref=beantownthemes">BeantownThemes</a>
                        </div>
                        <!--Social info area-->
                        <ul class="social"></ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- JS -->

    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>

    <script type="text/javascript" src="js/mfn.menu.js"></script>
    <script type="text/javascript" src="js/jquery.plugins.js"></script>
    <script type="text/javascript" src="js/jquery.jplayer.min.js"></script>
    <script type="text/javascript" src="js/animations/animations.js"></script>

    <script type="text/javascript" src="js/ui/jquery-ui.min.js"></script>
    <script>
        jQuery(".jq-tabs").tabs();
    </script>

    <script type="text/javascript" src="js/scripts.js"></script>
    <script type="text/javascript" src="js/email.js"></script>

    <script>
        jQuery(window).load(function() {
            var retina = window.devicePixelRatio > 1 ? true : false;
            if (retina) {
                var retinaEl = jQuery("#logo img");
                var retinaLogoW = retinaEl.width();
                var retinaLogoH = retinaEl.height();
                retinaEl.attr("src", "content/ytwizard/images/retina-insurance.png").width(retinaLogoW).height(retinaLogoH)
            }
        });
    </script>

</body>

</html>