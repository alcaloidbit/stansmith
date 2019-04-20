<?php
if( isset( $errors ) && $errors )
foreach( $errors as $error )
{
	echo '<div class="alert alert-danger alert-dismissable">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	        '.$error.'</div>';
}

?>
<div class="col-lg-4">
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo $album->title  ?> par <?php echo $album->artistName ?></div>
		<div class="panel-body album-container">
			<div class="col-lg-6">
				<ul class="list-unstyled">
					<?php
						foreach ( $album->songs as  $song )
						{
							?>
							<li>
								<?php echo $song['title']; ?>
							</li>
							<?php
						}
					?>
				</ul>
			</div>
		</div>
	</div>
	<!--<a href="index.php?controller=admin&action=askdiscogs&album=<?php //echo $album->title  ?> &artist=<?php // echo $album->artistName ?>"  class="btn btn-default askdiscogs">Ask Discogs</a>-->
</div>
<div class="col-lg-4">
<div class="panel-default panel">
	<div class="panel-heading"> Try another One </div>
		<div class="panel-body links-content">
			<ul class="list-unstyled">
				<?php
					foreach( $imgs_uris as $uri )
					{
							echo '<li><button class="btn btn-default btn-block" >'.$uri.'</button></li>';
					}
				?>
			</ul>
		</div>
	</div>
</div>


