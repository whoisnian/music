<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
	if(isset($_GET['id'])) {
		$url = "http://c.y.qq.com/v8/fcg-bin/fcg_play_single_song.fcg?inCharset=utf8&outCharset=utf-8&format=json&songmid=".$_GET['id'];
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
		$link = "http://dl.stream.qqmusic.qq.com/M500".$_GET['id'].".mp3?vkey=".$key."&guid=".$guid."&fromtag=64";

		$song = [];
		$song["album"] = [
			"picUrl" => 'http://y.gtimg.cn/music/photo_new/T002R300x300M000'.$song_detail["data"][0]["album"]["mid"].'.jpg',
			"id" => $song_detail["data"][0]["album"]["mid"],
			"name" => $song_detail["data"][0]["album"]["name"],
		];
        $song["artists"] = $song_detail["data"][0]["singer"];
        $song["name"] = $song_detail["data"][0]["name"];
        $song["link"] = $link;
	}
include VIEW_PATH . "/song.php";
?>
