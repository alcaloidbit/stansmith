<div class="col-lg-6" >
	<div class="panel-group" id="accordion">
		<div class="panel  panel-default" id="view-album">
			<div class="panel-heading" >
				<h3 ><a data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne" href="#collapseOne"><?php echo $album->title  ?> - <?php echo $album->artistName ?><i class="fa fa-minus"></i></a></h3>
			</div>
			<div id="collapseOne" class="panel-collapse collapse in">
				<div class="panel-body release">

						<?php
							if( $album->images )
							{
								echo '<div class="col-lg-6 img-wrapper">';
								foreach ($album->images  as $key => $image)
									echo '<img src="'._BASE_URI_.'images/'.$image['id_image'].$image['extension'].'"  class="img-responsive"/>';
								echo '</div>';
							}
						?>

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
		</div>
	</div>
	<a href="index.php?controller=admin&action=askdiscogsforimages" data-id_album="<?php echo $album->id ?>"  class="btn btn-sky btn-lg btn-block ladda-button askdiscogs" data-style="zoom-in" ><span class="ladda-label">Ask Discogs</span></a>
</div>
<div class="col-lg-6">
<form id="upload" method="post" action="index.php?controller=admin&action=addImage&id_album=<?php echo $album->id ?>" enctype="multipart/form-data">
	<div id="drop">
		Drop Here

		<a>Browse</a>
		<input type="file" name="upl" multiple />
	</div>

	<ul>
		<!-- The file uploads will be shown here -->
	</ul>

</form>
</div>
<div class="delegater">
<div class="col-lg-6 discogs-resp" >
</div>
</div>


