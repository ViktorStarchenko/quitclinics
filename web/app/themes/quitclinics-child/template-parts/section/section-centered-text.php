 <?php get_template_part('template-parts/section/section', 'attributes'); ?>

<section class="centered-text acf-section-<?php echo get_row_index(); ?>
<?php  echo (get_sub_field('section_attributes')['section_class'] ? ' ' . get_sub_field('section_attributes')['section_class'] . ' ' :''); ?>"
         id="<?php  echo (get_sub_field('section_attributes')['section_id'] ?  get_sub_field('section_attributes')['section_id'] :''); ?>"
style="background-image: url(<?php  echo get_sub_field('section_attributes')['background_image']['url']; ?>); background-position:center; background-size: cover;">

        <div class="row wrapper-1240">

                    <?php if(get_sub_field('content')) : ?>
                        <div class="content__18px">
                            <?php  echo get_sub_field('content'); ?>
                        </div>
                    <?php endif; // endif content ?>


            <?php if(get_sub_field('buttons_group')) : ?>
                <?php get_template_part('template-parts/section/section', 'buttons-group'); ?>
            <?php endif; ?>

        </div>

</section>