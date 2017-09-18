<?php
session_start();
require_once __DIR__ . '/../dao/Channel.php';
require_once __DIR__ . '/../dao/Category.php';
require_once __DIR__ . '/../dao/Post.php';
require_once __DIR__ . '/functions.php';

// step 1 : Get suitable channels :
$activeChannels = Channel::getActiveChannelList() ;
// --- Selected channel
if(sizeof($activeChannels)>0){
		$selectedChannelID = $activeChannels[0]["id"] ;
		//Get Selected Channel categorie :

		$channelsCatList = Category::getCategoriesChannel($selectedChannelID) ;
		if(sizeof($channelsCatList)>0){
			$i = mt_rand(0,sizeof($channelsCatList)) ;
			$selectedCatID = $channelsCatList[$i]["id"] ;
			$lisPosts = Post::getPosts($selectedCatID) ;
			// if the list of article not empty
			if(sizeof($lisPosts)>0){
				//find post who have a videos:	
				for($j=0; $j<sizeof($lisPosts); $j++){
					$selectePost = $lisPosts[$j] ;
					if(!empty($selectePost["link"])){
						$videos = Utils::getVideosFromLink($link);
						$_SESSION["data"]["videos"] = $videos ;
						break ;
					}else{
						continue ;
					}	
				}	
 
			}else{
			// add new posts to list:
			$listIdPosts = getAllCategoryPosts($catID);
			foreach($listIdPost as $post){
			//$id=27080;
				$link = "https://www.udemy.com/".$post['id']."/preview/";
				// add all addpost parametrer ...
				addPost($link);			
			}

			}
		}else{
		echo "no Category available for this channel" ;	
		}
		//***********
}else{
echo "no active channels found" ;	
}
header("Location : spider.php");
