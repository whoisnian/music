<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
include FUNC_PATH . "/netease.php";
if(isset($_GET['id'])) {
    $song = Netease::get_song($_GET['id']);
}
else {
    echo '<meta http-equiv="refresh" content="0;url=./">';
    exit();
}


include VIEW_PATH . "/song.php";
?>
