<?php
$TITLE = "网易云音乐";
include "../Includes/header.php";

    if(!isset($_GET["id"]) || $_GET["id"] == 1) {
	    echo '
<form class="form-card" action="songs.php" method="post">
    <a class="button" style="float:right;color:#FFFFFF;border-width:0;border-radius:0;padding:0;box-shadow:0 0 5px 2px #666666;" href="?id=2">「切换」</a><br/>
    <br/>
    <label><input class="input" type="text" name="content" placeholder="请输入歌曲名或歌手名"></label>
    <br/><br/>
    <label class="button">歌曲搜索<input style="display:none" type="submit" name="submit"></label>
</form>';
    }
    else if($_GET["id"] == 2) {
        echo '
<form class="form-card" action="albums.php" method="post">
    <a class="button" style="float:right;color:#FFFFFF;border-width:0;border-radius:0;padding:0;box-shadow:0 0 5px 2px #666666;" href="?id=3">「切换」</a><br/>
    <br/>
    <label><input class="input" type="text" name="content" placeholder="请输入专辑名或专辑ID"></label>
    <br/><br/>
    <label class="button">专辑搜索<input style="display:none" type="submit" name="submit"></label>
</form>';
    }
    else {
        echo '
<form class="form-card" action="lists.php" method="post">
    <a class="button" style="float:right;color:#FFFFFF;border-width:0;border-radius:0;padding:0;box-shadow:0 0 5px 2px #666666;" href="?id=1">「切换」</a><br/>
    <br/>
    <label><input class="input" type="text" name="content" placeholder="请输入歌单名或歌单ID"></label>
    <br/><br/>
    <label class="button">歌单搜索<input style="display:none" type="submit" name="submit"></label>
</form>';
    }

include "../Includes/footer.php";
?>
