
    <div class="col s12">
      <div class="container">
        <div class="card">
          <div class="card-content">
            <div class="card-title">
                <h4 class="card-title">Albums</h4>
            </div>
            <table>
              <thead>
                <tr>
                  <th>id_album</th>
                  <th>Cover</th>
                  <th>Title</th>
                  <th>Artist</th>
                  <th>Year</th>
                  <th>Date Add</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

<?php
$html='';
function formatTableRow($obj, $link) {
  $row = '<tr>'.
    '<td>'.$obj->id_album.'</td>'.
    '<td><img src="'.$link->getImageLink($obj->images->id, $obj->images->extension, 'thumb').'" alt="">'.'</td>'.
    '<td>'.$obj->title.'</td>'.
    '<td>'.$obj->artist_name.'</td>'.
    '<td>'.'</td>'.
    '<td>'.date("d/m/Y", strtotime($obj->date_add)).'</td>'.
    '<td><a class="btn waves-effect waves-light" href="'.$link->getAlbumLink($obj->id_album).'"> <i class="material-icons left">edit</i>Edit</a></td>'.
    '</tr>';
  return $row;
}

foreach($albums as $obj) {
  $html .= formatTableRow($obj, $link);
}
echo $html;
?>
                </tbody>
            </table>
          </div><!--/.card-content -->
        </div><!--/.card -->
      </div><!--/.container -->
    </div><!--/.col.s12 -->
