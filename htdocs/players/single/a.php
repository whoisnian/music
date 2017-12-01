<?php
include '../../../configs/global.php';
include FUNC_PATH . "/function.php";
include FUNC_PATH . "/netease.php";
if (isset($_GET['src']))
    $src = $_GET['src'];
else
    $src = "netease";
switch ($src) {
    case "netease":
        if (isset($_GET['id'])) {
            $song = Netease::get_song($_GET['id']);
        } else {
            $song = Netease::get_song(514055326);
        }
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
            title: '<?php echo $song["name"] ?>',
            author: '<?php
                foreach ($song["artists"] as $i => $artist) {
                    echo($i == 0 ? "" : "/");
                    echo $artist["name"];
                }
                ?>',
            url: '<?php echo $song["link"] ?>',
            pic: '<?php echo $song["album"]["picUrl"] ?>',
            lrc: <?php if(isset($song["lyrics"])) echo json_encode($song["lyrics"]) ?>
        }
    });
</script>
</html>

