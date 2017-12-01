<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_POST['song'])) {
    $url = "http://music.163.com/api/search/pc";
    $post_data = "offset=0&limit=99&type=1&s=" . rawurlencode($_POST['song']);
    $json = post_by_curl($url, $post_data, "163");
    $songs = json_decode($json, true);
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
include VIEW_PATH . "/songs.php";
?>
