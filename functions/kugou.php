<?php

class Kugou
{
    static function get_album($id, $json_encode = false, $raw = false)
    {
        $url = "http://mobilecdn.kugou.com/api/v3/album/song?plat=0&page=1&pagesize=-1&version=8352&albumid=" . $id;
        $json = get_by_curl($url, "kugou");
        $album = json_decode($json, true);
        if ($raw) {
            if ($json_encode)
                return $json;
            else
                return $album;
        }
        $album_raw = $album;
        $album = [];
        if ($album_raw && array_key_exists("data", $album_raw) && array_key_exists("info", $album_raw["data"]) && $album_raw["data"]["total"] > 0) {
            $album["album"] = [];
            $album["album"]["size"] = $album_raw["data"]["total"];
            $album["album"]["songs"] = [];
            foreach ($album_raw["data"]["info"] as $index => $song) {
                $ar = explode(" - ", $song["filename"], 2)[0];
                $ar = explode('、', $ar);
                $artists = [];
                foreach ($ar as $a) {
                    array_push($artists, ["name" => $a]);
                }
                $album["album"]["songs"][$index] = [
                    'name' => explode(" - ", $song["filename"], 2)[1],
                    'artists' => $artists,
                    'id' => urlsafe_b64encode(json_encode([
                        "hash" => $song["hash"],
                        "album_id" => $song["album_id"]
                    ]))
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
        $url = "http://mobilecdn.kugou.com/api/v3/search/album?page=1&pagesize=99&keyword=" . $album;
        $json = get_by_curl($url, "kugou");
        $albums = json_decode($json, true);
        if ($raw) {
            if ($json_encode)
                return $json;
            else
                return $albums;
        }
        $albums_raw = $albums;
        $albums["result"] = [];
        if ($albums_raw && array_key_exists("data", $albums_raw) && array_key_exists("info", $albums_raw["data"]) && $albums_raw["data"]["total"] > 0) {
            $albums["result"]["albumCount"] = $albums_raw["data"]["total"];
            $albums["result"]["albums"] = [];
            foreach ($albums_raw["data"]["info"] as $index => $album) {
                $albums["result"]["albums"][$index] = [
                    "id" => $album["albumid"],
                    "publishTime" => strtotime(explode(" ", $album["publishtime"], 2)[0]) * 1000,
                    "name" => $album["albumname"],
                    "artist" => ["name" => $album["singername"]],
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
        $url = "http://mobilecdn.kugou.com/api/v3/special/song?plat=0&page=1&pagesize=-1&version=8352&specialid=" . $id;
        $json = get_by_curl($url, "kugou");
        $playlist = json_decode($json, true);
        if ($raw) {
            if ($json_encode)
                return $json;
            else
                return $playlist;
        }
        $playlist_raw = $playlist;
        $playlist = [];
        if ($playlist_raw && array_key_exists("data", $playlist_raw) && array_key_exists("info", $playlist_raw["data"]) && $playlist_raw["data"]["total"] > 0) {
            $playlist["result"] = [];
            $playlist["result"]["trackCount"] = $playlist_raw["data"]["total"];
            $playlist["result"]["tracks"] = [];
            foreach ($playlist_raw["data"]["info"] as $index => $song) {
                $ar = explode(" - ", $song["filename"], 2)[0];
                $ar = explode('、', $ar);
                $artists = [];
                foreach ($ar as $a) {
                    array_push($artists, ["name" => $a]);
                }
                $playlist["result"]["tracks"][$index] = [
                    "name" => explode(" - ", $song["filename"], 2)[1],
                    "artists" => $artists,
                    "id" => urlsafe_b64encode(json_encode([
                        "hash" => $song["hash"],
                        "album_id" => $song["album_id"]
                    ]))
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
        $url = "http://specialsearch.kugou.com/special_search?platform=WebFilter&page=1&pagesize=99&iscorrection=1&keyword=" . $playlist;
        $json = get_by_curl($url, "kugou");
        $playlists = json_decode($json, true);
        if ($raw) {
            if ($json_encode)
                return $json;
            else
                return $playlists;
        }
        $playlists_raw = $playlists;
        $playlists = [];
        if ($playlists_raw && array_key_exists("data", $playlists_raw) && array_key_exists("lists", $playlists_raw["data"]) && $playlists_raw["data"]["total"] > 0) {
            $playlists['result'] = [];
            $playlists["result"]["playlistCount"] = $playlists_raw["data"]["total"];
            $playlists["result"]["playlists"] = [];
            foreach ($playlists_raw["data"]["lists"] as $index => $playlist) {
                $playlists["result"]["playlists"][$index] = [
                    "id" => $playlist["specialid"],
                    "name" => $playlist["specialname"],
                    "creator" => ["nickname" => $playlist["nickname"]],
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
        $id = json_decode(urlsafe_b64decode($id), true);
        $url = "http://www.kugou.com/yy/index.php?r=play/getdata&hash=" . $id['hash'] . "&album_id=" . $id['album_id'];
        $json = get_by_curl($url, "kugou");
        $song_detail = json_decode($json, true);
        if ($raw) {
            if ($json_encode)
                return $json;
            else
                return $song_detail;
        }
        $song = null;
        if ($song_detail["data"] != NULL && $song_detail["status"] == 1) {
            $link = $song_detail["data"]["play_url"];
            $song = [];
            $song["album"] = [
                "picUrl" => $song_detail["data"]["img"],
                "id" => $song_detail["data"]["album_id"],
                "name" => $song_detail["data"]["album_name"],
            ];
            $ar = $song_detail["data"]["author_name"];
            $ar = explode('、', $ar);
            $artists = [];
            foreach ($ar as $a) {
                array_push($artists, ["name" => $a]);
            }
            $song["artists"] = $artists;
            $song["name"] = $song_detail["data"]["song_name"];
            $song["link"] = $link;

        }
        if ($json_encode)
            return json_encode(['code' => 200, 'song' => $song]);
        else
            return $song;
    }

    static function get_songs($song, $json_encode = false, $raw = false)
    {
        $url = "http://songsearch.kugou.com/song_search_v2?platform=WebFilter&page=1&pagesize=99&iscorrection=1&keyword=" . $song;
        $json = get_by_curl($url, "kugou");
        $songs = json_decode($json, true);
        if ($raw) {
            if ($json_encode)
                return $json;
            else
                return $songs;
        }
        $songs_raw = $songs;
        $songs = [];
        if ($songs_raw && array_key_exists("data", $songs_raw) && array_key_exists("lists", $songs_raw["data"]) && $songs_raw["data"]["total"] > 0) {
            $songs["result"] = [];
            $songs["result"]["songCount"] = $songs_raw["data"]["total"];
            $songs["result"]["songs"] = [];
            foreach ($songs_raw["data"]["lists"] as $index => $song) {
                $ar = $song["SingerName"];
                $ar = explode('、', $ar);
                $artists = [];
                foreach ($ar as $a) {
                    array_push($artists, ["name" => $a]);
                }
                $songs["result"]["songs"][$index] = [
                    "name" => $song["SongName"],
                    "artists" => $artists,
                    "id" => urlsafe_b64encode(json_encode([
                        "hash" => $song["FileHash"],
                        "album_id" => $song["AlbumID"]
                    ]))
                ];
            }
        }
        if ($json_encode)
            return json_encode($songs);
        else
            return $songs;
    }
}