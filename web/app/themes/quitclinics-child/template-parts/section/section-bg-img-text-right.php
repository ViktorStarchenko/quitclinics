<?php get_template_part('template-parts/section/section', 'attributes'); ?>

<section class="bg-img-text-right acf-section-<?php echo get_row_index(); ?>
<?php  echo (get_sub_field('section_attributes')['section_class'] ? ' ' . get_sub_field('section_attributes')['section_class'] . ' ' :''); ?>"
         id="<?php  echo (get_sub_field('section_attributes')['section_id'] ?  get_sub_field('section_attributes')['section_id'] :''); ?>">
    <div class="<?php  echo (get_sub_field('section_attributes')['background_image_width'] ? ' ' . get_sub_field('section_attributes')['background_image_width'] . ' ' :''); ?> bg-image">
        <img src="<?php echo get_sub_field('section_attributes')['background_image']['url']; ?>" alt="<?php echo get_sub_field('section_attributes')['background_image']['title']; ?>">
    </div>
    <div class="row wrapper-1360">
        <div class="text-right__inner">

            <?php if(get_sub_field('content')) : ?>
                <div class="content__18px">
                    <?php  echo get_sub_field('content'); ?>
                </div>
            <?php endif; ?>

            <?php if(get_sub_field('latest_blog_posts')['show_latest_posts'] == 'true') : ?>

                <div class="latest-post__list">
                    <?php if(get_sub_field('latest_blog_posts')['heading']): ?>
                    <div class="latest-post__heading">
                        <h3><?php echo get_sub_field('latest_blog_posts')['heading']; ?></h3>
                    </div>
                    <?php endif //end heading if ?>
                    <?php

                    $post_type =  get_sub_field('latest_blog_posts')['post_type'];
                    $post_per_page =  get_sub_field('latest_blog_posts')['posts_per_page'];
                    $order =  get_sub_field('latest_blog_posts')['order'];

                    $args = array(
                        'post_type'=> $post_type,
                        'order'    => $order,
                        'posts_per_page' => $post_per_page
                    );

                    $the_query = new WP_Query( $args );
                    if($the_query->have_posts() ) : ?>

                        <?php while ( $the_query->have_posts() ) :
                            $the_query->the_post(); ?>

                            <div class="latest-post__item">
                                <div class="latest-post__title">
                                    <h5><?php the_title();?></h5>
                                </div>
                                <div class="latest-post__content">
                                    <?php echo get_excerpt(150); ?>
                                </div>

                                <a href="<?php the_permalink();?>">Learn more</a>

                            </div>


                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    <?php else: ?>
                        <p class="title-h3">no events are expected now.</p>
                    <?php endif; //end $the_query if ?>
                </div>

            <?php endif; //end latest blog post if ?>

            <?php if(get_sub_field('enable_calculator')['show_calculator'] == 'true') : ?>
            
                <?php get_template_part('template-parts/section/section', 'calculator'); ?>

            <?php endif // end calculator if ?>

            <?php if(get_sub_field('buttons_group')) : ?>
                <?php get_template_part('template-parts/section/section', 'buttons-group'); ?>
            <?php endif; ?>

        </div>
    </div>

</section>




