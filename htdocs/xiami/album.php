<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_GET['id'])) {
    $url = "http://api.xiami.com/web?v=2.0&app_key=1&r=album/detail&id=" . $_GET["id"];
    $json = get_by_curl($url, "xiami");
    $album = json_decode($json, true);
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
$album_raw = $album;
$album = [];
if ($album_raw && array_key_exists("songs", $album_raw["data"]) && $album_raw["data"]["song_count"] > 0) {
    $album["album"] = [];
    $album["album"]["size"] = $album_raw["data"]["song_count"];
    $album["album"]["songs"] = [];
    foreach ($album_raw["data"]["songs"] as $index => $song) {
        $ar = $song["singers"];
        $ar = explode(';', $ar);
        $artists = [];
        foreach ($ar as $a) {
            array_push($artists, ["name" => $a]);
        }
        $album["album"]["songs"][$index] = [
            'name' => $song["song_name"],
            'artists' => $artists,
            'id' => $song["song_id"]
        ];
    }
}
include VIEW_PATH . "/album.php";
