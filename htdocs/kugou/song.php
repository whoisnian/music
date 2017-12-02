<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
include FUNC_PATH . "/kugou.php";
if (isset($_GET['id'])) {
    $song = Kugou::get_song($_GET['id']);
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
include VIEW_PATH . "/song.php"
?>
