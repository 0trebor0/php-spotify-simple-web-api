<?php
function GetToken(){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://accounts.spotify.com/api/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,"grant_type=authorization_code&code=".$_GET['code']."&redirect_uri=http://localhost/spotify-api/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '.base64_encode('CLIENTID'.':'.'CLIENTSECRET'))); 
    $server = json_decode(curl_exec ($ch),true);
    curl_close ($ch);
    print_r($server);
    header("Location: http://localhost/spotify-api/index.php?access_token=".$server['access_token']."&refresh_token=".$server['refresh_token']);
}
function GetUserDetail(){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.spotify.com/v1/me");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_GET['access_token'])); 
    $server = json_decode(curl_exec ($ch),true);
    curl_close ($ch);
    print_r($server);
}
function GetUserPlaylist(){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.spotify.com/v1/me/playlists");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_GET['access_token'])); 
    $server = json_decode(curl_exec ($ch),true);
    curl_close ($ch);
    print_r($server);
}
if(empty($_GET)){
    echo"<a href='https://accounts.spotify.com/authorize?client_id=YOURCLIENTID&response_type=code&redirect_uri=YOUREDIRECTURL&scope=user-read-private%20user-read-email'>Log In</a>";
}else if(isset($_GET['code'])&!empty($_GET['code'])){
    GetToken();
}else if(isset($_GET['access_token'])&!empty($_GET['access_token'])){
    GetUserDetail();
    echo"<br>";
    GetUserPlaylist();
}
