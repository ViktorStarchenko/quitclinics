<?php get_template_part('template-parts/section/section', 'attributes'); ?>

<section class="bg-img-text-left acf-section-<?php echo get_row_index(); ?>
<?php  echo (get_sub_field('section_attributes')['section_class'] ? ' ' . get_sub_field('section_attributes')['section_class'] . ' ' :''); ?>"
         id="<?php  echo (get_sub_field('section_attributes')['section_id'] ?  get_sub_field('section_attributes')['section_id'] :''); ?>">
    
    <div class="row wrapper-1240">
        <div class="text-left__inner">
            <div class="text-left__item">
                <?php if(get_sub_field('content')) : ?>
                    <div class="content__18px">
                        <?php  echo get_sub_field('content'); ?>
                    </div>
                <?php endif; ?>

                <?php if(get_sub_field('buttons_group')) : ?>
                    <?php get_template_part('template-parts/section/section', 'buttons-group'); ?>
                <?php endif; ?>
            </div>
            <div class="text-left__item img-box">
                <?php if(get_sub_field('image') ) : ?>
                    <img src="<?php echo get_sub_field('image')['url'] ;?>" alt="<?php echo get_sub_field('image')['title'] ;?>">
                <?php endif; ?>

            </div>


    </div>
    </div>

</section>




