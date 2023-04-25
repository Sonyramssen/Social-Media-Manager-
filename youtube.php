<?php 
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
        'ids' => 'channel==UCFzLu9ipnbh6dN_lFLWxo2Q',
        'startDate' => '2016-04-01',
        'endDate' => '2023-04-23',
        'metrics' => 'views,likes,dislikes',
        'dimensions' => 'day',
    );

    // Call the API and retrieve the analytics data
    $response = $youtubeAnalytics->reports->query($params);

    // Print the analytics data
    if (!empty($response->getRows())) {
        echo '<table style="border-collapse: collapse; width: 100%;">';
        echo '<tr>';
        echo '<th style="border: 1px solid #ddd; padding: 8px;">Video</th>';
        echo '<th style="border: 1px solid #ddd; padding: 8px;">Views</th>';
        echo '<th style="border: 1px solid #ddd; padding: 8px;">Likes</th>';
        echo '<th style="border: 1px solid #ddd; padding: 8px;">Dislikes</th>';
        echo '</tr>';
        foreach ($response->getRows() as $row) {
            echo '<tr>';
            echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row[0] . '</td>';
            echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row[1] . '</td>';
            echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row[2] . '</td>';
            echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row[3] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'There is nothing in this channel';
    }
} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit;
}
