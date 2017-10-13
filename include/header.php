<?php
	echo '<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Search your favorite music.">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>'.$TITLE.'</title>

    <link rel="shortcut icon" href="/image/favicon.png">
    <link rel="stylesheet" href="/css/material.min.css">
		<link rel="stylesheet" href="/css/icon.css">	
		'.$OTHERSTYLE.'
  </head>
  <body>
		<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--fixed-tabs">
	  	<header class="mdl-layout__header mdl-layout__header--scroll">
        <div class="mdl-layout__header-row">
          <span class="mdl-layout-title">'.$TITLE.'</span>
				</div>
				'.$TABS.'
	  	</header>
	  	<div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Music</span>
				<nav class="mdl-layout__content mdl-navigation">
		  		<a class="mdl-navigation__link" href="/">首页</a>
		  		<a class="mdl-navigation__link" href="/netease">网易云音乐</a>
					<a class="mdl-navigation__link" href="/qq">QQ音乐</a>
					<a class="mdl-navigation__link" href="/kugou">酷狗音乐</a>
          <a class="mdl-navigation__link" href="/xiami">虾米音乐（待完善）</a>
				</nav>
	  	</div>
	  	<main style="width:100%" class="mdl-layout__content mdl-grid mdl-grid--no-spacing">';
?>
