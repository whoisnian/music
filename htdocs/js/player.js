document.addEventListener("DOMContentLoaded", function(event) {
	var player_music = document.getElementById('player_music');
	var duration;
	var player_button = document.getElementById('player_button');
	var player_slider = document.getElementById('player_slider');
	var player_time = document.getElementById('player_time');
	var total_time = document.getElementById('total_time');

	player_button.addEventListener("click", play);
	player_music.addEventListener("timeupdate", timeUpdate, false);
	player_slider.addEventListener("click", function(event) {
		player_music.currentTime = duration * clickPercent(event);
		player_time.innerHTML = (Math.floor(player_music.currentTime / 60) < 10 ? '0' + Math.floor(player_music.currentTime / 60) : Math.floor(player_music.currentTime / 60)) + ':' + (Math.floor(player_music.currentTime % 60) < 10 ? '0' + Math.floor(player_music.currentTime % 60) : Math.floor(player_music.currentTime % 60));
	}, false);

	function clickPercent(event) {
		return player_slider.value / 100;
	}

	player_slider.addEventListener('mousedown', mouseDown, false);
	window.addEventListener('mouseup', mouseUp, false);

	var onslider = false;

	function mouseDown() {
		onslider = true;
		player_music.removeEventListener('timeupdate', timeUpdate, false);
	}

	function mouseUp(event) {
		if (onslider == true) {
			player_music.currentTime = duration * clickPercent(event);
			player_music.addEventListener('timeupdate', timeUpdate, false);
		}
		onslider = false;
	}

	function timeUpdate() {
		var sliderPercent = player_music.currentTime / duration;
		player_slider.MaterialSlider.change(sliderPercent * 100);
		player_time.innerHTML = (Math.floor(player_music.currentTime / 60) < 10 ? '0' + Math.floor(player_music.currentTime / 60) : Math.floor(player_music.currentTime / 60)) + ':' + (Math.floor(player_music.currentTime % 60) < 10 ? '0' + Math.floor(player_music.currentTime % 60) : Math.floor(player_music.currentTime % 60));
		if (player_music.currentTime >= duration) {
			player_slider.MaterialSlider.change(0);
			player_time.innerHTML = "00:00"
		    player_button.innerHTML = "";
			player_button.innerHTML = "play_arrow";
		}
	}

	function play() {
		if (player_music.paused) {
			player_music.play();
			player_button.innerHTML = "";
			player_button.innerHTML = "pause";
		} else {
			player_music.pause();
			player_button.innerHTML = "";
			player_button.innerHTML = "play_arrow";
		}
	}

	player_music.addEventListener("canplaythrough", function() {
		duration = player_music.duration;
		total_time.innerHTML = (Math.floor(duration / 60) < 10 ? '0' + Math.floor(duration / 60) : Math.floor(duration / 60)) + ':' + (Math.floor(duration % 60) < 10 ? '0' + Math.floor(duration % 60) : Math.floor(duration % 60));
	}, false);
});
