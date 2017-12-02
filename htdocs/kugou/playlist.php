<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_GET['id'])) {
    $url = "http://mobilecdn.kugou.com/api/v3/special/song?plat=0&page=1&pagesize=-1&version=8352&specialid=" . $_GET['id'];
    $json = get_by_curl($url, "kugou");
    $playlist = json_decode($json, true);
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
$playlist_raw = $playlist;
$playlist = [];
if ($playlist_raw && array_key_exists("info", $playlist_raw["data"]) && $playlist_raw["data"]["total"] > 0) {
    $playlist["result"] = [];
    $playlist["result"]["trackCount"] = $playlist_raw["data"]["total"];
    $playlist["result"]["tracks"] = [];
    foreach ($playlist_raw["data"]["info"] as $index => $song) {
        $ar = explode(" - ", $song["filename"], 2)[0];
        $ar = explode('、', $ar);
        $artists = [];
        foreach ($ar as $a) {
            array_push($artists, ["name" => $a]);
        }
        $playlist["result"]["tracks"][$index] = [
            "name" => explode(" - ", $song["filename"], 2)[1],
            "artists" => $artists,
            "id" => urlsafe_b64encode(json_encode([
                "hash" => $song["hash"],
                "album_id" => $song["album_id"]
            ]))
        ];
    }
}
include VIEW_PATH . "/playlist.php";