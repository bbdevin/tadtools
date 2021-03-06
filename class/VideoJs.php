<?php

namespace XoopsModules\Tadtools;

class VideoJs
{
    public $image;
    public $file;
    public $mode;
    public $id;
    public $autoplay;
    public $loop;
    public $position;

    //建構函數
    public function __construct($id = '', $file = '', $image = '', $mode = '', $autoplay = 'false', $loop = 'false', $position = 'bottom')
    {
        $this->file = ('playlist' === $mode) ? $file : strip_tags($file);
        $this->youtube_id = $this->getYTid($file);
        $this->image = empty($image) ? "https://i3.ytimg.com/vi/{$this->youtube_id}/0.jpg" : strip_tags($image);
        $this->mode = $mode;
        $this->id = $id;
        $this->autoplay = $autoplay !== 'true' ? 'false' : 'true';
        $this->loop = $loop !== 'true' ? 'false' : 'true';
        $this->position = $position !== 'right' ? 'bottom' : 'right';
    }

    //設定自定義影片檔
    public function setFile($file = '')
    {
        $this->file = $file;
    }

    //設定自定義縮圖
    public function setImage($image = '')
    {
        $this->image = $image;
    }

    //產生播放器
    public function render()
    {
        global $xoTheme;
        $player = '
        <video
            id="' . $this->id . '"
            class="video-js vjs-fluid vjs-big-play-centered vjs-theme-fantasy">
        </video>
        ';

        if ('playlist' === $this->mode) {
            if ($this->position == 'right') {
                $player = '
                <div class="row">
                    <div class="col-sm-8">
                        ' . $player . '
                    </div>
                    <div class="col-sm-4 ' . $this->id . '">
                        <div class="vjs-playlist"></div>
                    </div>
                </div>
                ';
            } else {
                $player .= '<div class="vjs-playlist"></div>';
            }
        }

        $playlist = $source = '';

        if ('playlist' === $this->mode) {
            $playlist = "
            var samplePlaylist ={$this->file};
            player.playlist(samplePlaylist);
            player.playlist.autoadvance(0);
            player.playlistUi();
            ";

            if ($this->position == 'right') {
                $playlist .= "
                $(document).ready(function(){
                    var h=$('#" . $this->id . ">.vjs-poster').height();
                    console.log('h:'+h);
                    $('." . $this->id . ">.vjs-playlist').css('max-height', h).css('overflow', 'auto');
                });
                ";
            }
        } elseif ($this->youtube_id) {
            $source = "
            techOrder: ['youtube'],
            sources: [
                {
                    'type': 'video/youtube',
                    'src': 'https://www.youtube.com/watch?v=" . $this->youtube_id . "'
                }
            ],";
        } else {
            $ext = substr($this->file, -3);
            if ('mp4' === $ext) {
                $type = 'video/mp4';
            } elseif ('ebm' === $ext) {
                $type = 'video/webm';
            } elseif ('mp3' === $ext) {
                $type = 'audio/mp3';
            } elseif ('ogg' === $ext) {
                $type = 'video/ogg';
            } elseif ('flv' === $ext) {
                $type = 'video/x-flv';
            }

            $source = "
            poster: '{$this->image}',
            sources: [
                {
                    'type': '$type',
                    'src': '{$this->file}'
                }
            ],";
        }

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/video-js/video.js');
            $xoTheme->addScript('modules/tadtools/video-js/lang/zh-TW.js');
            $xoTheme->addScript('modules/tadtools/video-js/Youtube.js');
            $xoTheme->addScript('modules/tadtools/video-js/videojs-flash.min.js');
            $xoTheme->addStylesheet('modules/tadtools/video-js/video-js.css');
            $xoTheme->addStylesheet('modules/tadtools/video-js/themes/fantasy/index.css');
            if ('playlist' === $this->mode) {
                $xoTheme->addScript('modules/tadtools/video-js/videojs-playlist.js');
                $xoTheme->addScript('modules/tadtools/video-js/videojs-playlist-ui.js');
                $xoTheme->addStylesheet('modules/tadtools/video-js/videojs-playlist-ui.vertical.css');
            }
        } else {
            $playlist_js = '';
            if ('playlist' === $this->mode) {
                $playlist_js = "
                <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/video-js/videojs-playlist-ui.vertical.css'>
                <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/video-js/videojs-playlist.js'></script><script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/video-js/videojs-playlist-ui.js'></script>";
            }
            $player .= "
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/video-js/video.js'></script>
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/video-js/lang/zh-TW.js'></script>
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/video-js/Youtube.js'></script>
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/video-js/videojs-flash.min.js'></script>
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/video-js/video-js.css'>
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/video-js/themes/fantasy/index.css'>
            $playlist_js
            ";
        }

        $player .= "
        <script>
            var options = {
                $source
                responsive: true,
                controls: true,
                fill: true,
                loop: {$this->loop},
                autoplay: {$this->autoplay},
                language: 'zh-TW',
                liveui: true
            };
            var player = videojs('#{$this->id}', options);
            $playlist
        </script>";
        return $player;
    }

    //抓取 Youtube ID
    public function getYTid($ytURL = '')
    {
        if ('https://youtu.be/' === mb_substr($ytURL, 0, 17)) {
            return mb_substr($ytURL, 16);
        }
        if ('http://youtu.be/' === mb_substr($ytURL, 0, 16)) {
            return mb_substr($ytURL, 16);
        }
        parse_str(parse_url($ytURL, PHP_URL_QUERY), $params);
        if (isset($params['v'])) {
            return $params['v'];
        }
    }
}

/*
use XoopsModules\Tadtools\VideoJs;
$VideoJs = new VideoJs($id_name, $media, $image, $mode, $autoplay, $loop, $other_code);
$player = $VideoJs->render();
 */
