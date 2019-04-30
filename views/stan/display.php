<?php


$html='';
function formatTableRow($obj, $link) {
  $row = '<tr>'.
    '<td>'.$obj->id_album.'</td>'.
    '<td><img src="'.$link->getImageLink($obj->images->id, $obj->images->extension, 'thumb').'" alt="">'.'</td>'.
    '<td>'.$obj->title.'</td>'.
    '<td>'.$obj->artist_name.'</td>'.
    '<td>'.'</td>'.
    '<td>'.$obj->date_add.'</td>'.
    '</tr>';
  return $row;
}

foreach($albums as $obj) {
  $html .= formatTableRow($obj, $link);
}
echo $html;
