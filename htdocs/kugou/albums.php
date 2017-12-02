<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_POST['album'])) {
    $url = "http://mobilecdn.kugou.com/api/v3/search/album?page=1&pagesize=99&keyword=" . rawurlencode($_POST['album']);
    $json = get_by_curl($url, "kugou");
    $albums = json_decode($json, true);
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
$albums_raw = $albums;
$albums["result"] = [];
if (array_key_exists("info", $albums_raw["data"]) && $albums_raw["data"]["total"] > 0) {
    $albums["result"]["albumCount"] = $albums_raw["data"]["total"];
    $albums["result"]["albums"] = [];
    foreach ($albums_raw["data"]["info"] as $index => $album) {
        $albums["result"]["albums"][$index] = [
            "id" => $album["albumid"],
            "publishTime" => strtotime(explode(" ", $album["publishtime"], 2)[0]) * 1000,
            "name" => $album["albumname"],
            "artist" => ["name" => $album["singername"]],
        ];
    }
}

include VIEW_PATH . "/albums.php";
?>
