<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
if (isset($_POST['playlist'])) {
    $url = "http://music.163.com/api/search/pc";
    $post_data = "offset=0&limit=99&type=1000&s=" . rawurlencode($_POST['playlist']);
    $json = post_by_curl($url, $post_data, "163");
    $playlists = json_decode($json, true);
} else {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
include VIEW_PATH . "/playlists.php"
?>
