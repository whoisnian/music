# music
Search your favorite music.  

## Todo
- [X] Beautify music player.  
- [X] More website supported.  
  - [X] netease.  
  - [X] qq.  
  - [X] xiami.  
  - [X] kugou.  
- [ ] Show search results with multiple services.
- [ ] Provide a reverse proxy (Premium feature).

## Set-up

Nginx,
```
location / {
    try_files $uri $uri/ $uri.php?$query_string;
}
```
Apache,
```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^([^\.]+)$ $1.php [NC,L]
```

## Known issues
* The music player's slider will be in wrong position before the song start when click the start button in iPhone.  
* Sometimes (in mobile devices) can't change the song's progress by moving the silder.  
* Can not search album and playlist in xiami music. And it is difficult to find the album_id in [www.xiami.com](http://www.xiami.com).(But easily in [h.xiami.com](https://h.xiami.com))  
* Can not get some songs' listen_url in xiami music when the server is not in China.
* Playlists of netease show one song only.

## Address
[http://music.whoisnian.com](http://music.whoisnian.com)

## Contributors

Thanks goes to these wonderful people ([emoji key](https://github.com/kentcdodds/all-contributors#emoji-key)):

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
| [<img src="https://avatars2.githubusercontent.com/u/23057947?v=4" width="80px;"/><br /><sub>whoisnian</sub>](https://github.com/whoisnian)<br />[💻](https://github.com/whoisnian/music/commits?author=whoisnian "Code") [🤔](#ideas-whoisnian "Ideas & Planning") | [<img src="https://avatars1.githubusercontent.com/u/18373361?v=4" width="80px;"/><br /><sub>hudson6666</sub>](https://github.com/hudson6666)<br />[💻](https://github.com/whoisnian/music/commits?author=hudson6666 "Code") [🤔](#ideas-hudson6666 "Ideas & Planning") |
| :---: | :---: |
<!-- ALL-CONTRIBUTORS-LIST:END -->

This project follows the [all-contributors](https://github.com/kentcdodds/all-contributors) specification. Contributions of any kind welcome!
