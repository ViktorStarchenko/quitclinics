<?php get_header(); ?>
<main id="content">
    <?php if( have_rows('post_header') ):
        while ( have_rows('post_header') ) : the_row(); ?>
            <?php if (get_sub_field('enable') == true) {?>
                <?php
                $bg_color = get_sub_field('post_header_background');
                $heading_block = get_sub_field('post_header_content_heading');
                $text_block = get_sub_field('post_header_content_editor');
                if (get_sub_field('image')) {
                    $bg_image = get_sub_field('image')['url'];
                } else {
                    $bg_image = get_the_post_thumbnail_url();
                }
                ?>
                <section class="post-banner-section" style="background-color: <?php echo $bg_color ?> ">
                    <div class="post-banner-wrapper">

                        <div class="post-banner-content-block post-banner-block">
                            <div class="post-banner-content-wrapper">
                                <div class="post-banner-content">
                                    <?php if ($heading_block) : ?>
                                        <h1> <?php echo $heading_block ?></h1>
                                    <?php endif ?>
                                    <?php if ($text_block) : ?>
                                        <?php echo $text_block ?>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                        <div class="post-banner-image post-banner-block" style="background-image: url(<?php echo $bg_image;?>); "></div>

                    </div>
                </section>
            <?php } ?>
        <?php endwhile; endif; ?>
        <?php if (get_field('article_author')['show_author_breadcrums'] == true) { ?>
            <section class="section-breadcrumbs author-breadcrumbs">
                <div class="row wrapper-1240">
                    <?php if (get_field('article_author')['author']) { ?>
                    <div class="breadcrumbs"">
                        <span>
                            <a href="<?= get_field('article_author')['author_breadcumbs_link']['url']; ?>" class="home">
                                <span property="name"><?= get_field('article_author')['author_breadcumbs_text']; ?>
                                    <?php foreach(get_field('article_author')['author'] as $author) { ?>
                                        <span><?php echo $author->post_title; ?></span>
                                        <span class="slash">/</span>
                                    <?php } ?></span>
                            </a>
                        </span>
                    </div>
                    <?php } ?>

                </div>
            </section>
        <?php } ?>


	<section class="post-content-section">
		<div class="row wrapper-1240 post-content-wrapper">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
			<?php the_content(); ?>
			<?php endwhile; endif; ?>
		</div>

        <?php if (get_field('article_author')['enable'] == true) { ?>
            <div class="author-block">
                <div class="author-block__wrapper wrapper-1240">
                    <?php if (get_field('article_author')['author']) { ?>

                         <div class="author-block__list">
                            <?php foreach(get_field('article_author')['author'] as $author) { ?>
                                <div class="author-block__item">
                                    <div class="author-block__image">
                                        <?php if (get_field('author_info', $author->ID)['image']) { ?>
                                            <img src="<?php echo get_field('author_info', $author->ID)['image']['url'] ;?>" alt="<?php echo get_field('author_info', $author->ID)['image']['title'] ;?>" title="<?php echo get_field('author_info', $author->ID)['image']['title'] ;?>">
                                        <?php } ?>
                                    </div>
                                    <div class="author-block__content">
                                        <?php if ($author->post_title) { ?>
                                            <div class="author-block__name title-h5"><?php echo $author->post_title; ?></div>
                                        <?php } ?>
                                        <?php if (get_field('author_info', $author->ID)['professional_position']) { ?>
                                            <div class="author-block__position title-h6"><?php echo get_field('author_info', $author->ID)['professional_position']; ?></div>
                                        <?php } ?>
                                        <?php if (get_field('author_info', $author->ID)['description']) { ?>
                                            <div class="author-block__desctiption"><?php echo get_field('author_info', $author->ID)['description']; ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>

                </div>
            </div>
        <?php } ?>

        <?php echo do_shortcode('[Sassy_Social_Share title="Share if you care"]'); ?>
	</section>



	<section class="post-slider-section">
		<div class="row wrapper-1240 post-slider-wrapper">
			<h4>Other articles</h4>
			<div class="post-slider post-slider-init">
				<?php $postssl = array(  
			        'post_type' => 'blog',
			        'post_status' => 'publish',
			        'posts_per_page' => 6, 
			    );
				$catquery = new WP_Query( $postssl ); ?>
				<?php while($catquery->have_posts()) : $catquery->the_post(); ?>
				<div class="post-slider-block">
					<p>
                        <a href="<?php //the_permalink() ?>" rel="bookmark">
                            <figure>
                                <img alt="<?php the_title(); ?>" src="<?php echo get_the_post_thumbnail_url(get_the_ID());?>">
                            </figure>
                        </a>
                    </p>

					<h6><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h6>
					<p class="post-slider-excerpt"><?php echo get_excerpt(90); ?>...</p>					
				</div>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
	</section>
    

<!--    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>-->
<?php //wp_enqueue_script( 'slick', get_theme_file_uri( '/assets/js/slick.min.js' ), array('jq-351'), '1', true ); ?>
<!--<script type='text/javascript' src='/app/themes/quitclinics-child/assets/js/slick.min.js'></script>-->
<!--<link rel='stylesheet' href='/app/themes/quitclinics-child/assets/css/slick.css' type='text/css' media='all' />-->
<script>
	// $(document).ready(function() {
	// 	if ($(window).width() < 760) {
	// 		$('.post-slider').slick({
	// 		  infinite: false,
	// 		  slidesToShow: 1,
	// 		  slidesToScroll: 1
	// 		});
	// 	} else {
	// 		$('.post-slider').slick({
	// 		  infinite: false,
	// 		  slidesToShow: 3,
	// 		  slidesToScroll: 1
	// 		});
	// 	}
	// });
	// $( window ).resize(function() {
	// 	if ($(window).width() < 760) {
	// 		$('.post-slider').slick("unslick");
	// 		$('.post-slider').slick({
	// 		  infinite: false,
	// 		  slidesToShow: 1,
	// 		  slidesToScroll: 1
	// 		});
	// 	} else {
	// 		$('.post-slider').slick("unslick");
	// 		$('.post-slider').slick({
	// 		  infinite: false,
	// 		  slidesToShow: 3,
	// 		  slidesToScroll: 1
	// 		});
	// 	}
	// });
</script>
<footer class="footer">
<?php //get_template_part( 'nav', 'below-single' ); ?>
</footer>
</main>
<?php get_footer(); ?>
