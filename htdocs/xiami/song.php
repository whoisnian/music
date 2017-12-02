<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_GET['id'])) {
    $url = "http://api.xiami.com/web?v=2.0&app_key=1&r=song/detail&id=" . $_GET['id'];
    $json = get_by_curl($url, "xiami");
    $song_detail = json_decode($json, true);
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
$song = null;
if ($song_detail && $song_detail["data"]["song"] != 0) {
    $link = $song_detail["data"]["song"]["listen_file"];
    $song = [];
    $song["album"] = [
        "picUrl" => $song_detail["data"]["song"]["logo"],
        "id" => $song_detail["data"]["song"]["album_id"],
        "name" => $song_detail["data"]["song"]["album_name"],
    ];
    $song["artists"] = [["name" => $song_detail["data"]["song"]["artist_name"]]];
    $song["name"] = $song_detail["data"]["song"]["song_name"];
    $song["link"] = $link;
}
if (isset($song["link"])) $song["link"] = str_replace("http://", "https://", $song["link"]);
if (isset($song["album"]["picUrl"])) $song["album"]["picUrl"] = str_replace("http://", "https://", $song["album"]["picUrl"]);

include VIEW_PATH . "/song.php";