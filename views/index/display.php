<div id="wrapper" class="">
<?php if(isset($artists)){ ?>
    <div id="sidebar-wrapper">
              <ul class="sidebar-nav ">
              <li class="sidebar-brand">
                    <a class="see-all" href="#">
                       See All
                    </a>
                </li>
				<?php
					$html = '';
					foreach( $artists as $k=> $a )
					{
						$html .= '<li class="sel"><a data-id_artist="'.$k.'" href="#" > '.Tools::truncate($a, 40, '...') .'</a></li>';

					}
					echo $html;
				?>
              </ul>
    </div>
<?php } ?>

    <div id="page-content-wrapper">
      <!--<a href="#menu-toggle" class="btn btn-primary" id="menu-toggle"><i class="fa fa-user"></i></a>-->
      <!-- Begin page content -->
      <div class="container-fluid" id="main">

		<?php

			// $html ='<ul>';
			// 	foreach( $albums as $album )
			// 	{
			// 		$album = new Album( $album['id_album']);

			// 		$html .= '<li class="'.$album->id_artist.' item">
			// 							<div class="_thumbl">
			// 							<a class=" ajax"  rel="album_'.$album->id.'" >
			// 			             				<img src="images/'.$album->images[0]['id_image'].$album->images[0]['extension'].'" />
			// 										<div class="caption glass">
			// 											<span class="info info-album">'.Tools::truncate($album->title, 40, '...').'</span>
			// 											<span class="info info-artist" data-id_artist="'.$album->id_artist.'">'.Tools::truncate($album->artistName, 40, '...').'</span>
			// 											<span class="utils utils-right  play"  rel="album_'.$album->id.'" ><i class="fa-play fa fa-3x"></i></span>
			// 											<!-- <span class="utils utils-left  see"  rel="album_'.$album->id.'" ><i class="fa-info-circle fa "></i>More</span> -->
			// 										</div>
			// 							</a>
			// 							</div>
			// 					  </li>';
			// 	}
			// 	$html .='</ul>';
			// echo $html;
			//
			if(isset($albums) && $albums)
			{

					$html ='<ul>';

					foreach( $albums as $album )
					{
						$album = new Album( $album['id_album']);

						$html .= '<li class="'.$album->id_artist.' item">
											<div class="_thumbl"  rel="album_'.$album->id.'">
					             				<img src="images/'.$album->images[0]['id_image'].$album->images[0]['extension'].'" />
												<div class="caption glass">
													<span class="info info-album">'.Tools::truncate($album->title, 40, '...').'</span>
													<span class="info info-artist" data-id_artist="'.$album->id_artist.'">'.Tools::truncate($album->artistName, 40, '...').'</span>
													<button class="utils utils-right play"  rel="album_'.$album->id.'" ><i class="md-icon md-36 md-light ">play_arrow</i></button>
													<!-- <span class="utils utils-left  see"  rel="album_'.$album->id.'" ><i class="fa-info-circle fa "></i>More</span> -->
												</div>
											</div>
									  </li>';
					}
					$html .='</ul>';
					echo $html;
			}
		?>
	</div>
</div>

<div class="pagination">
	<!-- <a class=" next" href="http://176.31.245.123/stansmith/index.php?controller=x&action=ajaxGetNextHtml&p=<?php echo $next_page ?>">Next</a> -->

	<a class=" next" href="http://176.31.245.123/stansmith/index.php?controller=x&action=ajaxGetNextJson&p=<?php echo $next_page ?>">Next</a>
	<!-- <img src="views/720.gif" id="preloader" alt=""> -->
	<img src="views/252.gif" id="preloader" alt="">
	<!-- <img src="views/ajax-loader-bluesquare.gif" id="preloader" alt=""> -->
	<!-- <img src="views/ajax-loader.gif" id="preloader" alt=""> -->
	<!-- <img src="views/ajax-loader_.gif" id="preloader" alt=""> -->
</div>