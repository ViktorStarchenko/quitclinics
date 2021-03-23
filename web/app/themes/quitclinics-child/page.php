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
        <?php get_template_part('template-parts/page/layout', 'page-content'); ?>
    </main>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>