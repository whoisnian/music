<?php
$TITLE = "歌单搜索结果";
include "../Includes/header.php";
include "../Includes/function.php";

	if(isset($_POST['content'])) {
    	$url = "http://music.163.com/api/search/pc";
		$post_data = "offset=0&limit=100&type=1000&s=".$_POST['content'];
		$json = post_by_curl($url, $post_data);
		$lists = json_decode($json, true);
	}
	else {
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
	}
	
	if(array_key_exists("result", $lists) && $lists["result"]["playlistCount"] > 0) {
		echo '<div class="table" style="border-left:solid 10px #000000;padding-left:5px">查询到'.min(array(100,$lists["result"]["playlistCount"])).'个歌单</div>';
		echo '
		<table class="table">
			<tr>
				<th>#</th>
				<th>歌单</th>
				<th>歌曲数</th>
				<th>作者</th>
				<th>操作</th>
			</tr>';
		foreach($lists["result"]["playlists"] as $index=>$list) {
			echo '
			<tr>
				<td>'.($index + 1).'</td>
				<td>'.$list["name"].'</td>
				<td>'.$list["trackCount"].'</td>
				<td>'.$list["creator"]["nickname"].'</td>
				<td><a class="button" href="list.php?id='.$list["id"].'">详情</a></td>
			</tr>';
		}
		echo '
		</table>';
	}
	else if(ctype_digit($_POST['content'])) {
		echo '<meta http-equiv="refresh" content="0;url=list.php?id='.$_POST['content'].'">';
	}
	else {
		echo '<div class="table" style="border-left:solid 10px #BB0000;padding-left:5px">未查询到歌单</div>';
	}

include "../Includes/footer.php";
?>
