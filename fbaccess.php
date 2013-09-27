<?php
//Application Configurations
$app_id		= "Your app id";
$app_secret	= "your app secret";
$site_url	= "url of ur page where you want to implement facebook login";
include_once "src/facebook.php";

// Create our application instance
$facebook = new Facebook(array(
	'appId'		=> $app_id,
	'secret'	=> $app_secret,
	));

// Get User ID
$user = $facebook->getUser();
// We may or may not have this data based 
// on whether the user is logged in.
// If we have a $user id here, it means we know 
// the user is logged into
// Facebook, but we don’t know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if($user){
//==================== Single query method ======================================
	
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me');
	
//==================== Single query method ends =================================
}

if($user){
	// Get logout URL
	$logoutUrl = $facebook->getLogoutUrl();
}else{
	// Get login URL
	$loginUrl = $facebook->getLoginUrl(array(
		'scope'			=> 'email,read_stream,user_about_me,user_interests,user_relationships,user_relationship_details,user_likes, publish_stream, user_birthday, user_location, user_work_history,user_education_history, user_hometown, user_photos',
		'redirect_uri'	=> $site_url,
		));
}

if($user){
	// Proceed knowing you have a logged in user who has a valid session.
	
//========= Batch requests over the Facebook Graph API using the PHP-SDK ========
	// Save your method calls into an array
	$queries = array(
		array('method' => 'GET', 'relative_url' => '/'.$user),
		array('method' => 'GET', 'relative_url' => '/'.$user.'/home?limit=50'),
		array('method' => 'GET', 'relative_url' => '/'.$user.'/friends'),
		array('method' => 'GET', 'relative_url' => '/'.$user.'/movies'),
		array('method' => 'GET', 'relative_url' => '/'.$user.'/music'),
		array('method' => 'GET', 'relative_url' => '/'.$user.'/television'),
		array('method' => 'GET', 'relative_url' => '/'.$user.'/books'),
		array('method' => 'GET', 'relative_url' => '/'.$user.'/photos?limit=6'),
		);

	// POST your queries to the batch endpoint on the graph.
	
		$batchResponse = $facebook->api('?batch='.json_encode($queries), 'POST');
	

	//Return values are indexed in order of the original array, content is in ['body'] as a JSON
	//string. Decode for use as a PHP array.
	$user_info		= json_decode($batchResponse[0]['body'], TRUE);
	$feed			= json_decode($batchResponse[1]['body'], TRUE);
	$friends_list	= json_decode($batchResponse[2]['body'], TRUE);
	$movies			= json_decode($batchResponse[3]['body'], TRUE);
	$music			= json_decode($batchResponse[4]['body'], TRUE);
	$tv			= json_decode($batchResponse[5]['body'], TRUE);
	$books			= json_decode($batchResponse[6]['body'], TRUE);
	$photos			= json_decode($batchResponse[3]['body'], TRUE);
//========= Batch requests over the Facebook Graph API using the PHP-SDK ends =====

	// Update user's status using graph api
	if(isset($_POST['pub'])){
		
			$statusUpdate = $facebook->api("/$user/feed", 'post', array(
				'message'		=> 'Check out FosterZen',
				'link'			=> 'http://fosterzen.com',
				'picture'		=> 'http://fosterzen.com/images/fosterzen.png',
				'name'			=> 'FosterZen | A Link Discovery Platform',
				'caption'		=> 'fosterzen.com',
				'description'	=> 'FosterZen is a link discovery platform',
				));
		
	}

	// Update user's status using graph api
	if(isset($_POST['status'])){
		
			$statusUpdate = $facebook->api("/$user/feed", 'post', array('message'=> $_POST['status']));
		
	}
}
?>