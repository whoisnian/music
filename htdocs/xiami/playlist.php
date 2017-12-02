<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
include FUNC_PATH . "/xiami.php";
if (isset($_GET['id'])) {
    $playlist = Xiami::get_playlist($_GET['id']);
} else {
    echo '<meta http-equiv="refresh" content="0;url=./">';
    exit();
}

include VIEW_PATH . "/playlist.php";
