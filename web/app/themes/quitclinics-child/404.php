<?php get_header(); ?>
    <main id="content">

        <article id="post-0" class="post not-found">
            <div class="wrapper-1240 text-center">

            </div>

        </article>
        <div class="">
            <div class="wrapper">
                <div class="wrapper-1240">
                    <div class="block-404__wrap">
                        <div class="block-404__content">
                            <header class="header">
                                <h1 class="entry-title"><?= get_field('404_content', 'option')['title'] ? get_field('404_content', 'options')['title'] : ''; ?></h1>
                            </header>
                            <div class="text-block">
                                <p class="title-h3 subtitle"><?= get_field('404_content', 'option')['subtitle'] ? get_field('404_content', 'options')['subtitle'] : ''; ?></p>
                            </div>
                            <div class="text-block description">
                                <?= get_field('404_content', 'option')['description'] ? get_field('404_content', 'options')['description'] : ''; ?>
                            </div>
                            <div class="block-404__buttons">
                                <?php if(get_field('404_buttons', 'option')['buttons_group']['buttons']) : ?>
                                <div class="btn-block">
                                <?php foreach(get_field('404_buttons', 'option')['buttons_group']['buttons'] as $button) : ?>
                                    <a href="<?php echo $button['button']['url'] ;?>" class="btn-body btn-blue <?php  echo ($button['anchor'] ?  ' crane ' :''); ?>" data-mob-text="Apply now"><?php echo $button['button']['title'] ;?></a>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; //edif buttons ?>
                            </div>
                        </div>
                        <div class="block-404__image">
                            <?php if (get_field('404_image', 'option')['image']) : ?>
                                <img src="<?php echo get_field('404_image', 'option')['image']['url'] ?>" alt="404">
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        </div>
    </main>

    
<?php get_footer(); ?>