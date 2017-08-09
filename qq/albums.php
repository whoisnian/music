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
	.mdl-list__item-primary-content .no_color {
		background-color: #FFFFFF;
		color: #757575;
	}
	</style>';
include '../include/header.php';
include "../include/function.php";
	if(isset($_POST['album'])) {
    $url = "http://c.y.qq.com/soso/fcgi-bin/client_search_cp?t=8&p=1&n=30&inCharset=utf-8&outCharset=utf-8&format=json&w=".rawurlencode($_POST['album']);
		$url2 = "http://c.y.qq.com/soso/fcgi-bin/client_search_cp?t=8&p=2&n=30&inCharset=utf-8&outCharset=utf-8&format=json&w=".rawurlencode($_POST['album']);
		$url3 = "http://c.y.qq.com/soso/fcgi-bin/client_search_cp?t=8&p=3&n=30&inCharset=utf-8&outCharset=utf-8&format=json&w=".rawurlencode($_POST['album']);
		$json = get_by_curl($url, "qq");
		$json2 = get_by_curl($url2, "qq");
		$json3 = get_by_curl($url3, "qq");
		$albums = json_decode($json, true);
		$albums2 = json_decode($json2, true);
		$albums3 = json_decode($json3, true);
		if($albums["data"]["album"]["list"] != NULL) {
			$albums["data"]["album"]["list"] = array_merge($albums["data"]["album"]["list"], $albums2["data"]["album"]["list"], $albums3["data"]["album"]["list"]);
		}
	}
	else {
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
		exit();
	}
	
	if(array_key_exists("data", $albums) && $albums["data"]["album"]["totalnum"] > 0) {
		echo '
		  <ul class="demo-list-two mdl-list center">';
		foreach($albums["data"]["album"]["list"] as $index=>$album) {
			echo '
			  <li style="padding:0 5px" class="mdl-list__item mdl-list__item--two-line">
				<h4>'.sprintf("%02d", $index+1).'</h4> 
				<span class="mdl-list__item-primary-content">
				  <i class="material-icons  no_color mdl-list__item-avatar">album</i>
				  <span class="maxlen">'.$album["albumName"].'</span>
				  <span class="mdl-list__item-sub-title maxlen">'.$album["singerName"].'<span class="mdl-button--accent">@</span>'.$album["publicTime"].'</span>
				</span>
				<span class="mdl-list__item-secondary-content">
				  <a class="mdl-list__item-secondary-action" href="album.php?mid='.$album["albumMID"].'"><i class="material-icons">zoom_in</i></a>
				</span>
				</li>';
		}
		echo '
		  </ul>';
	}
	else {
		echo '
		  <ul class="demo-list-control mdl-list center">
			<li class="mdl-list__item">
			  <span class="mdl-list__item-primary-content">
			    <i class="material-icons mdl-list__item-avatar">clear</i>
				  未查询到专辑
			  </span>
			</li>
		  </ul>';
	}
include "../include/footer.php";
?>
