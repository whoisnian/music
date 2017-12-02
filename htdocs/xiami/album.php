<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
include FUNC_PATH . "/xiami.php";
if (isset($_GET['id'])) {
    $album = Xiami::get_album($_GET['id']);
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}

include VIEW_PATH . "/album.php";
