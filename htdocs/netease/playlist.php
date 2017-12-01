<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
include FUNC_PATH . "/netease.php";
if (isset($_GET['id'])) {
    $playlist = Netease::get_playlist($_GET['id']);
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
include VIEW_PATH . "/playlist.php"
?>
