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
	if(isset($_GET['mid'])) {
		$url = "http://c.y.qq.com/v8/fcg-bin/fcg_play_single_song.fcg?inCharset=utf8&outCharset=utf-8&format=json&songmid=".$_GET['mid'];
		$json = get_by_curl($url, "qq");
		$song_detail = json_decode($json, true);
	}
	else {
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
		exit();
	}

	if($song_detail["data"] != NULL && $song_detail["code"] == 0) {
		$guid = rand(1000000000, 2000000000);
		$key_url = "http://base.music.qq.com/fcgi-bin/fcg_musicexpress.fcg?json=3&inCharset=utf8&outCharset=utf-8&format=json&guid=".$guid;
		$key_detail = get_by_curl($key_url, "qq");
		$key = json_decode($key_detail, true)["key"];
		$link = "http://dl.stream.qqmusic.qq.com/M500".$_GET['mid'].".mp3?vkey=".$key."&guid=".$guid."&fromtag=64";

		echo '
			<div class="center mdl-card mdl-grid mdl-grid--no-spacing mdl-shadow--6dp">
				<span><img class="img" src="http://y.gtimg.cn/music/photo_new/T002R300x300M000'.$song_detail["data"][0]["album"]["mid"].'.jpg"></span>
				<span class="center">
					<div class="maxlen">
						'.$song_detail["data"][0]["name"].'
					</div><br/><br/>
					<div class="maxlen">
				  	歌手：';
		foreach($song_detail["data"][0]["singer"] as $i=>$singer) {
			echo ($i == 0 ? "":"/");
			echo $singer["name"];
		}
		echo '<br/>
				  	专辑：<a href="album.php?mid='.$song_detail["data"][0]["album"]["mid"].'">'.$song_detail["data"][0]["album"]["name"].'</a>
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
					<td style="width:10%"><span id="player_time">00:00</span>/<span id="total_time">00:00</span></td>
					<td style="width:5%"><a href="'.$link.'" download="'.$song_detail["data"][0]["name"].'.mp3">
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
