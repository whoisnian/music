<?php
$TITLE = "专辑搜索结果";
include "../Includes/header.php";
include "../Includes/function.php";

	if(isset($_POST['content'])) {
    	$url = "http://music.163.com/api/search/pc";
		$post_data = "offset=0&limit=100&type=10&s=".$_POST['content'];
		$json = post_by_curl($url, $post_data);
		$albums = json_decode($json, true);
	}
	else {
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
	}

	if(array_key_exists("result", $albums) && $albums["result"]["albumCount"] > 0) {
		echo '<div class="table" style="border-left:solid 10px #000000;padding-left:5px">查询到'.min(array(100,$albums["result"]["albumCount"])).'个专辑</div>';
		echo '
		<table class="table">
			<tr>
				<th>#</th>
				<th>专辑</th>
				<th>歌手</th>
				<th>发行时间</th>
				<th>操作</th>
			</tr>';
		foreach($albums["result"]["albums"] as $index=>$album) {
			echo '
			<tr>
				<td>'.($index + 1).'</td>
				<td>'.$album["name"].'</td>
				<td>'.$album["artist"]["name"].'</td>';
			$time = date("Y-m-d", $album["publishTime"]/1000);
			echo '
				<td>'.$time.'</td>
				<td><a class="button" href="album.php?id='.$album["id"].'">详情</a></td>
			</tr>';
		}
		echo '
		</table>';
	}
	else {
		echo '<div class="table" style="border-left:solid 10px #BB0000;padding-left:5px">未查询到专辑</div>';
	}

include "../Includes/footer.php";
?>
