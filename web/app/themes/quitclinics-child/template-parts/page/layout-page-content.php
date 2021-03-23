
<?php

// Show the selected front page content.
if( have_rows('page_content') ): ?>

    <?php while( have_rows('page_content') ) : the_row(); ?>

        <?php if(get_row_layout() == 'banner_section'): ?>

            <?php get_template_part('template-parts/section/section', 'banner'); ?>

        <?php endif; // end get_row_layout (banner_section) if ?>
    
        <?php if(get_row_layout() == 'three_icons_section'): ?>

            <?php get_template_part('template-parts/section/section', 'three-icons'); ?>

        <?php endif; // end get_row_layout (three_icons_section) if ?>

        <?php if(get_row_layout() == 'bg_img_text_right_section'): ?>

            <?php get_template_part('template-parts/section/section', 'bg-img-text-right'); ?>

        <?php endif; // end get_row_layout (bg_img_text_right_section) if ?>

        <?php if(get_row_layout() == 'bg_img_text_left_section'): ?>

            <?php get_template_part('template-parts/section/section', 'bg-img-text-left'); ?>

        <?php endif; // end get_row_layout (bg_img_text_left_section) if ?>

        <?php if(get_row_layout() == 'centered_text_section'): ?>

            <?php get_template_part('template-parts/section/section', 'centered-text'); ?>

        <?php endif; // end get_row_layout (centered_text_section) if ?>


        <?php if(get_row_layout() == 'test'): ?>

            <?php get_template_part('template-parts/section/section', 'test'); ?>

        <?php endif; // end get_row_layout (test) if ?>


        <?php if(get_row_layout() == 'auth'): ?>

            <?php get_template_part('template-parts/section/section', 'login'); ?>

        <?php endif; // end get_row_layout (auth) if ?>

    <?php endwhile; // end have_rows while ?>

<?php endif; // end have_rows if ?>