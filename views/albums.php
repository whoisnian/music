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
include VIEW_PATH . '/header.php';
if (array_key_exists("result", $albums) && $albums["result"]["albumCount"] > 0) {
    echo '
		  <ul class="demo-list-two mdl-list center">';
    foreach ($albums["result"]["albums"] as $index => $album) {
        $time = date("Y-m-d", $album["publishTime"] / 1000);
        echo '
			  <li style="padding:0 5px" class="mdl-list__item mdl-list__item--two-line">
				<h4>' . sprintf("%02d", $index + 1) . '</h4> 
				<span class="mdl-list__item-primary-content">
				  <i class="material-icons  no_color mdl-list__item-avatar">album</i>
				  <span class="maxlen">' . $album["name"] . '</span>
				  <span class="mdl-list__item-sub-title maxlen">' . $album["artist"]["name"] . '<span class="mdl-button--accent">@</span>' . $time . '</span>
				</span>
				<span class="mdl-list__item-secondary-content">
				  <a class="mdl-list__item-secondary-action" href="album?id=' . $album["id"] . '"><i class="material-icons">zoom_in</i></a>
				</span>
				</li>';
    }
    echo '
		  </ul>';
} else if (ctype_digit($_POST['album'])) {
    echo '<meta http-equiv="refresh" content="0;url=album?id=' . $_POST['album'] . '">';
    exit();
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
