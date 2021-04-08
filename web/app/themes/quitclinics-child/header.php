<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />
    <?php wp_head(); ?>
    <!-- Start of quitclinics Zendesk Widget script -->
<!--    <script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=0f848e20-21ec-4306-b7ec-5c7d0e571ecc"> </script>-->
    <!-- End of quitclinics Zendesk Widget script -->



    <script>

        function addScript(src){
            var script = document.createElement('script');
            script.src = src;
            script.async = false; // чтобы гарантировать порядок
            script.id = 'ze-snippet'
            document.head.appendChild(script);
        }

        function add_zendesk(){

            addScript('https://static.zdassets.com/ekr/snippet.js?key=0f848e20-21ec-4306-b7ec-5c7d0e571ecc')

        }
        setTimeout(add_zendesk, 6000)
    </script>
</head>


<?php
if (get_field('menu_name', 'option')) :
$mein_menu = wp_get_menu_array(get_field('menu_name', 'option'));
endif
?>

<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">
    <header class="header_fixed" id="header">
        <nav class="wrapper-1360" id="menu">
            <input class="nav-menu-toggle" type="checkbox" />
            <span class="nav-menu-toggle-icon"></span>
            <?php if(get_field('logo_image', 'option')) : ?>
            <a class="menu-logo" <?php if(is_front_page()) { ?>  <?php } else { ?> href="<?php echo home_url();?>" <?php } ?> >
                <img src="<?php echo get_field('logo_image', 'option')['url']; ?>" alt="<?php echo get_field('logo_image', 'option')['title']; ?>" >
            </a>
            <?php endif ?>
            <ul class="nav-wrap">
                <?php if($mein_menu) : ?>
                <?php  foreach ($mein_menu as $menu_item): ?>
                    <li class="<?php  echo (($menu_item['children']) ?  'has-child' : ''); ?>">
                        <a href="<?php echo $menu_item['url'] ?>"><?php echo $menu_item['title'] ?></a>
                        <?php  if ($menu_item['children']) : ?>
                        <span class="dropdown-arrow"></span>
                        <ul>
                            <span class="submenu-title"><?php echo $menu_item['title'] ?></span>
                            <?php foreach ($menu_item['children'] as $submenu_item) : ?>
                                <?php
                                $url =                $submenu_item['url'];
                                $new_url = setAnchor($url);
                                ?>
                            <li>
                                <a href="<?php echo $new_url; ?>"><?php echo $submenu_item['title'] ?></a>
                                <?php if ($submenu_item['children']) : ?>
                                    <ul class="submenu subchildren-list">
                                        <?php foreach ($submenu_item['children'] as $subchildren) : ?>

                                            <li><a href="<?php echo $subchildren['url'] ?>"><?php echo $subchildren['title'] ?></a></li>
                                        <?php endforeach //END SUBCHILDREN LOOP ?>
                                    </ul>
                                <?php endif // END SUBCHILDREN IF?>
                            </li>
                            <?php endforeach //END CHILDREN LOOP ?>
                        </ul>
                        <?php endif ?>
                    </li>

                <?php endforeach //$mein_menu ?>
                <?php endif //$mein_menu?>
<!--                --><?php //if (get_field('account', 'option')['show_account_link'] == 'true') : ?>
<!--                <li>-->
<!--                    <a href="--><?php //echo get_field('account', 'option')['account_link']['url']; ?><!--">--><?php //echo get_field('account', 'option')['account_link']['title']; ?><!--</a>-->
<!--                </li>-->
<!--                --><?php //endif; ?>
            </ul>


            <div class="nav-btn">
                <?php if (get_field('account', 'option')['show_account_link'] == 'true') : ?>
                    <?php cshlg_link_to_login(); ?>
                <?php endif; ?>
                <?php if(get_field('header_button_desktop', 'option')) : ?>
                <a href="<?php  echo get_field('header_button_desktop', 'option')['url']; ?>" class="btn-body btn-blue nav-menu-btn desktop" data-mob-text="Apply now"><?php  echo get_field('header_button_desktop', 'option')['title']; ?></a>
                <?php endif ?>

                <?php if(get_field('header_button_mobile' , 'option')) : ?>
                <a href="<?php  echo get_field('header_button_mobile', 'option')['url']; ?>" class="btn-body btn-blue nav-menu-btn mobile" data-mob-text="Apply now"><?php  echo get_field('header_button_mobile', 'option')['title']; ?></a>
                <?php endif ?>
            </div>
        </nav>
    </header>
    <div class="wrapper-1240">
        <?php
        /**
         * Hook: woocommerce_before_single_product.
         *
         * @hooked woocommerce_output_all_notices - 10
         */

        do_action( 'woocommerce_before_single_product' );
        ?>
    </div>
    <div id="container">