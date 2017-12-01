<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_GET['id'])) {
    $url = "https://c.y.qq.com/qzone/fcg-bin/fcg_ucc_getcdinfo_byids_cp.fcg?inCharset=utf8&outCharset=utf-8&format=json&type=1&disstid=" . $_GET['id'];
    $json = get_by_curl($url, "qq");
    $playlist = json_decode($json, true);
    $playlist_raw = $playlist;
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}

$playlist = [];
if (array_key_exists("cdlist", $playlist_raw) && $playlist_raw["cdlist"][0]["total_song_num"] > 0) {
    $playlist["result"] = [];
    $playlist["result"]["trackCount"] = $playlist_raw["cdlist"][0]["total_song_num"];
    $playlist["result"]["tracks"] = [];
    foreach ($playlist_raw["cdlist"][0]["songlist"] as $index => $song) {
        $playlist["result"]["tracks"][$index] = [
            "name" => $song["songname"],
            "artists" => $song["singer"],
            "id" => $song["songmid"]
        ];
    }
}
include VIEW_PATH . "/playlist.php";
?>
