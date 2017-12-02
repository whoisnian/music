<?php
include '../../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_GET['src']))
    $src = $_GET['src'];
else
    $src = "netease";
switch ($src) {
    case "netease":
        include FUNC_PATH . "/netease.php";
        if (isset($_GET['id'])) {
            $song = Netease::get_song($_GET['id']);
        } else {
            $song = Netease::get_song(514055326);
        }
        break;
    case "qq":
        include FUNC_PATH . "/qq.php";
        if (isset($_GET['id'])) {
            $song = QQ::get_song($_GET['id']);
        } else {
            $song = QQ::get_song("000mgygi0JqEUN");
        }
        break;
    case "kugou":
        include FUNC_PATH . "/kugou.php";
        if (isset($_GET['id'])) {
            $song = Kugou::get_song($_GET['id']);
        } else {
            $song = Kugou::get_song("eyJoYXNoIjoiODQ3NjM3OUUyOUJDNTc5NjVBMDMzMzI0NkI5OTg0OTkiLCJhbGJ1bV9pZCI6Ijc4Mzg1NzYifQ");
        }
        break;
    case "xiami":
        include FUNC_PATH . "/xiami.php";
        if (isset($_GET['id'])) {
            $song = Xiami::get_song($_GET['id']);
        } else {
            $song = Xiami::get_song("1771939336");
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
        playlist: [
            {
                src: '<?php echo $song["link"] ?>',
                poster: '<?php echo $song["album"]["picUrl"] ?>',
                name: '<?php echo $song["name"] ?>',
                artist: '<?php
                    foreach ($song["artists"] as $i => $artist) {
                        echo($i == 0 ? "" : "/");
                        echo $artist["name"];
                    }
                    ?>',
                lyric: <?php if (isset($song["lyrics"])) echo json_encode($song["lyrics"]); else echo "''"?>,
                //sublyric: '副歌词，一般为翻译...'
            }
        ]
    })
</script>
</html>

