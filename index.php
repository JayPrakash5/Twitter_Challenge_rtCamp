<?php

/* 
 * CODE BREAKDOWN
 *   PART 1 - DEFINING (loads files,global constants,session enabling)
 *   PART 2 - PROCESS ( check for logout,user session,call back request ) 
 *   PART 3 - FRONT END (display login url or user data)
 *
 */

/* 
 * PART 1 - DEFINING 
 */

// Load the library files
require_once('twitteroauth/OAuth.php');
require_once('twitteroauth/twitteroauth.php');
// define the consumer key and secet and callback
define('CONSUMER_KEY', 'khfkQkuejPbXdFIgWzD4EslJm');
define('CONSUMER_SECRET', 'aCwzeM239ZIlbaU5p25ukN9Uw5kmI4UKvlVSD97VQjnZ24cEob');
define('OAUTH_CALLBACK', 'https://jayprakash56287.000webhostapp.com/');
// start the session
session_start();

/* 
 * PART 2 - PROCESS
 * 1. check for logout
 * 2. check for user session  
 * 3. check for callback
 */

// 1. to handle logout request
if(isset($_GET['logout'])){
	//unset the session
	session_unset();
	// redirect to same page to remove url paramters
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  	header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}


// 2. if user session not enabled get the login url
if(!isset($_SESSION['data']) && !isset($_GET['oauth_token'])) {
	// create a new twitter connection object
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	// get the token from connection object
	$request_token = $connection->getRequestToken(OAUTH_CALLBACK); 
	// if request_token exists then get the token and secret and store in the session
	if($request_token){
		$token = $request_token['oauth_token'];
		$_SESSION['request_token'] = $token ;
		$_SESSION['request_token_secret'] = $request_token['oauth_token_secret'];
		// get the login url from getauthorizeurl method
		$login_url = $connection->getAuthorizeURL($token);
	}
}

// 3. if its a callback url
if(isset($_GET['oauth_token']))
{
	// create a new twitter connection object with request token
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['request_token'], $_SESSION['request_token_secret']);

	// get the access token from getAccesToken method
	$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
	if($access_token)
	{	
		// create another connection object with access token
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	
		// set the parameters array with attributes include_entities false
		$params =array('include_entities'=>'false');

		// get the data
		$data = $connection->get('account/verify_credentials',$params);
		if($data)
		{
			// store the data in the session
			$_SESSION['data']=$data;

                        //getting statuses from users timeline and storing it in session for further use to display
                        $statuses = $connection->get("statuses/home_timeline", ["count" => 11, "exclude_replies" => true]);
                        $_SESSION['statuses']=$statuses;

                        //getting followers
	                $follower = $connection->get("followers/list", ["cursor"=>-1, "screen_name"=>$data->screen_name, "include_user_entries"=>false, "count"=>10]);
                        $_SESSION['followers']=$follower;

			// redirect to same page to remove url parameters
			$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  			header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
		}
	}
}

/* 
 * PART 3 - FRONT END 
 *  - if userdata available then print data
 *  - else display the login url
*/

if(isset($login_url) && !isset($_SESSION['data']))
{
	// echo the login url
        echo '<div align="center">';
        echo '<hr width="100%" size="7" style="background-color: black;">';
        echo '<h1>Twitter Timeline Challenge</h2>';
        echo '<hr width="100%" size="7" style="background-color: black;">';
        echo '</div>';

      
        echo '<h2 align="center"><br><br><br><br>Please Login with Twitter</h2>';
        echo '<div id="wrap">';
        echo '<div id="content">';  	
        echo "<a href='$login_url' class='button'><span>LOGIN</span></a>";
        echo '</div>';echo '</div>';
        
}
else
{
	// get the data stored from the session
	$data = $_SESSION['data'];
	// echo the name username and photo
	
// echo the logout button
echo '<hr width="100%" size="5" style="background-color: black;">';
echo '<div id="wrap1">';
echo '<div id="content1">';
echo '<a href="?logout=true" class="buttonlogout"><span>Logout</span></a>';
echo '</div>';echo '</div>';
/*echo '<h3><div style="background-color:black; color:36d636; height:25px; width:230px; padding:5px 10px 5px 10px; border:2px solid green; margin: 0 auto;">!!! Successfully Logged in !!!</h3></div>';*/
echo '<hr width="100%" size="5" style="background-color: black;">';
        
        echo '<div align="center">';
        echo '<br><img src="'.$data->profile_image_url. '" width="100" height="100"><br><br>';
	echo "<b>Logged in as : </b>".$data->name;
	echo "<br><br><b>Username : </b>".$data->screen_name;
        echo "<br><br><b>Your Recent Tweet : </b>".$data->status->text;
	echo "<br><br><b>Your Total Tweets : </b>". $data->statuses_count;
        echo "</div><br>";

	require 'slider.php';
        
        //accessing session of statuses from users timeline and displaying it here
        $statuses = $_SESSION['statuses'];
        $totalTweets[] = $statuses;
        $start = 0;
        foreach($totalTweets as $page)
        {
            foreach($page as $key)
            {
                        $arr_name[$start] = $key->user->name;
			$arr_tweet[$start] = $key->text;               
                        //echo $start+1 . ' : ' .$key->text . '<br><br>';
               $start++;
            }
         }     

    $_SESSION['user_name_arr'] = $arr_name;
    $_SESSION['tweets_arr'] = $arr_tweet;   

        //accessing the user's followers from users timeline and displaying it here
        $followers = $_SESSION['followers'];
        $followers_arr[] = $followers;
        $start1 = 0;
        foreach($followers->users as $i)
        {
			$ayy[$start1] = $i->screen_name;                
			$start1++;
	}
        $_SESSION['followers_ayy'] = $ayy;

}

?>
<body style="background: url(images/backgroundimage.jpg);">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
<link rel="stylesheet" type="text/css" href="css/button.css"/>
<link rel="stylesheet" href="css/bootsrap/bootstrap.min.css"/>
</head>
<script src = "https://code.jquery.com/js_jquery.js"></script>
<script src = "css/js/bootstrap.min.js"></script>