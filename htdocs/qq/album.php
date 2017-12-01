<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_GET['id'])) {
    $url = "http://c.y.qq.com/v8/fcg-bin/fcg_v8_album_info_cp.fcg?inCharset=utf8&outCharset=utf-8&albummid=" . $_GET['id'];
    $json = get_by_curl($url, "qq");
    $album = json_decode($json, true);
    $album_raw = $album;
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}

$album = [];
if (array_key_exists("data", $album_raw) && $album_raw["code"] == 0) {
    $album = [];
    $album["album"] = [];
    $album["album"]["size"] = $album_raw["data"]["total_song_num"];
    $album["album"]["songs"] = [];
    foreach ($album_raw["data"]["list"] as $index => $song) {
        $album["album"]["songs"][$index] = ['name' => $song["songname"], 'artists' => $song["singer"], 'id' => $song["songmid"]];
    }
}
include VIEW_PATH . "/album.php";
?>
