<?php get_template_part('template-parts/section/section', 'attributes'); ?>
<section class="banner  acf-section-<?php echo get_row_index(); ?>
<?php  echo (get_sub_field('section_attributes')['section_class'] ?  ' ' . get_sub_field('section_attributes')['section_class'] . ' ' :''); ?>"
         id="<?php  echo (get_sub_field('section_attributes')['section_id'] ?  get_sub_field('section_attributes')['section_id'] :''); ?>">
        <div class="banner-bg">
            <img src="<?php echo get_sub_field('section_attributes')['background_image']['url']; ?>" alt="<?php echo get_sub_field('section_attributes')['background_image']['title']; ?>">
        </div>
        <div class="row wrapper-1240">
            <div class="abs-full-width banner__inner">

                <?php if(get_sub_field('content')) : ?>
                    <div class="content__18px">
                        <?php  echo get_sub_field('content'); ?>
                    </div>
                <?php endif; ?>

                <?php if(get_sub_field('buttons')) : ?>
                <div class="btn-block">
                <?php foreach(get_sub_field('buttons') as $button) : ?>
                    <a href="<?php echo $button['button']['url'] ;?>" class="btn-body btn-white <?php  echo ($button['anchor'] ?  ' crane ' :''); ?>" data-mob-text="Apply now"><?php echo $button['button']['title'] ;?></a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

</section>

<?php if(get_sub_field('advantages')) : ?>
<div class="advantages">
        <div class="wrapper-1240">
            <div class="advantages__wrapper">
                <?php foreach(get_sub_field('advantages') as $advantages_item) : ?>
                <div class="advantages__item">
                    <p> <?php echo $advantages_item['advantages_item'];?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
</div>
<?php endif; ?>


