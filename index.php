<?php 

require 'vendor/autoload.php';
require 'config.php';

$session = new SpotifyWebAPI\Session(
    $CLIENT_ID,
    $CLIENT_SECRET,
    'http://localhost/motherPlaylist/'
);

$options = [
    'scope' => [
		'ugc-image-upload',
		'user-read-recently-played',
		'user-top-read',
		'user-read-playback-position',
		'user-read-playback-state',
		'user-modify-playback-state',
		'user-read-currently-playing',
		'app-remote-control',
		'streaming',
		'playlist-modify-public',
		'playlist-modify-private',
		'playlist-read-private',
		'playlist-read-collaborative',
		'user-follow-modify',
		'user-follow-read',
		'user-library-modify',
		'user-library-read',
		'user-read-email',
		'user-read-private'
    ],
	'show_dialog' => true
];


$api = new SpotifyWebAPI\SpotifyWebAPI();
if (isset($_GET['code'])) {
    $session->requestAccessToken($_GET['code']);
    $refreshToken = $session->getRefreshToken();
    $api->setAccessToken($session->getAccessToken());
    include ('html/page.php');
} else {

    header('Location: ' . $session->getAuthorizeUrl($options));
    die();
}