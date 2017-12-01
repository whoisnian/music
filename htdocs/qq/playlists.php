<?php
$TITLE = '搜索结果';
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
	if(isset($_POST['playlist'])) {
    $url = "http://c.y.qq.com/soso/fcgi-bin/client_music_search_songlist?page_no=0&num_per_page=30&inCharset=utf8&outCharset=utf-8&format=json&query=".rawurlencode($_POST['playlist']);
		$json = get_by_curl($url, "qq");
		$playlists = json_decode($json, true);
	}
	else {
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
		exit();
	}

	if(array_key_exists("data", $playlists) && $playlists["data"]["sum"] > 0) {
		echo '
		  <ul class="demo-list-two mdl-list center">';
		foreach($playlists["data"]["list"] as $index=>$playlist) {
			echo '
			  <li style="padding:0 5px" class="mdl-list__item mdl-list__item--two-line">
				<h4>'.sprintf("%02d", $index+1).'</h4>
				<span class="mdl-list__item-primary-content">
				  <i class="material-icons mdl-list__item-avatar mdl-badge mdl-badge--overlap" data-badge="'.$playlist["song_count"].'">list</i>
				  <span class="maxlen">'.$playlist["dissname"].'</span>
				  <span class="mdl-list__item-sub-title maxlen">'.$playlist["creator"]["name"].'</span>
				</span>
				<span class="mdl-list__item-secondary-content">
				  <a class="mdl-list__item-secondary-action" href="playlist.php?id='.$playlist["dissid"].'"><i class="material-icons">zoom_in</i></a>
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
				  未查询到歌单
			  </span>
			</li>
		  </ul>';
	}
include "../include/footer.php";
?>
