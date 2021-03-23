<?php get_header(); ?>
<main id="content">
	<section class="post-banner-section">
		<div class="post-banner-wrapper">
			<?php 
				if( have_rows('post_header') ):
    			while ( have_rows('post_header') ) : the_row();
        		$bg_color = get_sub_field('post_header_background');
        		$text_block = get_sub_field('post_header_content_editor');?>
			<div class="post-banner-content-block post-banner-block" style="background-color: <?php echo $bg_color ?> ">
				<div class="post-banner-content-wrapper">
					<div class="post-banner-content">
						<?php echo $text_block ?>
					</div>					
				</div>
			</div>			
			<div class="post-banner-image post-banner-block" style="background-image: url(<?php echo get_the_post_thumbnail_url();?>); "></div>
			<?php endwhile; endif; ?>
		</div>
	</section>
	<section class="post-content-section">
		<div class="row wrapper-1240 post-content-wrapper">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
			<?php the_content(); ?>
			<?php endwhile; endif; ?>
		</div>
	</section>
	<section class="post-slider-section">
		<div class="row wrapper-1240 post-slider-wrapper">
			<h4>Other articles</h4>
			<div class="post-slider">
				<?php $postssl = array(  
			        'post_type' => 'blog',
			        'post_status' => 'publish',
			        'posts_per_page' => 6, 
			    );
				$catquery = new WP_Query( $postssl ); ?>
				<?php while($catquery->have_posts()) : $catquery->the_post(); ?>
				<div class="post-slider-block">
					<p><a href="<?php the_permalink() ?>" rel="bookmark"><figure><img alt="<?php the_title(); ?>" src="<?php the_post_thumbnail(); ?>"></figure></a></p>
					<p class="post-slider-category"><?php the_category(); ?></p>
					<h6><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h6>
					<p class="post-slider-excerpt"><?php echo get_excerpt(90); ?>...</p>					
				</div>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
	</section>
    

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<?php wp_enqueue_script( 'slick', get_theme_file_uri( '/assets/js/slick.min.js' ), array('jq-351'), '1', true ); ?>
<!--<script type='text/javascript' src='/app/themes/quitclinics-child/assets/js/slick.min.js'></script>-->
<link rel='stylesheet' href='/app/themes/quitclinics-child/assets/css/slick.css' type='text/css' media='all' />
<script>
	$(document).ready(function() {
		if ($(window).width() < 760) {
			$('.post-slider').slick({
			  infinite: false,
			  slidesToShow: 1,
			  slidesToScroll: 1
			});
		} else {
			$('.post-slider').slick({
			  infinite: false,
			  slidesToShow: 3,
			  slidesToScroll: 1
			});
		}
	});
	$( window ).resize(function() {
		if ($(window).width() < 760) {
			$('.post-slider').slick("unslick");
			$('.post-slider').slick({
			  infinite: false,
			  slidesToShow: 1,
			  slidesToScroll: 1
			});
		} else {
			$('.post-slider').slick("unslick");
			$('.post-slider').slick({
			  infinite: false,
			  slidesToShow: 3,
			  slidesToScroll: 1
			});
		}
	});
</script>
<footer class="footer">
<?php //get_template_part( 'nav', 'below-single' ); ?>
</footer>
</main>
<?php get_footer(); ?>
