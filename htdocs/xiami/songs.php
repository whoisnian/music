<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_POST['song'])) {
    $url = "http://api.xiami.com/web?v=2.0&app_key=1&page=1&limit=99&r=search/songs&key=" . rawurlencode($_POST['song']);
    $json = get_by_curl($url, "xiami");
    $songs = json_decode($json, true);
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
$songs_raw = $songs;
$songs = [];
if ($songs_raw && array_key_exists("songs", $songs_raw["data"]) && $songs_raw["data"]["total"] > 0) {
    $songs["result"] = [];
    $songs["result"]["songCount"] = $songs_raw["data"]["total"];
    $songs["result"]["songs"] = [];
    foreach ($songs_raw["data"]["songs"] as $index => $song) {
        $songs["result"]["songs"][$index] = [
            "name" => $song["song_name"],
            "artists" => [["name" => $song["artist_name"]]],
            "id" => $song["song_id"]
        ];
    }
}

include VIEW_PATH . "/songs.php";
