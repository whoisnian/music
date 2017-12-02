<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
include FUNC_PATH . "/netease.php";
if (isset($_GET['id'])) {
    $album = Netease::get_album($_GET['id']);
} else {
    echo '<meta http-equiv="refresh" content="0;url=./">';
    exit();
}
include VIEW_PATH . "/album.php";
