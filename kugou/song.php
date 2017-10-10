<?php
$TITLE = '歌曲详情';
$TABS = '';
$OTHERSTYLE = '
	<style>
	.center {
		margin: auto;
		min-width: 40%;
		min-height: auto;
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
	.img {
		width: 100px; 
		height: 100px;
	}
	@media (min-width: 40em) {
		.img {
			width: 125px;
			height: 125px;
		}
	}
	@media (min-width: 60em) {
		.img {
			width: 150px;
			height: 150px;
		}
	}
	.player {
		width: 100%;
		padding: 0;
		border-collapse: collapse;
	}
	</style>';
include '../include/header.php';
include "../include/function.php";
	if(isset($_GET['hash'])&&isset($_GET['album_id'])) {
		$url = "http://www.kugou.com/yy/index.php?r=play/getdata&hash=".$_GET['hash']."&album_id=".$_GET['album_id'];
		$json = get_by_curl($url, "kugou");
		$song_detail = json_decode($json, true);
	}
	else {
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
		exit();
	}

	if($song_detail["data"] != NULL && $song_detail["status"] == 1) {
		$link = $song_detail["data"]["play_url"];

		$min = floor($song_detail["data"]["timelength"] / 1000 / 60);
		$sec = floor($song_detail["data"]["timelength"] / 1000 % 60);
		$min = str_pad($min, 2, '0', STR_PAD_LEFT);
		$sec = str_pad($sec, 2, '0', STR_PAD_LEFT);
		$time = $min.':'.$sec;

		echo '
			<div class="center mdl-card mdl-grid mdl-grid--no-spacing mdl-shadow--6dp">
				<span><img class="img" src="'.$song_detail["data"]["img"].'"></span>
				<span class="center">
					<div class="maxlen">
						'.$song_detail["data"]["song_name"].'
					</div><br/><br/>
					<div class="maxlen">
				  	歌手：'.$song_detail["data"]["author_name"].'<br/>
				  	专辑：<a href="album.php?id='.$song_detail["data"]["album_id"].'">'.$song_detail["data"]["album_name"].'</a>
					</div>
				</span>
				<audio src="'.$link.'" type="audio/mp3" id="player_music"></audio>
				<table class="mdl-card__actions mdl-card--border player" id="player">
					<td style="width:5%"><button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
						<i class="material-icons" id="player_button">play_arrow</i>
					</button></td>
					<td style="width:80%">
						<input class="mdl-slider mdl-js-slider" type="range" min="0" max="100" value="0" id="player_slider">
					</td>
					<td style="width:10%"><span id="player_time">00:00</span>/'.$time.'</td>
					<td style="width:5%"><a href="'.$link.'" download="'.$song_detail["data"]["song_name"].'.mp3">
					<button class="player-td mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
						<i class="material-icons">file_download</i>
					</button>
					</a></td>
				</table>
			</div>';
	}
	else {
		echo '
		  <ul class="demo-list-control mdl-list center">
			<li class="mdl-list__item">
			  <span class="mdl-list__item-primary-content">
			    <i class="material-icons mdl-list__item-avatar">clear</i>
					未查询到歌曲
			  </span>
			</li>
		  </ul>';
	}
include "../include/footer.php";
?>
