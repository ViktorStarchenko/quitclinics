<?php /* Template Name: Page with left menu */ ?>
<?php get_header(); ?>
    <main id="content">
    	<header class="header">
            <div class="row wrapper-1240">
    			<h1 class="entry-title"><?php the_title(); ?></h1> 
            </div>
		</header>
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
        <section>
            <div class="row wrapper-1240">
                <div class="lm-templ-wrp">
                    <div class="lm-templ-menu-wrapper">
                        <?php wp_nav_menu( array( 'theme_location' => 'new-left-menu', 
                            'container_class' => 'left-menu-class' ) ); 
                        ?>
                    </div>
                    <div class="lm-templ-content-wrapper">
                        <div class="lm-templ-content">
                            <?php the_content(); ?>
                        </div>   


                    </div>
                </div>
            </div>
        </section>
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
<!--    <script type="text/javascript">-->
<!--        $(function() {-->
<!--            $('.left-menu-class').click(function() {-->
<!--              $(this).addClass('left-menu-mobile-visible')-->
<!--            });-->
<!--        });-->
<!--    </script>-->
<?php wp_enqueue_script( 'left-menu', get_theme_file_uri( '/assets/js/left-menu.js' ), array('jq-351'), '1', true ); ?>

<?php get_footer(); ?>