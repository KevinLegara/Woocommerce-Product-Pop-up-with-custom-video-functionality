<?php 
// Template Name: Videos
get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<div class="container">
			<div class="pageTitle">
		 	<img src="<?php echo get_template_directory_uri().'/images/divider.png'; ?>" style="height: 15px;width: 100%;" />
				<h1><?php echo strtoupper($wp_query->queried_object->post_title); ?></h1>
				<img src="<?php echo get_template_directory_uri().'/images/divider.png'; ?>" style="height: 15px;width: 100%;" />
			</div>
		</div>

		<div class="container videoMain">
			<div class="col-md-9 videoContentPage">
				<?php echo getEmdedVideo( get_field('embed',get_field('big_box_vid','option')), 973, 545 ); ?>
				<p class="mainVideoTitle"><?php echo get_the_title(get_field('big_box_vid','option')) ?></p>
				<p class="mainVideoDesc"><?php the_field('big_box_vid_desc','option') ?></p>
				<div class="videoSearch">
					<form action="" method="GET">
						<input type="text" class="videoSearchInput" name="sv" placeholder="search videos" value="<?php echo @$_GET['sv']; ?>">
						<input type="submit" class="videoSearchSubmit" value="">
					</form>
				</div>
				<div class="videoFetch">
					<?php $query = new WP_Query( 
						array( 
							'post_type' => 'videos', 
							's' => @$_GET['sv'],
							'posts_per_page' => 10,
							'orderby' => 'title',
							'order'   => 'DESC',
							'paged' => 1
							) 
						);                  

					if ( $query->have_posts() ) :
					?>
					    <?php while ( $query->have_posts() ) : $query->the_post(); ?>   
					        <div class="col-md-6 withoutPaddingLeft vidPageBoxes">
								<?php 
								$embed = get_field('embed');
								$video = get_field('video');
								if ($embed) {
									echo getEmdedVideo( get_field('embed') ); 
								}else{
									echo getEmdedVideo( get_field('video') ); 
								}
								?>
								<p class="videoTitlePage"><?php the_title(); ?></p>
							</div>
					    <?php endwhile; wp_reset_postdata(); ?>
					<?php endif; ?>
					<div class="clearfix"></div>
				</div>
				<?php if (!isset($_GET['sv'])) { echo '<div class="loadmore">Load More...</div>'; } ?>
				 <script type="text/javascript">
				 	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
				 	var page = 2;
				 	$(document).ready(function(){
				 		$('.loadmore').on('click', function(){
				 			var data = {
				 				'action' : 'load_post_by_ajax',
				 				'page' : page,
				 				'security' : '<?php echo wp_create_nonce("load_more_posts"); ?>'
				 			}
				 			console.log(data);
				 			$.post(ajaxurl, data, function(response){
				 				$('.videoFetch').append(response);
				 				page++;
				 				console.log(response);
				 			});
				 		});
				 	});
				 </script>
			</div>

			<div class="col-md-3 videoSideBar">
				<?php get_sidebar(); ?>
				<div class="row">
				<div class="col-md-12">
					<div class="menu-sidebar-menu-container">
					<ul id="menu-sidebar-menu" class="menu">
					    <?php 
					    $sidebar_advertisement_row = get_field('sidebar_advertisement_row');
					    if ($sidebar_advertisement_row) {
					    	foreach ($sidebar_advertisement_row as $sideAds) {
						    	?>
						    	<li class="parent menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-311">
									<a href="#" class="advertisementsTitles">
									<img src="<?php echo $sideAds['sidebar_ads_image']; ?>" class="img-responsive">
									</a>
								</li>
							    <li><br/></li>
						    	<?php
						    }
					    }
					    ?>
					</ul>
					</div>
				</div>
			</div>
			</div>
		</div>
	</main>
</div>
<?php
get_footer();
?>
