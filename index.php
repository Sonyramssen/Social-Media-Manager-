<?php

    include 'defines.php';

    // load graph-sdk files
    require_once __DIR__ . '/vendor/autoload.php';
    

    // facebook credentials array
    $creds = array(
        'app_id' => FACEBOOK_APP_ID,
        'app_secret' => FACEBOOK_APP_SECRET,
        'default_graph_version' => 'v3.2',
        'persistent_data_handler' => 'session'
    );

    // create facebook object
    $facebook = new Facebook\Facebook( $creds );

    // helper
    $helper = $facebook->getRedirectLoginHelper();

    // oauth object
    $oAuth2Client = $facebook->getOAuth2Client();

    if ( isset( $_GET['code'] ) ) { // get access token
        try {
            $accessToken = $helper->getAccessToken();
        } catch ( Facebook\Exceptions\FacebookResponseException $e ) { // graph error
            echo 'Graph returned an error ' . $e->getMessage();
        } catch ( Facebook\Exceptions\FacebookSDKException $e ) { // validation error
            echo 'Facebook SDK returned an error ' . $e->getMessage();
        }

        if ( !$accessToken->isLongLived() ) { // exchange short for long
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken( $accessToken );
            } catch ( Facebook\Exceptions\FacebookSDKException $e ) {
                echo 'Error getting long lived access token ' . $e->getMessage();
            }
        }

        echo '<pre>';
        #var_dump( $accessToken );

        $accessToken = (string) $accessToken;
       # echo '<h1>Long Lived Access Token</h1>';
       # print_r( $accessToken );

        $endpointFormat = ENDPOINT_BASE . 'me/accounts?access_token={access-token}';
	$pagesEndpoint = ENDPOINT_BASE . 'me/accounts';

	// endpoint params
	$pagesParams = array(
		'access_token' => $accessToken
	);

	// add params to endpoint
	$pagesEndpoint .= '?' . http_build_query( $pagesParams );

	// setup curl
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $pagesEndpoint );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

	// make call and get response
	$response = curl_exec( $ch );
	curl_close( $ch );
	$responseArray = json_decode( $response, true );
	unset( $responseArray['data'][0]['access_token'] );
   # echo '<h1>Endpoint</h1>';
    #    print_r( $endpointFormat );
    #echo '<h1>Facebook Page</h1>';
     #   print_r( $responseArray['data'][0]['name'] );    
    #echo '<h1>Page ID: </h1>';
        #print_r( $responseArray['data'][0]['id'] );
    #echo '<h1>Username: </h1>';
     #   print_r( $responseArray ['data'][1]['name']); 
    $instagramUsername=$responseArray ['data'][1]['name'];
    $pageId=$responseArray['data'][0]['id'];

        $endpointFormat = ENDPOINT_BASE . '{page-id}?fields=instagram_business_account&access_token={access-token}';
        $instagramAccountEndpoint = ENDPOINT_BASE . $pageId;
    
        // endpoint params
        $igParams = array(
            'fields' => 'instagram_business_account',
            'access_token' => $accessToken
        );
    
        // add params to endpoint
        $instagramAccountEndpoint .= '?' . http_build_query( $igParams );
    
        // setup curl
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $instagramAccountEndpoint );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    
        // make call and get response
        $response = curl_exec( $ch );
        curl_close( $ch );
        $responseArray = json_decode( $response, true );
    
   # echo '<h1>Endpoint</h1>';
    #    print_r( $endpointFormat );
    #echo '<h1>Instagram Business Account Id:</h1>';
     #   print_r( $responseArray['instagram_business_account']['id'] ); 
    $instagramUserID= $responseArray['instagram_business_account']['id'];  
    #echo '<h1>Facebook Page ID: </h1>';
     #   print_r( $responseArray['id'] );    
		


     $endpointFormat = ENDPOINT_BASE . '{ig-user-id}?fields=business_discovery.username({ig-username}){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count,media{caption,like_count,comments_count,media_url,permalink,media_type}}&access_token={access-token}';
     $endpoint = ENDPOINT_BASE . $instagramUserID;
 
 
     // endpoint params
     $igParams = array(
         'fields' => 'business_discovery.username(' . $instagramUsername . '){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count,media{caption,like_count,comments_count,media_url,permalink,media_type}}',
         'access_token' => $accessToken
     );
 
     // add params to endpoint
     $endpoint .= '?' . http_build_query( $igParams );
 
     // setup curl
     $ch = curl_init();
     curl_setopt( $ch, CURLOPT_URL, $endpoint );
     curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
     curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
     curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
 
     // make call and get response
     $response = curl_exec( $ch );
     curl_close( $ch );
     $responseArray = json_decode( $response, true );  
    $maxlikes=0;
    $maxlikesURL='';
    $maxcomment=0;
    $maxcommentURL='';
    foreach($responseArray['business_discovery']['media']['data'] as $media) {
        if (isset($media['like_count'])) {
        $like_count = intval($media['like_count']);
        if ($maxlikes<$like_count){
            $maxlikes=$like_count;
            $maxlikesURL=$media['media_url'];
        }
    }
        if (isset($media['comments_count'])){
            $comment_count = intval($media['comments_count']); 
            if ($maxcomment<$comment_count){
                $maxcomment=$comment_count;
                $maxcommentURL=$media['media_url'];
            }

        }
    }


    # max likes 
    #echo $maxlikes . "\n";
    #echo $maxlikesURL. "\n";
    echo '<div style="display:flex; justify-content: center;">';
echo '<div style="position:relative; padding-right: 70px;">';
echo '<img src="' . $maxlikesURL . '" alt="Likes Image" width="400" height="400">';
echo '<div style="position:absolute; top:0; le  ft:0; background-color:black; color:white; padding:5px;">Most liked</div>'; // Adds text overlay to the first image
echo '</div>';
echo '<div style="position:relative; padding-right: 70px;">';
echo '<img src="' . $maxcommentURL . '" alt="Comments Image" width="400" height="400">';
echo '<div style="position:absolute; top:0; left:0; background-color:black; color:white; padding:5px;">Most commented</div>'; // Adds text overlay to the second image
echo '</div>';
echo '<div style="position:relative;">';
echo '<img src="' . $maxcommentURL . '" alt="Impressions Image" width="400" height="400">';
echo '<div style="position:absolute; top:0; left:0; background-color:black; color:white; padding:5px;">Most impressions</div>'; // Adds text overlay to the third image
echo '</div>';
echo '</div>';

    


    echo '<h1>Response Array   : </h1>';
       print_r( $responseArray );
    # max comments 
   # echo $maxcomment . "\n";
    #echo $maxcommentURL. "\n";


    } 
    
    
    
    
    
    
    
    
    else 
    { // display login url
        $permissions = [
            'business_management',
            'instagram_basic', 
            'instagram_manage_insights', 
            'instagram_manage_comments', 
            'instagram_content_publish',
            'instagram_manage_messages',
            'public_profile'
            
             
        ];  
        $loginUrl = $helper->getLoginUrl( FACEBOOK_REDIRECT_URI, $permissions );
    
        echo '<a href="' . $loginUrl . '">
            Authorize with Instagram
        </a>';
        
    }

    