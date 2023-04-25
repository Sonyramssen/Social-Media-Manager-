<?php
	session_start();

	define( 'FACEBOOK_APP_ID', '231702019306659' );
	define( 'FACEBOOK_APP_SECRET', 'd4f4346ac7045469d001d61022973522' );
	define( 'FACEBOOK_REDIRECT_URI', 'https://localhost/pythonIG/index.php' );
	define( 'ENDPOINT_BASE', 'https://graph.facebook.com/v5.0/' );

	// access token 
	$accessToken='';

	// pageid 
	$pageId='';

	//insta account id
	$instagramAccountId='';