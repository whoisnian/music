<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_POST['playlist'])) {
    $url = "http://specialsearch.kugou.com/special_search?platform=WebFilter&page=1&pagesize=99&iscorrection=1&keyword=" . rawurlencode($_POST['playlist']);
    $json = get_by_curl($url, "kugou");
    $playlists = json_decode($json, true);
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
$playlists_raw = $playlists;
$playlists = [];
if ($playlists_raw && array_key_exists("lists", $playlists_raw["data"]) && $playlists_raw["data"]["total"] > 0) {
    $playlists['result'] = [];
    $playlists["result"]["playlistCount"] = $playlists_raw["data"]["total"];
    $playlists["result"]["playlists"] = [];
    foreach ($playlists_raw["data"]["lists"] as $index => $playlist) {
        $playlists["result"]["playlists"][$index] = [
            "id" => $playlist["specialid"],
            "name" => $playlist["specialname"],
            "creator" => ["nickname" => $playlist["nickname"]],
            "trackCount" => $playlist["song_count"]
        ];
    }
}
include VIEW_PATH . "/playlists.php";
?>
