<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
include FUNC_PATH . "/qq.php";
if (isset($_POST['playlist'])) {
    $playlists = QQ::get_playlists(rawurlencode($_POST['playlist']));
} else {
    echo '<meta http-equiv="refresh" content="0;url=./">';
    exit();
}

include VIEW_PATH . "/playlists.php";
?>
