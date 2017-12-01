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
include '../../views/header.php';
include "../../functions/function.php";
	if(isset($_POST['playlist'])) {
    $url = "http://specialsearch.kugou.com/special_search?platform=WebFilter&page=1&pagesize=99&iscorrection=1&keyword=".rawurlencode($_POST['playlist']);
		$json = get_by_curl($url, "kugou");
		$playlists = json_decode($json, true);
	}
	else {
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
		exit();
	}

	if(array_key_exists("lists", $playlists["data"]) && $playlists["data"]["total"] > 0) {
		echo '
		  <ul class="demo-list-two mdl-list center">';
		foreach($playlists["data"]["lists"] as $index=>$playlist) {
			echo '
			  <li style="padding:0 5px" class="mdl-list__item mdl-list__item--two-line">
				<h4>'.sprintf("%02d", $index+1).'</h4>
				<span class="mdl-list__item-primary-content">
				  <i class="material-icons mdl-list__item-avatar mdl-badge mdl-badge--overlap" data-badge="'.$playlist["song_count"].'">list</i>
				  <span class="maxlen">'.$playlist["specialname"].'</span>
				  <span class="mdl-list__item-sub-title maxlen">'.$playlist["nickname"].'</span>
				</span>
				<span class="mdl-list__item-secondary-content">
				  <a class="mdl-list__item-secondary-action" href="playlist.php?id='.$playlist["specialid"].'"><i class="material-icons">zoom_in</i></a>
				</span>
			  </li>';
		}
		echo '
		  </ul>';
	}
	else if(ctype_digit($_POST['playlist'])) {
		echo '<meta http-equiv="refresh" content="0;url=playlist.php?id='.$_POST['playlist'].'">';
		exit();
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
include "../../views/footer.php";
?>
