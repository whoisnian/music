<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_GET['id'])) {
    $url = "http://api.xiami.com/web?v=2.0&app_key=1&r=collect/detail&id=" . $_GET["id"];
    $json = get_by_curl($url, "xiami");
    $playlist = json_decode($json, true);
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
$playlist_raw = $playlist;
$playlist = [];
if ($playlist_raw && array_key_exists("songs", $playlist_raw["data"]) && $playlist_raw["data"]["songs_count"] > 0) {
    $playlist["result"] = [];
    $playlist["result"]["trackCount"] = $playlist_raw["data"]["songs_count"];
    $playlist["result"]["tracks"] = [];
    foreach ($playlist_raw["data"]["songs"] as $index => $song) {
        $ar = $song["singers"];
        $ar = explode(';', $ar);
        $artists = [];
        foreach ($ar as $a) {
            array_push($artists, ["name" => $a]);
        }
        $playlist["result"]["tracks"][$index] = [
            "name" => $song["song_name"],
            "artists" => $artists,
            "id" => $song["song_id"]
        ];
    }
}

include VIEW_PATH . "/playlist.php";
