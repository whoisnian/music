<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_POST['song'])) {
    $url = "http://c.y.qq.com/soso/fcgi-bin/client_search_cp?new_json=1&cr=1&p=1&n=30&inCharset=utf8&outCharset=utf-8&format=json&w=" . rawurlencode($_POST['song']);
    $json = get_by_curl($url, "qq");
    $songs = json_decode($json, true);
    $songs_raw = $songs;
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}

$songs = [];
if (array_key_exists("data", $songs_raw) && $songs_raw["data"]["song"]["totalnum"] > 0) {
    $songs["result"] = [];
    $songs["result"]["songCount"] = $songs_raw["data"]["song"]["totalnum"];
    $songs["result"]["songs"] = [];
    foreach ($songs_raw["data"]["song"]["list"] as $index => $song) {
        $songs["result"]["songs"][$index] = [
            "name" => $song["name"],
            "artists" => $song["singer"],
            "id" => $song["mid"]
        ];
    }
}
include VIEW_PATH . "/songs.php"
?>
