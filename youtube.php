<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '/Applications/XAMPP/xamppfiles/htdocs/SWEProject/vendor/autoload.php';

use Google\Service\YouTubeAnalytics;

$client = new Google_Client();
$analytics = new YouTubeAnalytics($client);
$client->setClientId('689943046412-rmfbi3bf2fa3dj2mitc71plo766k7p30.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('https://localhost/SWEPROJECT/youtube.php');

$client->addScope(YouTubeAnalytics::YT_ANALYTICS_READONLY);

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $accessToken = $token['access_token'];
    $refreshToken = $token['refresh_token'];
    $client->setAccessToken($accessToken);
}

if ($client->getAccessToken()) {
    $youtubeAnalytics = new YouTubeAnalytics($client);

    // Define the parameters for the API request
    $params = array(
        'ids' => 'UCFzLu9ipnbh6dN_lFLWxo2Q',
        'start-date' => '2023-04-01',
        'end-date' => '2023-04-23',
        'metrics' => 'views,likes,dislikes',
        'dimensions' => 'video'
    );

    // Call the API and retrieve the analytics data
    $response = $youtubeAnalytics->reports->query($params);

    // Print the analytics data
    if (!empty($response->getRows())) {
        foreach ($response->getRows() as $row) {
            echo 'Video: ' . $row[0] . '<br>';
            echo 'Views: ' . $row[1] . '<br>';
            echo 'Likes: ' . $row[2] . '<br>';
            echo 'Dislikes: ' . $row[3] . '<br>';
            echo '<br>';
        }
    } else {
        echo 'No data available.';
    }
} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit;
}