<?php
$TITLE = 'QQ音乐';
$TABS = '
		<div class="mdl-layout__tab-bar mdl-js-ripple-effect">
      <a href="#search_song" class="mdl-layout__tab mdl-navigation__link is-active"><i class="material-icons">music_note</i> 歌曲搜索</a>
      <a href="#search_album" class="mdl-layout__tab mdl-navigation__link"><i class="material-icons">album</i> 专辑搜索</a>
		  <a href="#search_playlist" class="mdl-layout__tab mdl-navigation__link"><i class="material-icons">list</i> 歌单搜索</a>
		</div>';
$OTHERSTYLE = '
	<style>
	.center {
		margin:0 auto;
	}
	.wide {
		width:100%;
	}
	</style>';
include '../include/header.php';
	echo '
		<section class="mdl-layout__tab-panel wide is-active" id="search_song">
		  <form class="mdl-cell center" action="./songs.php" method="post">
			  <br/><br/>
		    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label wide">
			    <input class="mdl-textfield__input" type="text" name="song" id="song">
			    <label class="mdl-textfield__label" for="song">请输入歌曲名或歌手名</label>
			  </div><br/>	
			  <input class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit" name="submit" value="歌曲搜索"><br/>
		  </form>
		</section>
		<section class="mdl-layout__tab-panel wide" id="search_album">
		  <form class="mdl-cell center" action="./albums.php" method="post">
			  <br/><br/>
		    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label wide">
			    <input class="mdl-textfield__input" type="text" name="album" id="album">
			    <label class="mdl-textfield__label" for="album">请输入专辑名称</label>
			  </div><br/>
			  <input class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit" name="submit" value="专辑搜索"><br/>
		  </form>
		</section>
		<section class="mdl-layout__tab-panel wide" id="search_playlist">
		  <form class="mdl-cell center" action="./playlists.php" method="post">
			  <br/><br/>
		    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label wide">
			    <input class="mdl-textfield__input" type="text" name="playlist" id="playlist">
			    <label class="mdl-textfield__label" for="playlist">请输入歌单名称</label>
			  </div><br/>	
			  <input class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit" name="submit" value="歌单搜索"><br/>
		  </form>
		</section>';
include '../include/footer.php';
?>
