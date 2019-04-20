

<div class="col-lg-4">
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo $album->title  ?> par <?php echo $album->artistName ?></div>
		<div class="panel-body album-container">
			<div class="col-lg-6">
				<ul>
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
	<div class="panel-heading"></div>
		<div class="panel-body">
			<ul class="unstyled">
				<?php
					foreach( $imgs_uris as $uri )
					{
							echo '<li>'.$uri.'</li>';
					}
				?>
			</ul>
		</div>
	</div>
</div>

<div class="col-lg-4 discogs-resp">
	<div class="panel panel-default">
		<div class="panel-heading">
		<div class="panel-body maskwrapper" style="position:relative;">
			<div class="mask"><button data-style="zoom-in" data-size="medium" class="ladda-button btn btn-lg btn-info confimg" type="submit" name="submitRawimg" ><span class="ladda-label">Valider</span></button></div>
			<img class="img-responsive cover-img" src="data:image/jpeg;base64,<?php echo $imgdata ?>"/>

		</div>
		<div class="panel-footer">
			<form id="form" role="form" ecntype="multipart/form-data" method="POST" action="index.php?controller=admin&action=addAlbumCover">
				<input type="hidden" value="<?php echo $imgdata; ?>" name="rawimgdata" />
				<input type="hidden" value="<?php echo $album->id; ?>" name="id_album" />
				<input type="hidden" value="<?php echo $extension; ?>" name="extension" />

			</form>
		</div>
	</div>
</div>
