


<div  class="panel panel-default">
    <div class="panel-heading">
        <h4>Informations</h4>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id_Album</th>
                        <th>Image</th>
                        <th>Artiste</th>
                        <th>Album</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $html = '';
                    $i=1;

                    foreach( $albums as $a )
                    {

                        $html .= '<tr>';
                        $html .= '<td>'.$a['id_album'].'</td>';

                        if( isset( $a['id_image'] ) )
                            $html .= '<td><img style="width: 70px" src="images/small/'.$a['id_image'].'_small'.$a['extension'].'" />';
                        else
                            $html .= '<td></td>';
                        $html .= '<td>'.$a['name'].'</td><td>'.$a['title'].'</td><td><a  href="index.php?controller=admin&action=edit&id_album='.$a['id_album'].'" class="btn btn-default"><i class="fa fa-pencil"></i> Modifier</button></td>';

                        $html  .= '</tr>';
                    }
                    echo $html;
                ?>
                </tbody>
            </table>
        </div>
    <!-- ./ table-responsive -->
    </div>
    <!-- ./ panel-body -->
</div>
<!-- ./ .panel-default -->