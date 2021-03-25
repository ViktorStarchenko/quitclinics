<?php get_template_part('template-parts/section/section', 'attributes'); ?>

<section class="three-icons acf-section-<?php echo get_row_index(); ?>
<?php  echo (get_sub_field('section_attributes')['section_class'] ?  ' ' . get_sub_field('section_attributes')['section_class'] . ' ' :''); ?>"
         id="<?php  echo (get_sub_field('section_attributes')['section_id'] ?  get_sub_field('section_attributes')['section_id'] :''); ?>"
>
    <div class="row wrapper-1240">

        <?php if(get_sub_field('content')) : ?>
            <div class="content__18px">
                <?php  echo get_sub_field('content'); ?>
            </div>
        <?php endif; ?>

        <div class="three-icons__wrapper
         <?php  echo ((get_sub_field('enable_carousel') == 'true') ? ' icons_slider adapt-1-slide ' :''); ?>">

                <?php if(get_sub_field('items')) : ?>
                    <?php foreach(get_sub_field('items') as $item) : ?>
                        <div class="three-icons__item">
                            <?php if ($item['image_box']) : ?>
                                <div class="three-icons__img">

                                    <div class="three-icons__img-box adaptive-width"
                                         style="background-color: <?php  echo ($item['image_box']['image_box_background_color'] ?  $item['image_box']['image_box_background_color'] . ';' :''); ?>"
                                         data-width-desk="<?php echo $item['image_box']['image_box_max_size_desktop']?>"
                                         data-width-mob="<?php echo $item['image_box']['image_box_max_size_mobile']?>"
                                    >
                                        <img src="<?php echo $item['image_box']['image']['url'] ?>" alt="<?php echo $item['image_box']['image']['title'] ?>">
                                    </div>
                                </div>
                            <?php endif; //image_box ?>
                            <?php if ($item['title']) : ?>
                                <div class="three-icons__title">
                                    <?php echo $item['title'] ?>
                                </div>
                            <?php endif; //title ?>
                            <?php if($item['text']) : ?>
                                <div class="three-icons__text">
                                    <?php  echo $item['text']; ?>
                                </div>
                            <?php endif; //text ?>
                            <?php if($item['link']) : ?>
                                <div class="three-icons__link">
                                    <a href="<?php  echo $item['link']['url']; ?>"><?php  echo $item['link']['title']; ?></a>
                                </div>
                            <?php endif; //link ?>

                        </div>
                    <?php endforeach; //items ?>
                <?php endif; //items ?>

        </div>

        <?php if(get_sub_field('buttons_group')) : ?>
            <?php get_template_part('template-parts/section/section', 'buttons-group'); ?>

        <?php endif; ?>

    </div>

</section>


<?php

if(get_sub_field('enable_carousel') == 'true') {
    //        slick slider styles
    wp_enqueue_style( 'swiper', get_theme_file_uri( '/assets/css/slick.css' ));
    wp_enqueue_style( 'swiper', get_theme_file_uri( '/assets/css/slick-theme.css' ));
//        swiper slider scripts
    wp_enqueue_script( 'slick-slider', get_theme_file_uri( '/assets/js/slick.min.js' ), array('jquery'), '1', true );
//        swiper slider scripts
    wp_enqueue_script( 'three-icons', get_theme_file_uri( '/assets/js/swiper-init.js' ), array('slick-slider'), '1', true );
}


?>
