
<div  class="panel panel-default">
		<div class="panel-heading">
			<h4>Informations</h4>
	 	</div> 			
	  	<div class="panel-body">
	  		<div class="panel-group " id="accordion">
	
<?php

$html = '';

$i=1;
foreach( $data as $a )
{
			$html .= '<div class="panel panel-default">
						<div class="panel-heading cells">	
						<div class="col-lg-8">
							<h4 class="panel-title">';	
								if( isset( $a['id_image'] ) && $a['id_image'] )
									$html .= '<img style="width: 50px" src="images/small/'.$a['id_image'].'_small'.$a['extension'].'" />';
									$html .= '<a class="nodecoration" data-toggle="collapse"  data-parent= "#accordion"  href="#Collapse'.$i.'" >
									<span class="artist">'.$a['name'].'</span>-<span class="album">'.$a['title'].'</span>
									<i class="fa-plus fa"></i>
								</a>
							</h4>
						</div>
						<!-- ./ col-lg-8 -->
						<a href="" data-target="#Modal'.$a['id_album'].'"  class="btn btn-default btn-outline release" data-id_album="'.$a['id_album'].'" data-album = "'.$a['title'].'" data-artist="'.$a['name'].'" >
							<span class="fa fa-image"></span>
						</a>
					</div>
					<!-- ./ panel-heading -->
				


					<div id="Collapse'.$i.'" class="panel-collapse collapse ">
						<div class="panel-body">
						<div class="col-lg-8">
						<form role="form">';
						foreach( $a['songs'] as $song )
							$html .= '<div class="form-group">
												<div class="input-group">
													<span class="input-group-btn">
														<span class="btn-default btn">'.$song['id_song'].'</span>
													</span>
													<input type="text" class="form-control" name="" value="'.$song['title'].'">
													<span class="input-group-btn">
														<a href="" class="btn btn-default btn-outline "><i class="fa fa-pencil"></i></a>
													</span>
												</div>
											</div>
											';


						$html .= '</form>
							</div>
						</div>
					</div>
					<!-- ./ #collapse -->
				  </div>
				  <!-- ./ panel-default --> ';
$i++;
}

$html .= '
		</div> 
		<!-- ./ .accordion -->
			</div>
			<!-- ./ .panel-body -->
				</div>
				<!-- ./ panel-default -->
					</div>
					<!-- /.col-lg-12 -->
						<!-- /.page-wrapper --> ';

echo $html;
?>

