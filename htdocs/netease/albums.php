<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
include FUNC_PATH . "/netease.php";
if (isset($_POST['album'])) {
    $albums = Netease::get_albums($_POST['album']);
} else {
    echo '<meta http-equiv="refresh" content="0;url=./">';
    exit();
}
include VIEW_PATH . "/albums.php"
?>
