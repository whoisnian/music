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
	if(isset($_GET['id'])) {
		$url = "http://music.163.com/api/song/detail/?id=".$_GET['id']."&ids=[".$_GET['id']."]";
		$json = get_by_curl($url, "163");
		$song_detail = json_decode($json, true);
		
		// Get lyric of the song
		// $url = "http://music.163.com/api/song/media?id=".$_GET['id'];
		// $lyric = json_decode(get_by_curl($url), true)["lyric"];

		// Thanks to https://github.com/maicong/music/blob/master/music.php
		$other_url = "http://music.163.com/api/song/enhance/player/url?ids=[".$_GET['id']."]&br=320000";
		$other_json = get_by_curl($other_url, "163");
		$other_link = json_decode($other_json, true);
	}
	else {
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
		exit();
	}

	if($song_detail["songs"] != NULL && $song_detail["code"] == 200) {
		if($other_link["data"][0]["url"] != NULL) {
			$link = $other_link["data"][0]["url"];
			$song = $song_detail["songs"][0];
		}
		else {
			$url = "http://music.163.com/api/album/".$song_detail["songs"][0]["album"]["id"]."?id=".$song_detail["songs"][0]["album"]["id"];
			$json = get_by_curl($url, "163");
			$album = json_decode($json, true);

			foreach($album["album"]["songs"] as $song) {
				if($song["id"] == $_GET['id'])
					break;
			}

			if($song["hMusic"]["dfsId"] != NULL&&$song["hMusic"]["dfsId"] != 0) {
				$link = "http://p2.music.126.net/".encrypt_id($song["hMusic"]["dfsId"])."/".$song["hMusic"]["dfsId"].".mp3";
			}
			else if($song["mMusic"]["dfsId"] != NULL&&$song["mMusic"]["dfsId"] != 0) {
				$link = "http://p2.music.126.net/".encrypt_id($song["mMusic"]["dfsId"])."/".$song["mMusic"]["dfsId"].".mp3";
			}
			else if($song["bMusic"]["dfsId"] != NULL&&$song["bMusic"]["dfsId"] != 0) {
				$link = "http://p2.music.126.net/".encrypt_id($song["bMusic"]["dfsId"])."/".$song["bMusic"]["dfsId"].".mp3";
			}
			else if(array_key_exists("mp3Url", $song) && $song["mp3Url"] != null) {
				$link = str_replace("http://m2", "http://p2", $song["mp3Url"]);
			}
		}

		echo '
			<div class="center mdl-card mdl-grid mdl-grid--no-spacing mdl-shadow--6dp">
				<span><img class="img" src="'.$song["album"]["picUrl"].'?param=200y200"></span>
				<span class="center">
					<div class="maxlen">
						'.$song["name"].'
					</div><br/><br/>
					<div class="maxlen">
				  	歌手：';
		foreach($song["artists"] as $i=>$artist) {
			echo ($i == 0 ? "":"/");
			echo $artist["name"];
		}
		echo '<br/>
				  	专辑：<a href="album.php?id='.$song["album"]["id"].'">'.$song["album"]["name"].'</a>
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
					<td style="width:5%"><a href="'.$link.'" download="'.$song["name"].'.mp3">
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
