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
function formatTableRow($album, $link) {
  $row = '<tr>'.
    '<td>'.$album['id_album'].'</td>'.
    '<td><img src="'.$link->getImageLink($album['image']['id_image'], $album['image']['extension'], 'thumb').'" alt="">'.'</td>'.
    '<td>'.$album['title'].'</td>'.
    '<td>'.$album['artist_name'].'</td>'.
    '<td>'.$album['meta_year'].'</td>'.
    '<td>'.date("d/m/Y", strtotime($album['date_add'])).'</td>'.
    '<td><a class="btn waves-effect waves-light" href="'.$link->getAlbumLink($album['id_album']).'"> <i class="material-icons left">edit</i>Edit</a></td>'.
    '</tr>';
  return $row;
}
foreach($albums as $album) {
  $html .= formatTableRow($album, $link);
}
echo $html;
?>
            </tbody>
        </table>
      </div><!--/.card-content -->
    </div><!--/.card -->
  </div><!--/.container -->
</div><!--/.col.s12 -->
