<?php
function get_by_curl($url, $site)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if ($site == "163") {
        $header = array(
            'X-Real-IP: 118.88.88.88',
            'Cookie: appver=2.0.2',
            'Accept-Language: zh-CN,zh;q=0.8,gl;q=0.6,zh-TW;q=0.4',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
            'Content-Type: application/x-www-form-urlencoded'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_REFERER, "http://music.163.com/");
    } else if ($site == "qq") {
        curl_setopt($ch, CURLOPT_REFERER, "http://y.qq.com/");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    } else if ($site == "kugou") {
        curl_setopt($ch, CURLOPT_REFERER, "http://www.kugou.com/");
    } else if ($site == "xiami") {
        curl_setopt($ch, CURLOPT_REFERER, "https://h.xiami.com/");
    }
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function post_by_curl($url, $post_data, $site)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    if ($site == "163") {
        $header = array(
            'X-Real-IP: 118.88.88.88',
            'Cookie: appver=2.0.2',
            'Accept-Language: zh-CN,zh;q=0.8,gl;q=0.6,zh-TW;q=0.4',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
            'Content-Type: application/x-www-form-urlencoded'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_REFERER, "http://music.163.com/");
    } else if ($site == "qq") {
        curl_setopt($ch, CURLOPT_REFERER, "http://y.qq.com/");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    } else if ($site == "kugou") {
        curl_setopt($ch, CURLOPT_REFERER, "http://www.kugou.com/");
    } else if ($site == "xiami") {
        curl_setopt($ch, CURLOPT_REFERER, "https://h.xiami.com/");
    }
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

// Thanks to https://github.com/metowolf/Meting/blob/master/src/Meting.php
function encrypt_id($id)
{
    $str1 = str_split('3go8&$8*3*3h0k(2)2');
    $str2 = str_split($id);
    for ($i = 0; $i < count($str2); $i++) {
        $str2[$i] = chr(ord($str2[$i]) ^ ord($str1[$i % count($str1)]));
    }
    $result = base64_encode(md5(implode('', $str2), true));
    $result = str_replace(array('/', '+'), array('_', '-'), $result);
    return $result;
}

function urlsafe_b64encode($string)
{
    $data = base64_encode($string);
    $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
    return $data;
}

function urlsafe_b64decode($string)
{
    $data = str_replace(array('-', '_'), array('+', '/'), $string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    return base64_decode($data);
}

?>
