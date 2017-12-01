<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if(isset($_GET['id'])) {
    $url = "https://music.163.com/api/song/detail/?id=".$_GET['id']."&ids=[".$_GET['id']."]";
    $json = get_by_curl($url, "163");
    $song_detail = json_decode($json, true);

    // Get lyric of the song
    // $url = "http://music.163.com/api/song/media?id=".$_GET['id'];
    // $lyric = json_decode(get_by_curl($url), true)["lyric"];

    // Thanks to https://github.com/maicong/music/blob/master/music.php
    $other_url = "https://music.163.com/api/song/enhance/player/url?ids=[".$_GET['id']."]&br=320000";
    $other_json = get_by_curl($other_url, "163");
    $other_link = json_decode($other_json, true);
}
else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}

$song = null;
if($song_detail["songs"] != NULL && $song_detail["code"] == 200) {
    if ($other_link["data"][0]["url"] != NULL) {
        $song = $song_detail["songs"][0];
        $song['link'] = $other_link["data"][0]["url"];
    } else {
        $url = "https://music.163.com/api/album/" . $song_detail["songs"][0]["album"]["id"] . "?id=" . $song_detail["songs"][0]["album"]["id"];
        $json = get_by_curl($url, "163");
        $album = json_decode($json, true);
        foreach ($album["album"]["songs"] as $s) {
            if ($s["id"] == $_GET['id']) {
                if ($s["hMusic"]["dfsId"] != NULL && $s["hMusic"]["dfsId"] != 0) {
                    $s["link"] = "https://p2.music.126.net/" . encrypt_id($s["hMusic"]["dfsId"]) . "/" . $s["hMusic"]["dfsId"] . ".mp3";
                } else if ($s["mMusic"]["dfsId"] != NULL && $s["mMusic"]["dfsId"] != 0) {
                    $s["link"] = "https://p2.music.126.net/" . encrypt_id($s["mMusic"]["dfsId"]) . "/" . $s["mMusic"]["dfsId"] . ".mp3";
                } else if ($s["bMusic"]["dfsId"] != NULL && $s["bMusic"]["dfsId"] != 0) {
                    $s["link"] = "https://p2.music.126.net/" . encrypt_id($s["bMusic"]["dfsId"]) . "/" . $s["bMusic"]["dfsId"] . ".mp3";
                } else if (array_key_exists("mp3Url", $s) && $s["mp3Url"] != null) {
                    $s["link"] = str_replace("http://m2", "http://p2", $s["mp3Url"]);
                }
                $song = $s;
                break;
            }
        }
    }
}
if(isset($song["link"])) $song["link"] = str_replace("http://", "https://", $song["link"]);
if(isset($song["album"]["picUrl"])) $song["album"]["picUrl"] = str_replace("http://", "https://", $song["album"]["picUrl"]);
include VIEW_PATH . "/song.php";
?>
