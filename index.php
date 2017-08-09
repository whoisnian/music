<?php
$TITLE = 'Music';
$TABS = '';
$OTHERSTYLE = '
	<style>
	.center {
		margin:0 auto;
	}
	</style>';
include './include/header.php';
	echo '
		<h1 class="center">
		  <br/>
		  <div id="search" class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored">
		    <i class="material-icons">search</i>
		  </div>
		  <div class="mdl-tooltip" data-mdl-for="search">
			  搜 索
		  </div>
		  <div id="listen" class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored">
		    <i class="material-icons">headset</i>
		  </div>
		  <div class="mdl-tooltip" data-mdl-for="listen">
			  试 听
		  </div>
		  <div id="download" class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored">
			  <i class="material-icons">file_download</i>
		  </div>
		  <div class="mdl-tooltip" data-mdl-for="download">
			  下 载
		  </div>
		</h1>';
include "./include/footer.php";
?>
