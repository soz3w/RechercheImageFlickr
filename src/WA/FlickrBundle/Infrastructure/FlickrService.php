<?php
namespace WA\FlickrBundle\Infrastructure;

class FlickrService
{
    const API_KEY='814772198ec9aa500687da8dcc184605';

    function searchPhoto($tags,$width,$maximum=10)
    {


      // 7 all types
        $queryFields=array(
            'content_type'=>7,
            'per_page'=>$maximum,
            'tags'=>$tags,
            'api_key'=>FlickrService::API_KEY,
            'format'=>'json',
            'method'=>'flickr.photos.search',
            'nojsoncallback'=>1
        );

        $httpFlickrQuery="https://api.flickr.com/services/rest/?".http_build_query($queryFields);

        $rsp = file_get_contents($httpFlickrQuery);
        $rsp_obj = json_decode($rsp);
        //dump($rsp_obj);
        //die;
        //$objPhoto= new FlickrPhoto($description,$farm,$id,$secret,$server,$title);
        //$photos=array();
        $images=array();
        foreach ($rsp_obj->photos->photo as $photo) {
            $objPhoto= new FlickrPhoto(null,$photo->farm,$photo->id,$photo->secret,
                $photo->server,$photo->title,$width);
            //$urlphoto=$objPhoto->getUrl();
            //array_push($photos,$urlphoto);
            array_push($images,$objPhoto);
        }


        return $images;
    }
    function getPhotoInfos($photoId,$secret,$width='b')
    {
        $queryFields=array(
            'api_key'=>FlickrService::API_KEY,
            'photo_id'=>$photoId,
            'secret'=>$secret,
            'format'=>'json',
            'method'=>'flickr.photos.getInfo',
            'nojsoncallback'=>1
        );

        $httpFlickrQuery="https://api.flickr.com/services/rest/?".http_build_query($queryFields);

        $rsp = file_get_contents($httpFlickrQuery);
        $rsp_obj = json_decode($rsp);
        // dump($rsp_obj->photo);
        $photo=$rsp_obj->photo;
        $objPhoto= new FlickrPhoto($photo->description->_content,$photo->farm,$photo->id,$photo->secret,
            $photo->server,$photo->title,$width);

       // dump($objPhoto);
       //   die;
        return $objPhoto;

    }

}