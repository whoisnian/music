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
<div id="aplayer1" class="aplayer"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aplayer/1.6.0/APlayer.min.js"></script>
<script>
    var ap = new APlayer({
        element: document.getElementById('aplayer1'),
        showlrc: <?php echo isset($song["lyrics"]) ? 1 : 0 ?>,
        music: {
            title: '<?php echo addslashes($song["name"]) ?>',
            author: '<?php
                foreach ($song["artists"] as $i => $artist) {
                    echo($i == 0 ? "" : "/");
                    echo addslashes($artist["name"]);
                }
                ?>',
            url: '<?php echo $song["link"] ?>',
            pic: '<?php echo $song["album"]["picUrl"] ?>',
            lrc: <?php if (isset($song["lyrics"])) echo json_encode($song["lyrics"]); else echo "''"?>
        }
    });
</script>
</html>

