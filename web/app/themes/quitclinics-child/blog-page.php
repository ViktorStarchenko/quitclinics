<?php
/*
 * Template Name: Blog Page
 * Template Post Type: page
 */?>
<?php get_header(); ?>
<main id="content">
    <?php if(get_field('featured_post')) : ?>
        <section class="post-banner-section post-banner-section-featured">
            <div class="post-banner-wrapper">



                <?php
                $featured_post = get_field('featured_post');

                $postssl = array(
                    'post_type' => 'blog',
                    'post_status' => 'publish',
                    'posts_per_page' => 1,
                    'meta_key' => '_is_ns_featured_post',
                    'meta_value' => 'yes'
                );
                $catquery = new WP_Query( $postssl ); ?>
                <?php while($catquery->have_posts()) : $catquery->the_post(); ?>
                    <?php
                    if( have_rows('post_header', $featured_post->ID) ):
                        while ( have_rows('post_header', $featured_post->ID) ) : the_row();
                            $bg_color = get_sub_field('post_header_background', $featured_post->ID);
                            $heading_block = get_sub_field('post_header_content_heading', $featured_post->ID);
                            $text_block = get_sub_field('post_header_content_editor', $featured_post->ID);?>
                            <div class="post-banner-content-block post-banner-block" style="background-color: <?php echo $bg_color ?> ">
                                <div class="post-banner-content-wrapper">
                                    <div class="post-banner-content">
                                        <span class="title-h1"><?php echo $heading_block ?></span>
                                        <?php if ($text_block) : ?>
                                            <?php echo $text_block ?>
                                        <?php endif ?>
                                        <div class="blog-button-top-wrapper">
                                            <a href="<?php the_permalink() ?>" class="btn-body btn-white">Read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-banner-image post-banner-block" style="background-image: url(<?php echo get_the_post_thumbnail_url($featured_post->ID);?>); "></div>
                        <?php endwhile; endif; ?>
                <?php endwhile; ?>
                <?php wp_reset_query(); ?>
            </div>
        </section>
    <?php endif ?>
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

    <section>
        <div class="row wrapper-1240">
            <div class="blog-title">
                <h1 class="title-h3">
                    <span style="color: #332ce6;">Learn More & Blog</span>
                </h1>
            </div>
        </div>

    </section>

    <section class="post-slider-section blog-posts-section">
        <div class="row wrapper-1240 post-slider-wrapper">
            <div class="post-slider">
                <!--            $query = new WP_Query('cat=2&posts_per_page=3&paged=' . $paged);-->
                <!--            $query = new WP_Query('cat=2&posts_per_page='.$count_items.'&paged=' . $paged);-->
                <?php
                $paged = get_query_var('paged') ? get_query_var('paged') : 1;//Получаем текущую страницу
                $count_items = 3;//кол-во выводимых элементов


                $post_type =  get_field('post_type');
                $post_per_page =  get_field('posts_per_page');
                $order =  get_field('order');

                $postssl = array(
                    'post_type' => $post_type,
                    'post_status' => 'publish',
                    'posts_per_page' => $post_per_page,
                    'paged' => $paged,
                    'order'    => $order,
                );
                $blogQuery = new WP_Query( $postssl ); ?>
                <?php while($blogQuery->have_posts()) : $blogQuery->the_post(); ?>
                    <div class="post-slider-block">
                        <p>
                            <a href="<?php the_permalink() ?>" rel="bookmark">
                                <figure>
                                    <img alt="<?php the_title(); ?>" src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>">
                            </figure>
                        </a>
                    </p>
					<h6><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h6>
                        <div class="post-slider-excerpt"><?php the_excerpt(); ?></div>
                    </div>
                <?php endwhile; ?>
                <?php wp_reset_query(); ?>
            </div>
        </div>
    </section>

    <div>
        <div class="wrapper-1240">
            <?php $countcat = wp_count_posts( 'blog', false ); //echo $countcat->publish; ?>
            <?php $current_count = intval($post_per_page) * intval($paged);
            if ($current_count >= $countcat->publish) {
                $current_count = $countcat->publish;
            }  ?>
            <?php if  ( $post_per_page < $countcat->publish ) { ?>
                <?php $test = new WP_Query('post_type=blog&posts_per_page='.$count_items.'&paged=' . $paged); ?>
                <div class="pagination-wrap">
                    <div class="pagination-info">
                        You've viewed <?php echo $current_count; ?> of <?php echo $countcat->publish ; ?> items
                    </div>
                    <?php wp_pagenavi( array( 'query' => $blogQuery ) );//вывод пагинации по вашему запросу. Все четко:)) ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php

    // Show the selected front page content.
    if( have_rows('page_content') ): ?>

        <?php while( have_rows('page_content') ) : the_row(); ?>

            <?php if(get_row_layout() == 'centered_text_section'): ?>

                <?php get_template_part('template-parts/section/section', 'centered-text'); ?>


            <?php endif; // end get_row_layout (centered_text_section) if ?>


        <?php endwhile; // end have_rows while ?>

    <?php endif; // end have_rows if ?>



</main>
<?php get_footer(); ?>
