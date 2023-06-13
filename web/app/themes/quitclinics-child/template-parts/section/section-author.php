<div class="author-block">
    <div class="author-block__wrapper wrapper-1240">
        <?php if (get_field('author_settings')['author']) { ?>

            <div class="author-block__list">
                <div class="author-block__item" style="padding-bottom: 0;">
                    <div class="author-block__name title-h5">Author</div>
                </div>

                <?php foreach(get_field('author_settings')['author'] as $author) { ?>
                    <div class="author-block__item">
                        <div class="author-block__image">
                            <?php if (get_the_post_thumbnail_url( $author->ID, 'my_thumbnail' )) { ?>
                                <?php add_image_size( 'my_thumbnail', 250, 250, true ); ?>
                                <img src="<?php echo get_the_post_thumbnail_url( $author->ID, 'my_thumbnail' ); ?>" alt="<?php echo $author->post_title ;?>" title="<?php echo $author->post_title; ?>">
                            <?php } ?>
                        </div>
                        <div class="author-block__content">
                            <?php if ($author->post_title) { ?>
                                <div class="author-block__name title-h5"><?php echo $author->post_title; ?></div>
                            <?php } ?>
                            <?php if ($author->post_content) { ?>
                                <div class="author-block__desctiption"><?php echo $author->post_content; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

    </div>
</div>
