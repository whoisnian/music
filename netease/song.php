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
	</style>';
include '../include/header.php';
include "../include/function.php";
	if(isset($_GET['id'])) {
		$url = "http://music.163.com/api/search/pc";
		$post_data = "offset=0&limit=1&type=1&s=".$_GET['id'];
		$json = post_by_curl($url, $post_data);
		$song = json_decode($json, true);
		
		// Get lyric of the song
		// $url = "http://music.163.com/api/song/media?id=".$_GET['id'];
		// $lyric = json_decode(get_by_curl($url), true)["lyric"];

		// Thanks to https://github.com/maicong/music/blob/master/music.php
		$other_url = "http://music.163.com/api/song/enhance/player/url?ids=[".$_GET['id']."]&br=320000";
		$other_json = get_by_curl($other_url);
		$other_link = json_decode($other_json, true);
	}
	else {
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
		exit();
	}

	if(array_key_exists("result", $song) && $song["result"]["songCount"] > 0) {
		if(array_key_exists("mp3Url", $song["result"]["songs"][0]) && $song["result"]["songs"][0]["mp3Url"] != null) {
			$link = str_replace("http://m2", "http://p2", $song["result"]["songs"][0]["mp3Url"]);
		}
		else if($song["result"]["songs"][0]["mMusic"]["dfsId"] != 0) {
			$link = "http://p2.music.126.net/".encrypt_id($song["result"]["songs"][0]["mMusic"]["dfsId"])."/".$song["result"]["songs"][0]["mMusic"]["dfsId"].".mp3";
		}
		else {
			$link = "http://p2.music.126.net/".encrypt_id($song["result"]["songs"][0]["bMusic"]["dfsId"])."/".$song["result"]["songs"][0]["bMusic"]["dfsId"].".mp3";
		}

		if($other_link["data"][0]["url"] != NULL) {
			$link = $other_link["data"][0]["url"];
		}
		else if(!substr_count(get_headers($link)[0], '200')) {
			$link = "Not Found";
		}

		echo '
		  <div class="center mdl-card mdl-grid mdl-grid--no-spacing mdl-shadow--6dp">
		    <span><img class="img" src="'.$song["result"]["songs"][0]["album"]["picUrl"].'?param=200y200"></span>
			<span class="center">
			  <div class="maxlen">
			    '.$song["result"]["songs"][0]["name"].'
		      </div><br/><br/>
			  <div class="maxlen">
				歌手：';
		foreach($song["result"]["songs"][0]["artists"] as $i=>$artist) {
			echo ($i == 0 ? "":"/");
			echo $artist["name"];
		}
		echo '<br/>
				专辑：<a href="album.php?id='.$song["result"]["songs"][0]["album"]["id"].'">'.$song["result"]["songs"][0]["album"]["name"].'</a>
			  </div>
			</span>
			<span class="mdl-card__menu">
			  <a href="'.$link.'" download="'.$song["result"]["songs"][0]["name"].'.mp3">
				<button class="mdl-button mdl-button--icon mdl-button--colored mdl-js-button mdl-js-ripple-effect">
				  <i class="material-icons">file_download</i>
				</button>
			  </a>
			</span>
			<span class="mdl-card__actions mdl-card--border">
			  <audio src="'.$link.'" type="audio/mp3" controls="controls" loop="loop" style="width:100%"></audio>
			</span>
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
