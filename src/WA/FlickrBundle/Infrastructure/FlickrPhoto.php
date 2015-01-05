<?php
namespace WA\FlickrBundle\Infrastructure;

class FlickrPhoto
{
    public $description;
    public $farm;
    public $id;
    public $secret;
    public $server;
    public $title;
    public $width;

    public function __construct($description,$farm,$id,$secret,$server,$title,$width)
    {
        $this->description=$description;
        $this->farm=$farm;
        $this->id=$id;
        $this->secret=$secret;
        $this->server=$server;
        $this->title=$title;
        $this->width=$width;
    }

    function getUrl()
    {
        $image_url = "https://farm".$this->farm.
            ".staticflickr.com/".$this->server."/".$this->id."_".$this->secret."_".$this->width.".jpg";
        return $image_url;
    }
    function getInfo()
    {
        //urlencode(
        $image_url = "https://photo/".$this->farm."/".$this->id."/".$this->server."/".$this->secret;
        return $image_url;
    }
}