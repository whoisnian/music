<?php
$TITLE = '专辑详情';
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
	</style>';
include VIEW_PATH . '/header.php';
if (array_key_exists("album", $album) && $album["album"]["size"] > 0) {
    echo '
		  <ul class="demo-list-two mdl-list center">';
    foreach ($album["album"]["songs"] as $index => $song) {
        /*if($song["mMusic"] != null) {
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
        }*/

        echo '
			  <li style="padding:0 5px" class="mdl-list__item mdl-list__item--two-line">
				<h4>' . ($album["album"]["size"] > 99 ? sprintf("%03d", $index + 1) : sprintf("%02d", $index + 1)) . '</h4> 
				<span class="mdl-list__item-primary-content">
				  <i class="material-icons mdl-list__item-avatar">music_note</i>
				  <span class="maxlen">' . $song["name"] . '</span>
				  <span class="mdl-list__item-sub-title maxlen">';

        foreach ($song["artists"] as $i => $artist) {
            echo($i == 0 ? "" : "/");
            echo $artist["name"];
        }

        echo '</span>
				</span>
				<span class="mdl-list__item-secondary-content">
				  <a class="mdl-list__item-secondary-action" href="song?id=' . $song["id"] . '"><i class="material-icons">zoom_in</i></a>
				</span>
			  </li>';
    }
    echo '
		  </ul>';
} else {
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
include VIEW_PATH . "/footer.php";
?>
