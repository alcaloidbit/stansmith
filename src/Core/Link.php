<?php

namespace StanSmith\Core;


class Link
{
    public function  __construct()
    {
    
    } 

    public function getImageLink($id_image, $extension, $format = null)
    {
        if ($format == 'thumb')
            return _MEDIA_BASE_URI_.'images/thumbnails/'.$id_image.'_thumb'.$extension ;
        else if ($format == 'small')
            return _MEDIA_BASE_URI_.'images/small/'.$id_image.'_small'.$extension ;
        else
            return _MEDIA_BASE_URI_/'images/'/$id_image.$extension;
    }    

    public function getBaseLink()
    {
        return _BASE_URI_;         
    }

    public function getPageLink($params) 
    {
       return _BASE_URI_.'index.php?'.http_build_query($params);                
    }
    
    public function getAlbumLink($id_album)
    {
        return $this->getPageLink(array('controller' => 'stan', 'action' => 'updateAlbum', 'id_album' => $id_album));
    }
}
