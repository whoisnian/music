<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_POST['playlist'])) {
    $url = "http://c.y.qq.com/soso/fcgi-bin/client_music_search_songlist?page_no=0&num_per_page=30&inCharset=utf8&outCharset=utf-8&format=json&query=" . rawurlencode($_POST['playlist']);
    $json = get_by_curl($url, "qq");
    $playlists = json_decode($json, true);
    $playlists_raw = $playlists;
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}

$playlists = [];
if ($playlists_raw && array_key_exists("data", $playlists_raw) && $playlists_raw["data"]["sum"] > 0) {
    $playlists['result'] = [];
    $playlists["result"]["playlistCount"] = $playlists_raw["data"]["sum"];
    $playlists["result"]["playlists"] = [];
    foreach ($playlists_raw["data"]["list"] as $index => $playlist) {
        $playlists["result"]["playlists"][$index] = [
            "id" => $playlist["dissid"],
            "name" => $playlist["dissname"],
            "creator" => ["nickname" => $playlist["creator"]["name"]],
            "trackCount" => $playlist["song_count"]
        ];
    }
}
include VIEW_PATH . "/playlists.php";
?>
