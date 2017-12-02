<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_POST['song'])) {
    $url = "http://songsearch.kugou.com/song_search_v2?platform=WebFilter&page=1&pagesize=99&iscorrection=1&keyword=" . rawurlencode($_POST['song']);
    $json = get_by_curl($url, "kugou");
    $songs = json_decode($json, true);
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
$songs_raw = $songs;
$songs = [];
if (array_key_exists("lists", $songs_raw["data"]) && $songs_raw["data"]["total"] > 0) {
    $songs["result"] = [];
    $songs["result"]["songCount"] = $songs_raw["data"]["total"];
    $songs["result"]["songs"] = [];
    foreach ($songs_raw["data"]["lists"] as $index => $song) {
        $ar = $song["SingerName"];
        $ar = explode('、', $ar);
        $artists = [];
        foreach ($ar as $a) {
            array_push($artists, ["name" => $a]);
        }
        $songs["result"]["songs"][$index] = [
            "name" => $song["SongName"],
            "artists" => $artists,
            "id" => urlsafe_b64encode(json_encode([
                "hash" => $song["FileHash"],
                "album_id" => $song["AlbumID"]
            ]))
        ];
    }
}
include VIEW_PATH . "/songs.php";
?>
