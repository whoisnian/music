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
<div id="app"></div>
<!-- 加载 cplayer 脚本 -->
<script src="https://cdn.jsdelivr.net/gh/MoePlayer/cPlayer/dist/cplayer.js"></script>
<script>
    var player = new cplayer({
        element: document.getElementById('app'),
        width: '100%',
        playlist: [<?php
            foreach ($songs as $song) {
                echo "{
            name: '" . addslashes($song["name"]) . "',
            artist: '";
                foreach ($song["artists"] as $i => $artist) {
                    echo($i == 0 ? "" : "/");
                    echo addslashes($artist["name"]);
                }
                echo "',
            src: '" . $song["link"] . "',
            poster: '" . $song["album"]["picUrl"] . "',
            lyric: ";
                if (isset($song["lyrics"])) echo json_encode($song["lyrics"]); else echo "''";
                echo "},";
            }?>]
    })
</script>
</html>

