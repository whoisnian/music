<?php

class QQ
{
    static function get_album($id, $json_encode = false, $raw = false)
    {
        $url = "http://c.y.qq.com/v8/fcg-bin/fcg_v8_album_info_cp.fcg?inCharset=utf8&outCharset=utf-8&albummid=" . $id;
        $json = get_by_curl($url, "qq");
        $album = json_decode($json, true);
        if($raw) {
            if($json_encode)
                return $json;
            else
                return $album;
        }
        $album_raw = $album;
        $album = [];
        if (array_key_exists("data", $album_raw) && $album_raw["code"] == 0) {
            $album["album"] = [];
            $album["album"]["size"] = $album_raw["data"]["total_song_num"];
            $album["album"]["songs"] = [];
            foreach ($album_raw["data"]["list"] as $index => $song) {
                $album["album"]["songs"][$index] = [
                    'name' => $song["songname"],
                    'artists' => $song["singer"],
                    'id' => $song["songmid"]
                ];
            }
        }
        if ($json_encode)
            return json_encode($album);
        else
            return $album;
    }

    static function get_albums($album, $json_encode = false, $raw = false)
    {
        $url = "http://c.y.qq.com/soso/fcgi-bin/client_search_cp?t=8&p=1&n=30&inCharset=utf8&outCharset=utf-8&format=json&w=" . $album;
        $json = get_by_curl($url, "qq");
        $albums = json_decode($json, true);
        if($raw) {
            if($json_encode)
                return $json;
            else
                return $albums;
        }
        $albums_raw = $albums;
        $albums["result"] = [];
        if (array_key_exists("data", $albums_raw) && $albums_raw["data"]["album"]["totalnum"] > 0) {
            $albums["result"]["albumCount"] = $albums_raw["data"]["album"]["totalnum"];
            $albums["result"]["albums"] = [];
            foreach ($albums_raw["data"]["album"]["list"] as $index => $album) {
                $albums["result"]["albums"][$index] = [
                    "id" => $album["albumMID"],
                    "publishTime" => strtotime($album["publicTime"]) * 1000,
                    "name" => $album["albumName"],
                    "artist" => ["name" => $album["singerName"]],
                ];
            }
        }
        if ($json_encode)
            return json_encode($albums);
        else
            return $albums;
    }

    static function get_playlist($id, $json_encode = false, $raw = false)
    {
        $url = "https://c.y.qq.com/qzone/fcg-bin/fcg_ucc_getcdinfo_byids_cp.fcg?inCharset=utf8&outCharset=utf-8&format=json&type=1&disstid=" . $id;
        $json = get_by_curl($url, "qq");
        $playlist = json_decode($json, true);
        if($raw) {
            if($json_encode)
                return $json;
            else
                return $playlist;
        }
        $playlist_raw = $playlist;
        $playlist = [];
        if (array_key_exists("cdlist", $playlist_raw) && count($playlist_raw["cdlist"]) && $playlist_raw["cdlist"][0]["total_song_num"] > 0) {
            $playlist["result"] = [];
            $playlist["result"]["trackCount"] = $playlist_raw["cdlist"][0]["total_song_num"];
            $playlist["result"]["tracks"] = [];
            foreach ($playlist_raw["cdlist"][0]["songlist"] as $index => $song) {
                $playlist["result"]["tracks"][$index] = [
                    "name" => $song["songname"],
                    "artists" => $song["singer"],
                    "id" => $song["songmid"]
                ];
            }
        }
        if ($json_encode)
            return json_encode($playlist);
        else
            return $playlist;
    }

    static function get_playlists($playlist, $json_encode = false, $raw = false)
    {
        $url = "http://c.y.qq.com/soso/fcgi-bin/client_music_search_songlist?page_no=0&num_per_page=30&inCharset=utf8&outCharset=utf-8&format=json&query=" . $playlist;
        $json = get_by_curl($url, "qq");
        $playlists = json_decode($json, true);
        if($raw) {
            if($json_encode)
                return $json;
            else
                return $playlists;
        }
        $playlists_raw = $playlists;
        $playlists = [];
        if ($playlists_raw && array_key_exists("data", $playlists_raw) && $playlists_raw["data"]["sum"] > 0) {
            $playlists['result'] = [];
            $playlists["result"]["playlistCount"] = $playlists_raw["data"]["sum"];
            $playlists["result"]["playlists"] = [];
            foreach ($playlists_raw["data"]["list"] as $index => $playlist) {
                $playlists["result"]["playlists"][$index] = [
                    "id" => $playlist["dissid"],
                    "name" => $playlist["dissname"],
                    "creator" => ["nickname" => $playlist["creator"]["name"]],
                    "trackCount" => $playlist["song_count"]
                ];
            }
        }
        if ($json_encode)
            return json_encode($playlists);
        else
            return $playlists;
    }

    static function get_song($id, $json_encode = false, $raw = false)
    {
        $url = "http://c.y.qq.com/v8/fcg-bin/fcg_play_single_song.fcg?inCharset=utf8&outCharset=utf-8&format=json&songmid=".$id;
        $json = get_by_curl($url, "qq");
        $song_detail = json_decode($json, true);
        if ($raw) {
            if ($json_encode)
                return $json;
            else
                return $song_detail;
        }
        $song = null;
        if($song_detail["data"] != NULL && $song_detail["code"] == 0) {
            $guid = rand(1000000000, 2000000000);
            $key_url = "http://base.music.qq.com/fcgi-bin/fcg_musicexpress.fcg?json=3&inCharset=utf8&outCharset=utf-8&format=json&guid=".$guid;
            $key_detail = get_by_curl($key_url, "qq");
            $key = json_decode($key_detail, true)["key"];
            $link = "https://dl.stream.qqmusic.qq.com/M500".$id.".mp3?vkey=".$key."&guid=".$guid."&fromtag=64";

            $song = [];
            $song["album"] = [
                "picUrl" => 'https://y.gtimg.cn/music/photo_new/T002R300x300M000'.$song_detail["data"][0]["album"]["mid"].'.jpg',
                "id" => $song_detail["data"][0]["album"]["mid"],
                "name" => $song_detail["data"][0]["album"]["name"],
            ];
            $song["artists"] = $song_detail["data"][0]["singer"];
            $song["name"] = $song_detail["data"][0]["name"];
            $song["link"] = $link;
        }
        if ($json_encode)
            return json_encode(['code' => 200, 'song' => $song]);
        else
            return $song;
    }

    static function get_songs($song, $json_encode = false, $raw = false)
    {
        $url = "http://c.y.qq.com/soso/fcgi-bin/client_search_cp?new_json=1&cr=1&p=1&n=30&inCharset=utf8&outCharset=utf-8&format=json&w=" . $song;
        $json = get_by_curl($url, "qq");
        $songs = json_decode($json, true);
        if($raw) {
            if($json_encode)
                return $json;
            else
                return $songs;
        }
        $songs_raw = $songs;
        $songs = [];
        if (array_key_exists("data", $songs_raw) && $songs_raw["data"]["song"]["totalnum"] > 0) {
            $songs["result"] = [];
            $songs["result"]["songCount"] = $songs_raw["data"]["song"]["totalnum"];
            $songs["result"]["songs"] = [];
            foreach ($songs_raw["data"]["song"]["list"] as $index => $song) {
                $songs["result"]["songs"][$index] = [
                    "name" => $song["name"],
                    "artists" => $song["singer"],
                    "id" => $song["mid"]
                ];
            }
        }
        if ($json_encode)
            return json_encode($songs);
        else
            return $songs;
    }
}