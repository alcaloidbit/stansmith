

<?php 
d($albums);
    
    $html='';
    foreach($albums as $album) 
        $html .= '<tr>'.
                '<td>'.
            $album->title .
            '</td>'.
            '<td>Truc</td></tr>';
    
   echo $html;
?>
