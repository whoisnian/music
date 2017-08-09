<?php
$TITLE = '专辑详情';
$TABS = '';
$OTHERSTYLE = '
	<style>
	.center {
		margin:0 auto;
		min-width: 30%;
	}
	.wide {
		width:100%;
	}
	.maxlen {
		white-space: nowrap;
		display: inline-block;
		vertical-align:top;
		max-width: 10em;
		overflow: hidden;
		text-overflow: ellipsis;
	}
	@media (min-width: 40em) {
		.maxlen	{
			max-width: 20em;
		}
	}
	@media (min-width: 60em) {
		.maxlen	{
			max-width: 30em;
		}
	}
	</style>';
include '../include/header.php';
include "../include/function.php";
	if(isset($_GET['mid'])) {
    $url = "http://c.y.qq.com/v8/fcg-bin/fcg_v8_album_info_cp.fcg?inCharset=utf-8&outCharset=utf-8&albummid=".$_GET['mid'];
		$json = get_by_curl($url, "qq");
		$album = json_decode($json, true);
	}
	else {
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
		exit();
	}

	if(array_key_exists("data", $album) && $album["code"] == 0) {
		echo '
		  <ul class="demo-list-two mdl-list center">';
		foreach($album["data"]["list"] as $index=>$song) {

			echo '
			  <li style="padding:0 5px" class="mdl-list__item mdl-list__item--two-line">
				<h4>'.($album["data"]["total_song_num"]>99 ? sprintf("%03d", $index+1) : sprintf("%02d", $index+1)).'</h4> 
				<span class="mdl-list__item-primary-content">
				  <i class="material-icons mdl-list__item-avatar">music_note</i>
				  <span class="maxlen">'.$song["songname"].'</span>
				  <span class="mdl-list__item-sub-title maxlen">';

			foreach($song["singer"] as $i=>$singer) {
				echo ($i == 0 ? "":"/");
				echo $singer["name"];
			}

			echo '</span>
				</span>
				<span class="mdl-list__item-secondary-content">
				  <a class="mdl-list__item-secondary-action" href="song.php?mid='.$song["songmid"].'"><i class="material-icons">zoom_in</i></a>
				</span>
			  </li>';
		}
		echo '
		  </ul>';
	}
	else {
		echo '
		  <ul class="demo-list-control mdl-list center">
			<li class="mdl-list__item">
			  <span class="mdl-list__item-primary-content">
			    <i class="material-icons mdl-list__item-avatar">clear</i>
				  未查询到专辑
			  </span>
			</li>
		  </ul>';
	}
include "../include/footer.php";
?>
