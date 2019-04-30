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
            return _BASE_URI_.'images/thumbnails/'.$id_image.'_thumb'.$extension ;
        else if ($format == 'small')
            return _BASE_URI_.'images/small/'.$id_image.'_small'.$extension ;
        else
            return _BASE_URI_/'images/'/$id_image.$extension;
    }
}
