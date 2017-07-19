<?php
function get_by_curl($url) {
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_COOKIE, "appver=1.5.0.75771");
	curl_setopt($ch, CURLOPT_REFERER, "http://music.163.com/");
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
function post_by_curl($url, $post_data) {
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($ch, CURLOPT_COOKIE, "appver=1.5.0.75771");
	curl_setopt($ch, CURLOPT_REFERER, "http://music.163.com/");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
// Thanks to https://github.com/metowolf/Meting/blob/master/src/Meting.php
function encrypt_id($id) {
    $str1 = str_split('3go8&$8*3*3h0k(2)2');
    $str2 = str_split($id);
    for($i = 0;$i < count($str2);$i++) {
        $str2[$i] = chr(ord($str2[$i]) ^ ord($str1[$i % count($str1)]));
    }
    $result = base64_encode(md5(implode('', $str2), true));
    $result = str_replace(array('/','+'), array('_','-'), $result);
    return $result;
}
?>
