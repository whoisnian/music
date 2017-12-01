<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
include FUNC_PATH . "/netease.php";
if (isset($_POST['playlist'])) {
    $playlists = Netease::get_playlists(rawurlencode($_POST['playlist']));
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
include VIEW_PATH . "/playlists.php"
?>
