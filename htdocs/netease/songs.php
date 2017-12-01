<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
include FUNC_PATH . "/netease.php";
if (isset($_POST['song'])) {
    $songs = Netease::get_songs(rawurlencode($_POST['song']));
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
include VIEW_PATH . "/songs.php";
?>
