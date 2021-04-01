</div>

<?php if(get_field('nav_menu_name', 'option')) : ?>
<?php $footer_menu = wp_get_menu_array(get_field('nav_menu_name', 'option')); ?>
<?php endif ?>
<?php if(get_field('copyright_menu_name_', 'option')) : ?>
<?php $terms_policy_menu = wp_get_menu_array(get_field('copyright_menu_name_', 'option')); ?>
<?php endif ?>
<footer id="footer" class="footer">

    <div class="wrapper-1240">
        <div class="footer__wrapper">
            <div class="footer__col footer__logo-box">
                <?php if(get_field('footer_logo_image', 'option')) : ?>
                    <a class="menu-logo" <?php if(is_front_page()) { ?>  <?php } else { ?> href="<?php echo home_url();?>" <?php } ?> ">
                        <img src="<?php echo get_field('footer_logo_image', 'option')['url']; ?>" alt="<?php echo get_field('footer_logo_image', 'option')['title']; ?>" >
                    </a>
                <?php endif ?>

                <div class="footer__excerpt">
                    <?php if(get_field('footer_excerpt', 'option')) : ?>
                        <?php  echo get_field('footer_excerpt', 'option'); ?>
                    <?php endif ?>
                </div>
            </div>
            <div class="footer__col">
                <div class="footer__menu-wrapper">
                    <ul>
                        <?php if($footer_menu) : ?>
                        <?php  foreach ($footer_menu as $footer_item): ?>

                            <li>

                                <a href="<?php echo $footer_item['url'] ?>"><?php echo $footer_item['title'] ?></a>
                            </li>
                        <?php endforeach ?>
                        <?php endif //$footer_menu ?>
                    </ul>
                </div>
            </div>
            <div class="footer__col">
                <div class="subscription-wrapper">
                    <?php if(get_field('form_heading', 'option')) : ?>
                    <span class="title-h5 subscription-form-heading"><?php  echo get_field('form_heading', 'option'); ?></span>
                    <?php endif ?>
                    <?php if(get_field('form_text', 'option')) : ?>
                    <div>
                        <?php  echo get_field('form_text', 'option'); ?>
                    </div>
                    <?php endif ?>
                    <?php if(get_field('form_shotrcode', 'option')) : ?>
                        <?php   $shortcode = get_field('form_shotrcode', 'option');
                        echo do_shortcode($shortcode);?>
                    <?php endif ?>
                </div>
            </div>
        </div>

    </div>
    <div class="wrapper-1240">
        <div class="copyright">
            <div class="copyright-menu">
                <ul>
                    <?php if($terms_policy_menu) : ?>
                    <?php  foreach ($terms_policy_menu as $terms_policy_item): ?>
                    <li>
                        <a href="<?php echo $terms_policy_item['url'] ?>"><?php echo $terms_policy_item['title'] ?></a>
                    </li>
                    <?php endforeach ?>
                    <?php endif //$terms_policy_menu і?>
                </ul>
            </div>
            <?php if(get_field('form_shotrcode', 'option')) : ?>
            <div id="copyright">
                © <?php  echo get_field('copyright_text', 'option'); ?>
            </div>
            <?php endif ?>
        </div>

    </div>


<!--    TRY AGAIN MODAL-->
    <a href="#try-again" class="fancybox show-modal init-modal">MODAL</a>
    <div style="display:none; background-color: #161a1d; opacity: .5" class="fancybox-hidden">
        <div class="modal-wrap" id="try-again">
            <div class="form-wrapper popup">
                <div class="alert-body">
                    <div class="alert-block alert-heading title-h3">
                        <p class="alert-heading title-h5">Your verification has failed</p>
                    </div>
                    <div class="alert-block alert-content">
                        <p class="alert-text">Unfortunately we could not verify your identity.</p>
                        <p class="alert-text">Please check your details and <a href="#" class="try-again">try again</a> , or <a
                                    href="#" class="open-chat">contact support</a>  so that they can verify for you</p>
                    </div>
                    <div class="btn-block">
                        <a href="#" class="btn-body btn-blue try-again">Try again</a>
                        <a href="#" class="btn-body btn-lt-blue open-chat">Contact support</a>
                    </div>
                </div>
            </div>
        </div>
    </div><!--    TRY AGAIN MODAL-->




</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>