<?php
	echo '
<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
        <title>'.$TITLE.'</title>
		<link rel="stylesheet" type="text/css" href="/Styles/nian.css">
	</head>

    <body ontouchstart>
        <div class="wrapper">
			<div class="menu">
				<a class="menu-title" href="/">Music</a>
				<nav class="other">
					<a href="/">首页</a>
				</nav>
				<nav class="dropdown">
					<a href="#">网易</a></br>
					<nav class="drop-content">
						<a href="/netease?id=1">歌曲搜索</a>
						<a href="/netease?id=2">专辑搜索</a>
						<a href="/netease?id=3">歌单搜索</a>
					</nav>
				</nav>
			</div>
			<br/>
<!------------header ending------------->';
?>
