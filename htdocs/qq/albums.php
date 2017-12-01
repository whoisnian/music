<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_POST['album'])) {
    $url = "http://c.y.qq.com/soso/fcgi-bin/client_search_cp?t=8&p=1&n=30&inCharset=utf8&outCharset=utf-8&format=json&w=" . rawurlencode($_POST['album']);
    $json = get_by_curl($url, "qq");
    $albums = json_decode($json, true);
    $albums_raw = $albums;
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}

if (array_key_exists("data", $albums_raw) && $albums_raw["data"]["album"]["totalnum"] > 0) {
    $albums["result"] = [];
    $albums["result"]["albumCount"] = $albums_raw["data"]["album"]["totalnum"];
    $albums["result"]["albums"] = [];
    foreach ($albums_raw["data"]["album"]["list"] as $index => $album) {
        $albums["result"]["albums"][$index] = [
            "id" => $album["albumMID"],
            "publishTime" => strtotime($album["publicTime"]),
            "name" => $album["albumName"],
            "artist" => ["name" => $album["singerName"]],
        ];
    }
}
include VIEW_PATH . "/albums.php"
?>
