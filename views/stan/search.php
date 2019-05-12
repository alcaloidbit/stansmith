<?php


foreach ($discogs_results->results as $value) {
  
   echo formatResults($value);  
    
}


function formatResults($item)
{
    return 
        '<div class="xl4 m6 s12 col">' .
          '<div class="card"> ' .
            '<div class="card-image waves-effect waves-block waves-light">' .
              '<img class="activator" src="' .$item->cover_image. '" alt=""></div>' .
              '<div class="card-content">' .
                '<h5 class="cart-title activator grey-text text-darken-4">' .$item->title.'</h5>' .
                '<p>' .$item->year.'</p>' .
                '<p>' .implode(', ', $item->format).'<p/>' .
                '<p>'.$item->resource_url.'</p>' .
                '<p>'.$item->master_url.'</p>' .
              '</div>' .
            '<div class="card-reveal">'.'</div>' .
          '</div>' .
        '</div>';
}
