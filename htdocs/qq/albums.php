<?php
include '../../configs/global.php';
include FUNC_PATH . "/function.php";
	if(isset($_POST['album'])) {
    $url = "http://c.y.qq.com/soso/fcgi-bin/client_search_cp?t=8&p=1&n=30&inCharset=utf8&outCharset=utf-8&format=json&w=".rawurlencode($_POST['album']);
		$json = get_by_curl($url, "qq");
		$albums = json_decode($json, true);
		$albums_raw = $albums;
	}
	else {
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
		exit();
	}
	
	if(array_key_exists("data", $albums_raw) && $albums_raw["data"]["album"]["totalnum"] > 0) {
        $albums["result"] = [];
        $albums["result"]["albumCount"] = $albums_raw["data"]["album"]["totalnum"];
        $albums["result"]["albums"] = [];
		foreach($albums_raw["data"]["album"]["list"] as $index=>$album) {
            //
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
include VIEW_PATH . "/albums.php"
?>
