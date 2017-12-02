<?php

class Xiami
{
    static function get_album($id, $json_encode = false, $raw = false)
    {
        $url = "http://api.xiami.com/web?v=2.0&app_key=1&r=album/detail&id=" . $id;
        $json = get_by_curl($url, "xiami");
        $album = json_decode($json, true);
        if ($raw) {
            if ($json_encode)
                return $json;
            else
                return $album;
        }
        $album_raw = $album;
        $album = [];
        if ($album_raw && array_key_exists("songs", $album_raw["data"]) && $album_raw["data"]["song_count"] > 0) {
            $album["album"] = [];
            $album["album"]["size"] = $album_raw["data"]["song_count"];
            $album["album"]["songs"] = [];
            foreach ($album_raw["data"]["songs"] as $index => $song) {
                $ar = $song["singers"];
                $ar = explode(';', $ar);
                $artists = [];
                foreach ($ar as $a) {
                    array_push($artists, ["name" => $a]);
                }
                $album["album"]["songs"][$index] = [
                    'name' => $song["song_name"],
                    'artists' => $artists,
                    'id' => $song["song_id"]
                ];
            }
        }
        if ($json_encode)
            return json_encode($album);
        else
            return $album;
    }

    static function get_playlist($id, $json_encode = false, $raw = false)
    {
        $url = "http://api.xiami.com/web?v=2.0&app_key=1&r=collect/detail&id=" . $id;
        $json = get_by_curl($url, "xiami");
        $playlist = json_decode($json, true);
        if ($raw) {
            if ($json_encode)
                return $json;
            else
                return $playlist;
        }
        $playlist_raw = $playlist;
        $playlist = [];
        if ($playlist_raw && array_key_exists("songs", $playlist_raw["data"]) && $playlist_raw["data"]["songs_count"] > 0) {
            $playlist["result"] = [];
            $playlist["result"]["trackCount"] = $playlist_raw["data"]["songs_count"];
            $playlist["result"]["tracks"] = [];
            foreach ($playlist_raw["data"]["songs"] as $index => $song) {
                $ar = $song["singers"];
                $ar = explode(';', $ar);
                $artists = [];
                foreach ($ar as $a) {
                    array_push($artists, ["name" => $a]);
                }
                $playlist["result"]["tracks"][$index] = [
                    "name" => $song["song_name"],
                    "artists" => $artists,
                    "id" => $song["song_id"]
                ];
            }
        }
        if ($json_encode)
            return json_encode($playlist);
        else
            return $playlist;
    }

    static function get_song($id, $json_encode = false, $raw = false)
    {
        $url = "http://api.xiami.com/web?v=2.0&app_key=1&r=song/detail&id=" . $id;
        $json = get_by_curl($url, "xiami");
        $song_detail = json_decode($json, true);
        if ($raw) {
            if ($json_encode)
                return $json;
            else
                return $song_detail;
        }
        $song = null;
        if ($song_detail && $song_detail["data"]["song"] != 0) {
            $link = $song_detail["data"]["song"]["listen_file"];
            $song = [];
            $song["album"] = [
                "picUrl" => $song_detail["data"]["song"]["logo"],
                "id" => $song_detail["data"]["song"]["album_id"],
                "name" => $song_detail["data"]["song"]["album_name"],
            ];
            $song["artists"] = [["name" => $song_detail["data"]["song"]["artist_name"]]];
            $song["name"] = $song_detail["data"]["song"]["song_name"];
            $song["link"] = $link;
        }
        if (isset($song["link"])) $song["link"] = str_replace("http://", "https://", $song["link"]);
        if (isset($song["album"]["picUrl"])) $song["album"]["picUrl"] = str_replace("http://", "https://", $song["album"]["picUrl"]);

        if ($json_encode)
            return json_encode(['code' => 200, 'song' => $song]);
        else
            return $song;
    }

    static function get_songs($song, $json_encode = false, $raw = false)
    {
        $url = "http://api.xiami.com/web?v=2.0&app_key=1&page=1&limit=99&r=search/songs&key=" . $song;
        $json = get_by_curl($url, "xiami");
        $songs = json_decode($json, true);
        if ($raw) {
            if ($json_encode)
                return $json;
            else
                return $songs;
        }
        $songs_raw = $songs;
        $songs = [];
        if ($songs_raw && array_key_exists("songs", $songs_raw["data"]) && $songs_raw["data"]["total"] > 0) {
            $songs["result"] = [];
            $songs["result"]["songCount"] = $songs_raw["data"]["total"];
            $songs["result"]["songs"] = [];
            foreach ($songs_raw["data"]["songs"] as $index => $song) {
                $songs["result"]["songs"][$index] = [
                    "name" => $song["song_name"],
                    "artists" => [["name" => $song["artist_name"]]],
                    "id" => $song["song_id"]
                ];
            }
        }
        if ($json_encode)
            return json_encode($songs);
        else
            return $songs;
    }
}