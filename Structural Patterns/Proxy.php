<?php

/**
 * Proxy design pattern.
 */

interface VideoDownloader {
    function download();
}

/*
 * Abstractions
 */
class YoutubeDownloader implements VideoDownloader {
    function download(){
        return 'YOUTUBE-DATA::SAIUSADUIJQWNMNASY261GSBANXMASUD9UI';
    }
}

class VimeoDownloader implements VideoDownloader {
    function download(){
        return 'VIMEO-DATA::AS67SATGHJASJJKNNASBBASKJNS219';
    }
}

/*
 * Proxy
 */
class CachedDownloader implements VideoDownloader {
    private $service;
    private $video;

    public function __construct(VideoDownloader $service){
        $this->service = $service;
    }

    function download(){
        if(is_null($this->video)){
            $this->video = $this->service->download();
        } else {
            echo 'Video from retrieved from cache ->';
        }

        return $this->video;
    }
}

function clientCode(VideoDownloader $service){
    echo $service->download() . '<br>';
}

$youtubeDownloader = new YoutubeDownloader();
$vimeoDownloader = new VimeoDownloader();

$cachedYoutubeDownloader = new CachedDownloader($youtubeDownloader);
$cachedVimeoDownloader = new CachedDownloader($vimeoDownloader);

clientCode($cachedYoutubeDownloader);
clientCode($cachedVimeoDownloader);
clientCode($cachedYoutubeDownloader);
clientCode($cachedYoutubeDownloader);
clientCode($cachedVimeoDownloader);

