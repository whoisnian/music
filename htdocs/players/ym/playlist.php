<?php
include '../../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_GET['src']))
    $src = $_GET['src'];
else
    $src = "qq";
switch ($src) {
    case "netease":
        include FUNC_PATH . "/netease.php";
        if (isset($_GET['id'])) {
            $playlist = Netease::get_playlist($_GET['id']);
        } else {
            $playlist = Netease::get_playlist(473863468);
        }
        $songs = [];
        foreach ($playlist["result"]["tracks"] as $index => $song) {
            $song = Netease::get_song($song["id"]);
            array_push($songs, $song);
        }
        break;
    case "qq":
        include FUNC_PATH . "/qq.php";
        if (isset($_GET['id'])) {
            $playlist = QQ::get_playlist($_GET['id']);
        } else {
            $playlist = QQ::get_playlist(2330317817);
        }
        $songs = [];
        foreach ($playlist["result"]["tracks"] as $index => $song) {
            $song = QQ::get_song($song["id"]);
            array_push($songs, $song);
        }
        break;
    case "kugou":
        include FUNC_PATH . "/kugou.php";
        if (isset($_GET['id'])) {
            $playlist = Kugou::get_playlist($_GET['id']);
        } else {
            $playlist = Kugou::get_playlist(41111);
        }
        $songs = [];
        foreach ($playlist["result"]["tracks"] as $index => $song) {
            $song = Kugou::get_song($song["id"]);
            array_push($songs, $song);
        }
        break;
    case "xiami":
        include FUNC_PATH . "/xiami.php";
        if (isset($_GET['id'])) {
            $playlist = Xiami::get_playlist($_GET['id']);
        } else {
            $playlist = Xiami::get_playlist(357350045);
        }
        $songs = [];
        foreach ($playlist["result"]["tracks"] as $index => $song) {
            $song = Xiami::get_song($song["id"]);
            array_push($songs, $song);
        }
        break;
}
?>
<html>
<style>
    body {
        margin: 0;
    }
</style>
<div id="player"></div>
<script src="https://unpkg.com/muse-player/dist/assets/muse-player.js" type="text/javascript"></script>
<script>
    MUSE.render([<?php
        foreach ($songs as $song) {
            echo "{
            title: '" . addslashes($song["name"]) . "',
            artist: '";
            foreach ($song["artists"] as $i => $artist) {
                echo($i == 0 ? "" : "/");
                echo addslashes($artist["name"]);
            }
            echo "',
            src: '" . $song["link"] . "',
            cover: '" . $song["album"]["picUrl"] . "',
            lyric: ";
            if (isset($song["lyrics"])) echo json_encode($song["lyrics"]); else echo "'[00:00.00]\\n'";
            echo "},";
        }?>], document.getElementById('player'), {"layout": "muse-layout-landscape"});
</script>
</html>

