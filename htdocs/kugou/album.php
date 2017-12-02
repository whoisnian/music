<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_GET['id'])) {
    $url = "http://mobilecdn.kugou.com/api/v3/album/song?plat=0&page=1&pagesize=-1&version=8352&albumid=" . $_GET['id'];
    $json = get_by_curl($url, "kugou");
    $album = json_decode($json, true);
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}

$album_raw = $album;
$album = [];
if (array_key_exists("info", $album_raw["data"]) && $album_raw["data"]["total"] > 0) {
    $album["album"] = [];
    $album["album"]["size"] = $album_raw["data"]["total"];
    $album["album"]["songs"] = [];
    foreach ($album_raw["data"]["info"] as $index => $song) {
        $ar = explode(" - ", $song["filename"], 2)[0];
        $ar = explode('、', $ar);
        $artists = [];
        foreach ($ar as $a) {
            array_push($artists, ["name" => $a]);
        }
        $album["album"]["songs"][$index] = [
            'name' => explode(" - ", $song["filename"], 2)[1],
            'artists' => $artists,
            'id' => urlsafe_b64encode(json_encode([
                "hash" => $song["hash"],
                "album_id" => $song["album_id"]
            ]))
        ];
    }
}

include VIEW_PATH . "/album.php";
?>
