<?php
//d($albums);
$html='';
function formatTableRow($obj) {
    $row = '<tr>'.
        '<td><img src="images/thumbnails/'.$obj->images->id.'_thumb'.$obj->images->extension.'" alt="">'.'</td>'.
        '<td>'.$obj->title.'</td>'.
        '<td>'.$obj->artist_name.'</td>'.
        '<td>'.'</td>'.
        '<td>'.$obj->date_add.'</td>'.
    '</tr>';
    return $row;
}

foreach($albums as $obj) {
    $html .= formatTableRow($obj);
}
echo $html;
