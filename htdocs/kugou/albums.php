<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
include FUNC_PATH . "/kugou.php";
if (isset($_POST['album'])) {
    $albums = Kugou::get_albums(rawurlencode($_POST['album']));
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}

include VIEW_PATH . "/albums.php";
?>
