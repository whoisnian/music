<?php
$TITLE = "作品详情";
include "../Includes/header.php";
include "../Includes/function.php";

	if(isset($_GET['id'])) {
		$url = "http://music.163.com/api/search/pc";
		$post_data = "offset=0&limit=1&type=1&s=".$_GET['id'];
		$json = post_by_curl($url, $post_data);
		$song = json_decode($json, true);
	}
	else {
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
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

		echo '
	<div class="musicbox">
		<img src="'.$song["result"]["songs"][0]["album"]["picUrl"].'" class="music-img">
		<div class="music-info">
			'.$song["result"]["songs"][0]["name"].'<br/><br/>
			歌手：';
		foreach($song["result"]["songs"][0]["artists"] as $i=>$artist) {
			echo ($i == 0 ? "":"/");
			echo $artist["name"];
		}
		echo '<br/>
			专辑：<a href="album.php?id='.$song["result"]["songs"][0]["album"]["id"].'">'.$song["result"]["songs"][0]["album"]["name"].'</a><br/><br/>
			<!--<a href="'.$link.'" download="'.$song["result"]["songs"][0]["name"].'.mp3">下载</a>-->
		</div>
		<audio src="'.$link.'" type="audio/mp3" controls="controls" loop="loop" style="width:100%"></audio></div>';
	}
	else {
		echo '<div class="table" style="border-left:solid 10px #BB0000;padding-left:5px">未查询到专辑</div>';
	}

include "../Includes/footer.php";
?>
