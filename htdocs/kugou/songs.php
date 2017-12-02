<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
include FUNC_PATH . "/kugou.php";
if (isset($_POST['song'])) {
    $songs = Kugou::get_songs(rawurlencode($_POST['song']));
} else {
    echo '<meta http-equiv="refresh" content="0;url=./">';
    exit();
}
include VIEW_PATH . "/songs.php";
?>
