<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
include FUNC_PATH . "/kugou.php";
if (isset($_GET['id'])) {
    $album = Kugou::get_album($_GET['id']);
} else {
    echo '<meta http-equiv="refresh" content="0;url=./">';
    exit();
}

include VIEW_PATH . "/album.php";
?>
