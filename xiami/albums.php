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
    if(ctype_digit($_POST['album'])) {
			echo '<meta http-equiv="refresh" content="0;url=album.php?id='.$_POST['album'].'">';
			exit();
		}
		else {
			echo '
				<ul class="demo-list-control mdl-list center">
				<li class="mdl-list__item">
					<span class="mdl-list__item-primary-content">
						<i class="material-icons mdl-list__item-avatar">clear</i>
						请输入正确的专辑ID
					</span>
				</li>
				</ul>';
		}
	}
	else {
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
		exit();
	}
include "../include/footer.php";
?>
