<?php get_header(); ?>
    <main id="content">

        <?php if( is_cart() or is_checkout() or is_account_page() or is_wc_endpoint_url()){ ?>
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
        <div class="wrapper-904">
            <!--            <div id="myblock" style="height: 200px; background: beige"></div>-->
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="header">
                        <h1 class="entry-title"><?php the_title(); ?></h1> <?php edit_post_link(); ?>
                    </header>
                    <div class="entry-content">
                        <?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
                        <?php the_content(); ?>
                        <div class="entry-links"><?php wp_link_pages(); ?></div>
                    </div>
                </article>
                <!--                    --><?php //if ( comments_open() && ! post_password_required() ) { comments_template( '', true ); } ?>
            <?php endwhile; endif; ?>
        </div>
        <?php   } ?>
        <?php if( have_rows('post_header') ):
        while ( have_rows('post_header') ) : the_row(); ?>
        <?php if (get_sub_field('enable') == true) {?>
                <?php
                $bg_color = get_sub_field('post_header_background');
                $heading_block = get_sub_field('post_header_content_heading');
                $text_block = get_sub_field('post_header_content_editor');
                $bg_image = get_sub_field('image')['url'];?>
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

        <?php if (get_the_content()) {?>
            <section class="post-content-section single-blog">
                <div class="row wrapper-1240 post-content-wrapper">
                <?php if( !is_cart() && !is_checkout() && !is_account_page()  && !is_wc_endpoint_url()) {?>
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
                        <?php the_content(); ?>
                    <?php endwhile; endif; ?>

                <?php }?>
                </div>
            </section>
        <?php } ?>

        <?php get_template_part('template-parts/page/layout', 'page-content'); ?>
    </main>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>