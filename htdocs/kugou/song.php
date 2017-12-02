<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_GET['id'])) {
    $id = json_decode(urlsafe_b64decode($_GET['id']), true);
    $url = "http://www.kugou.com/yy/index.php?r=play/getdata&hash=" . $id['hash'] . "&album_id=" . $id['album_id'];
    $json = get_by_curl($url, "kugou");
    $song_detail = json_decode($json, true);
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
$song = null;
if ($song_detail["data"] != NULL && $song_detail["status"] == 1) {
    $link = $song_detail["data"]["play_url"];
    $song = [];
    $song["album"] = [
        "picUrl" => $song_detail["data"]["img"],
        "id" => $song_detail["data"]["album_id"],
        "name" => $song_detail["data"]["album_name"],
    ];
    $ar = $song_detail["data"]["author_name"];
    $ar = explode('、', $ar);
    $artists = [];
    foreach ($ar as $a) {
        array_push($artists, ["name" => $a]);
    }
    $song["artists"] = $artists;
    $song["name"] = $song_detail["data"]["song_name"];
    $song["link"] = $link;

}
include VIEW_PATH . "/song.php"
?>
