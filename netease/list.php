<?php
$TITLE = "搜索结果";
include "../Includes/header.php";
include "../Includes/function.php";

	if(isset($_GET['id'])) {
    	$url = "http://music.163.com/api/playlist/detail?id=".$_GET['id'];
		$json = get_by_curl($url);
		$list = json_decode($json, true);
	}
	else {
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
	}

	if(array_key_exists("result", $list) && $list["result"]["trackCount"] > 0) {
		echo '<div class="table" style="border-left:solid 10px #000000;padding-left:5px">'.$list["result"]["name"].' by '.$list["result"]["creator"]["nickname"].'</div>';
		echo '
		<table class="table">
			<tr>
				<th>#</th>
				<th>音乐</th>
				<th>歌手</th>
				<th>时长</th>
				<th>操作</th>
			</tr>';
		foreach($list["result"]["tracks"] as $index=>$song) {
			if($song["mMusic"] != null) {
				$min = floor($song["mMusic"]["playTime"] / 1000 / 60);
				$sec = floor($song["mMusic"]["playTime"] / 1000 % 60);
				$min = str_pad($min, 2, '0', STR_PAD_LEFT);
				$sec = str_pad($sec, 2, '0', STR_PAD_LEFT);
			}
			else {
				$min = floor($song["bMusic"]["playTime"] / 1000 / 60);
				$sec = floor($song["bMusic"]["playTime"] / 1000 % 60);
				$min = str_pad($min, 2, '0', STR_PAD_LEFT);
				$sec = str_pad($sec, 2, '0', STR_PAD_LEFT);
			}

			echo '
			<tr>
				<td>'.($index + 1).'</td>
				<td>'.$song["name"].'</td>
				<td>';

			foreach($song["artists"] as $i=>$artist) {
				echo ($i == 0 ? "":"/");
				echo $artist["name"];
			}

			echo '</td>
				<td>'.$min.':'.$sec.'</td>
				<td><a class="button" href="song.php?id='.$song["id"].'">详情</a></td>
			</tr>';
		}
		echo '
		</table>';
	}
	else {
		echo '<div class="table" style="border-left:solid 10px #BB0000;padding-left:5px">未查询到歌单</div>';
	}

include "../Includes/footer.php";
?>
