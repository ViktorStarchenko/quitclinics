<?php/*
 * Template Name: Blog Page
 * Template Post Type: page
 */?>
<?php get_header(); ?>
<main id="content">
	<section class="post-banner-section post-banner-section-featured">
		<div class="post-banner-wrapper">
			<?php $postssl = array(  
			        'post_type' => 'blog',
			        'post_status' => 'publish',
			        'posts_per_page' => 1, 
			        'meta_key' => '_is_ns_featured_post', 
			        'meta_value' => 'yes'
			    );
				$catquery = new WP_Query( $postssl ); ?>
				<?php while($catquery->have_posts()) : $catquery->the_post(); ?>
			<?php 
				if( have_rows('post_header') ):
    			while ( have_rows('post_header') ) : the_row();
        		$bg_color = get_sub_field('post_header_background');
        		$text_block = get_sub_field('post_header_content_editor');?>
			<div class="post-banner-content-block post-banner-block" style="background-color: <?php echo $bg_color ?> ">
				<div class="post-banner-content-wrapper">
					<div class="post-banner-content">
						<?php echo $text_block ?>
						<div class="blog-button-top-wrapper">
							<a href="<?php the_permalink() ?>" class="btn-body btn-white">Read more</a>
						</div>
					</div>					
				</div>
			</div>			
			<div class="post-banner-image post-banner-block" style="background-image: url(<?php echo get_the_post_thumbnail_url();?>); "></div>
			<?php endwhile; endif; ?>
			<?php endwhile; ?>
			<?php wp_reset_query(); ?>
		</div>
	</section>
	<section class="section-breadcrumbs">
        <div class="row wrapper-1240">
            <div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
                <?php
                if(function_exists('bcn_display'))
                {
                bcn_display();
                }?>
            </div>
        </div>
    </section>
    <section class="section-breadcrumbs">
        <div class="row wrapper-1240">
        	
        </div>
    </section>
    <section class="post-slider-section blog-posts-section">
		<div class="row wrapper-1240 post-slider-wrapper">
			<div class="post-slider">
				<?php $postssl = array(  
			        'post_type' => 'blog',
			        'post_status' => 'publish',
			    );
				$catquery = new WP_Query( $postssl ); ?>
				<?php while($catquery->have_posts()) : $catquery->the_post(); ?>
				<div class="post-slider-block">
					<p><a href="<?php the_permalink() ?>" rel="bookmark"><figure><img alt="<?php the_title(); ?>" src="<?php the_post_thumbnail(); ?></figure></a></p>
					<p class="post-slider-category"><?php the_category(); ?></p>
					<h6><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h6>
					<p class="post-slider-excerpt"><?php echo get_excerpt(90); ?>...</p>					
				</div>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
	</section>
    


</main>
<?php get_footer(); ?>
