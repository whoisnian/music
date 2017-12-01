<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
include FUNC_PATH . "/qq.php";
if (isset($_GET['id'])) {
    $album = QQ::get_album($_GET['id']);
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}

include VIEW_PATH . "/album.php";
?>
