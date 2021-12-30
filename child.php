<?php 

require 'vendor/autoload.php';
require 'config.php';

$session = new SpotifyWebAPI\Session(
    $CLIENT_ID,
    $CLIENT_SECRET,
    'http://localhost/motherPlaylist/'
);

if (!isset($_POST['motherlink']) && !isset($_POST['childlink']) && !isset($_POST['number'])){
    die();
}

$api = new SpotifyWebAPI\SpotifyWebAPI();
if (isset($_POST['code'])) {

    $session->refreshAccessToken($_POST['refresh']);
    $accessToken = $session->getAccessToken();
    $refreshToken = $session->getRefreshToken();
    $api->setAccessToken($accessToken);

    $motherlink = $_POST['motherlink'];
    $childlink = $_POST['childlink'];
    $number = $_POST['number'];

    $ml = substr(substr($motherlink, 34),0, -20);
    $cl = substr(substr($childlink, 34),0, -20);
    $n = $number;

        $playlistTracks = $api->getPlaylistTracks($ml);
        $musics = array( );

        foreach ($playlistTracks->items as $track) {
            $track = $track->track;
            $musics[$track->id] = $track->id;
        } 
        $random = array_rand($musics, $n);
        $api->replacePlaylistTracks($cl, $random);

        $birthedChild = $api->getPlaylist($cl);

        $birthedChildImage = $api->getPlaylistImage($cl);
        $image = (array)$birthedChildImage[0];

        $birthedChildTracks = $api->getPlaylistTracks($cl);
        include ('html/child.php');
   
} else {
    header('Location: ' . $session->getAuthorizeUrl($options));
    die();
}