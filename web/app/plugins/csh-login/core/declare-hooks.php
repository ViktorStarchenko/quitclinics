<?php
//-------------------------------Add csh Login form-----------------------------
add_action('wp_footer', 'cshlg_add_login_form');

function cshlg_add_login_form() {
    // Check user can register setting.
    global $cshlg_options;
    $rgt_display = "display:none;";
    $fb_login_link = CSHLOGIN_PLUGIN_INCLUDES_URL.'login-with-facebook';
    $twitter_login_link = CSHLOGIN_PLUGIN_INCLUDES_URL.'login-with-twitter';
    $google_login_link = CSHLOGIN_PLUGIN_INCLUDES_URL.'login-with-google';

    $type_class = 'cshlg-dropdown';
    if (isset($cshlg_options['type_modal'])) {
        $type_class = $cshlg_options['type_modal'];
    }
    if ($type_class == 'Dropdown') {
        $type_class = 'cshlg-dropdown';
    }

    $display_labels = 'Labels';
    if (isset($cshlg_options['display_labels'])) {
        $display_labels = $cshlg_options['display_labels'];
    }

    if ( get_option( 'users_can_register' )) {
        $rgt_display = "";
    }

    

    ?>
    <div id="csh-login-wrap" class="<?php echo esc_attr( $type_class ) ?>">

        <div class="login_dialog">

            <a class="boxclose"></a>

            <form class="login_form" id="login_form" method="post" action="#">
                <h2>Login</h2>
                <input type="text" class="alert_status" readonly>
                <?php if ($display_labels == 'Labels'): ?>
                    <label for="login_user"> <?php _e('Email Address'); ?></label>
                <?php endif ?>
                
                <input type="text" name="login_user" id="login_user" placeholder="<?php _e('Email Address'); ?>"/>
                <?php if ($display_labels == 'Labels'): ?>
                    <label for="pass_user"> <?php _e('Password'); ?> </label>
                <?php endif ?>

                <input type="password" name="pass_user" id="pass_user" placeholder="<?php _e('Password'); ?>"/>
                <label for="rememberme" id="lb_rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever"  /> Remember Me</label>
                <button type="submit" name="login_submit" value="" class="login_submit btn-body btn-white" ><?php _e('Sign in'); ?></button>

            </form>

            <form class="register_form" id="register_form" 
                action="<?php echo home_url(); ?>" method="post">
                <h2>Registration</h2>
                <input type="text" class="alert_status" readonly>
                <?php if ($display_labels == 'Labels'): ?>
                <label for="register_user">Username</label>
                <?php endif ?>
                <input type="text" name="register_user" id="register_user" value="" placeholder="Username">
                <?php if ($display_labels == 'Labels'): ?>
                <label for="register_email">Email Address</label>
                <?php endif ?>
                <input type="email" name="register_email" id="register_email" value="" placeholder="Email Address">
                <div id="allow_pass">
                    <?php if ($display_labels == 'Labels'): ?>
                    <label for="register_pass">Password</label>
                    <?php endif ?>
                    <input type="password" name="register_pass" id="register_pass" value="" placeholder="Password">
                    <?php if ($display_labels == 'Labels'): ?>
                    <label for="confirm_pass">Confirm Password</label>
                    <?php endif ?>
                    <input type="password" name="confirm_pass" id="confirm_pass" value="" placeholder="Password">
                </div>

                <button type="submit" name="register_submit" id="register_submit" value="" class="btn-body btn-white" >Register</button>
            </form>

            <form class="lost_pwd_form" action="<?php echo home_url(); ?>" method="post">
                <h2>Forgotten Password?</h2>
                <input type="text" class="alert_status" readonly>
                <?php if ($display_labels == 'Labels'): ?>
                <label for="lost_pwd_user_email">Username or Email Adress</label>
                <?php endif ?>
                <input type="text" name="lost_pwd_user_email" id="lost_pwd_user_email" placeholder="Username or Email Adress">
                <button type="submit" name="lost_pwd_submit" id="lost_pwd_submit" value="" class="btn-body btn-white">Get New Password</button>
            </form>

            <div class="pass_and_register" id="pass_and_register">

                <a class="go_to_register_link" href="" style="<?php echo $rgt_display ?>">Register</a>
                <span style="color: black"> </span>
                <a class="go_to_lostpassword_link" href="">Forgot Password</a>
                <span style="color: black"></span>
                <a class="back_login" href="">Back to Login</a>

            </div>


        </div>
    </div>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php
}

add_action( 'plugins_loaded', 'cshlg_register_functions' ); 

function cshlg_register_functions() {
    function cshlg_link_to_login() {
        if (is_user_logged_in()){
            ?>
<!--                show my account link insteed of logout-->
            <a  class="go_to_account_link" href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ))?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                    <g fill="none" fill-rule="evenodd">
                        <g fill="#332CE6" fill-rule="nonzero">
                            <g>
                                <g>
                                    <path d="M10.002 3.552c1.06 0 1.868.36 2.431.963.343.367.528.738.604 1.009.012.042.023.085.033.128.09.375.127.755.13 1.097l.026.023c.415.388.45 1.024.016 1.833-.058.108-.132.194-.22.264-.02.015-.039.03-.058.042-.208.6-.625 1.248-1.167 1.737.039.029.096.069.17.116.204.133.446.267.723.392.15.068.305.132.466.19 1.772.639 2.572 2.04 2.708 4.176.043.667-.51 1.307-1.191 1.307H5.327c-.689 0-1.232-.649-1.192-1.324.133-2.142.918-3.47 2.71-4.116.178-.064.348-.136.508-.213.255-.123.475-.253.657-.382.099-.07.163-.122.193-.148-.555-.497-.975-1.157-1.166-1.745l-.033-.022c-.1-.07-.181-.154-.247-.27-.433-.763-.395-1.393.002-1.802l.044-.043c.003-.345.04-.731.13-1.112.01-.043.022-.086.034-.13.076-.27.261-.64.604-1.007.563-.602 1.37-.963 2.43-.963zm-1.048 7.615c-.029.064-.065.115-.112.16-.198.182-.561.439-1.084.69-.19.09-.388.175-.597.25-1.398.504-1.982 1.493-2.094 3.295-.01.16.135.333.26.333h9.346c.124 0 .27-.168.26-.314-.115-1.8-.722-2.862-2.094-3.357-.185-.067-.363-.14-.535-.218-.552-.25-.944-.505-1.162-.684-.05-.041-.088-.09-.116-.144-.324.159-.669.25-1.024.25-.366 0-.72-.097-1.048-.26zm1.048-6.681c-.8 0-1.36.25-1.75.667-.227.244-.348.485-.386.621l-.025.096c-.087.364-.112.755-.102 1.073v.035c.013.202-.107.388-.296.462.013-.005.001.002-.014.017-.087.09-.1.263.126.667l.018.011c.14.085.232.172.32.383.254.84 1.218 1.977 2.109 1.977.89 0 1.854-1.136 2.104-1.96.045-.173.14-.273.273-.358l.05-.03c.143-.272.197-.47.19-.6-.004-.056-.014-.078-.03-.093-.006-.005-.008-.007.01-.001-.208-.06-.348-.258-.335-.475l.001-.035c.01-.318-.015-.709-.102-1.073-.008-.033-.016-.065-.025-.094-.038-.138-.159-.379-.387-.623-.389-.417-.95-.667-1.75-.667z" transform="translate(-237 -20) translate(15 5) translate(222 15)"/>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </a>
<!--            <a href="--><?php //echo wp_logout_url()?><!--">Logout</a>-->
            <?php
        }

        if (!is_user_logged_in()) {
            $login_title = 'Login';
            if ( get_option( 'users_can_register' )) {
                $login_title = "Login / Register";
            }
            ?>
            <a class="go_to_login_link" href="<?php echo wp_login_url() ?>" >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                    <g fill="none" fill-rule="evenodd">
                        <g fill="#332CE6" fill-rule="nonzero">
                            <g>
                                <g>
                                    <path d="M10.002 3.552c1.06 0 1.868.36 2.431.963.343.367.528.738.604 1.009.012.042.023.085.033.128.09.375.127.755.13 1.097l.026.023c.415.388.45 1.024.016 1.833-.058.108-.132.194-.22.264-.02.015-.039.03-.058.042-.208.6-.625 1.248-1.167 1.737.039.029.096.069.17.116.204.133.446.267.723.392.15.068.305.132.466.19 1.772.639 2.572 2.04 2.708 4.176.043.667-.51 1.307-1.191 1.307H5.327c-.689 0-1.232-.649-1.192-1.324.133-2.142.918-3.47 2.71-4.116.178-.064.348-.136.508-.213.255-.123.475-.253.657-.382.099-.07.163-.122.193-.148-.555-.497-.975-1.157-1.166-1.745l-.033-.022c-.1-.07-.181-.154-.247-.27-.433-.763-.395-1.393.002-1.802l.044-.043c.003-.345.04-.731.13-1.112.01-.043.022-.086.034-.13.076-.27.261-.64.604-1.007.563-.602 1.37-.963 2.43-.963zm-1.048 7.615c-.029.064-.065.115-.112.16-.198.182-.561.439-1.084.69-.19.09-.388.175-.597.25-1.398.504-1.982 1.493-2.094 3.295-.01.16.135.333.26.333h9.346c.124 0 .27-.168.26-.314-.115-1.8-.722-2.862-2.094-3.357-.185-.067-.363-.14-.535-.218-.552-.25-.944-.505-1.162-.684-.05-.041-.088-.09-.116-.144-.324.159-.669.25-1.024.25-.366 0-.72-.097-1.048-.26zm1.048-6.681c-.8 0-1.36.25-1.75.667-.227.244-.348.485-.386.621l-.025.096c-.087.364-.112.755-.102 1.073v.035c.013.202-.107.388-.296.462.013-.005.001.002-.014.017-.087.09-.1.263.126.667l.018.011c.14.085.232.172.32.383.254.84 1.218 1.977 2.109 1.977.89 0 1.854-1.136 2.104-1.96.045-.173.14-.273.273-.358l.05-.03c.143-.272.197-.47.19-.6-.004-.056-.014-.078-.03-.093-.006-.005-.008-.007.01-.001-.208-.06-.348-.258-.335-.475l.001-.035c.01-.318-.015-.709-.102-1.073-.008-.033-.016-.065-.025-.094-.038-.138-.159-.379-.387-.623-.389-.417-.95-.667-1.75-.667z" transform="translate(-237 -20) translate(15 5) translate(222 15)"/>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </a>
            <?php
        }
    }
}

//------------------------------Add ShortCode-----------------------------------
add_shortcode( 'csh_login', 'cshlg_shortcode' );

function cshlg_shortcode() {
    $content = "";
    if (is_user_logged_in()) {
        $content = '<a href="'.wp_logout_url().'">Logout</a>';
    }else {
        $login_title = 'Login';
        if ( get_option( 'users_can_register' )) {
            $login_title = "Login / Register";
        }
        $content = '<a class="go_to_login_link" href="'.wp_login_url().'">'.$login_title.'</a>';
    }
    return $content;
}

//--------------------custom redirect logout-----------------------------------------------
add_action('wp_logout','cshlg_redirect_logout');

function cshlg_redirect_logout() {
    global $cshlg_options;
    //background color
    $logout_redirect = home_url();

    if (!empty($cshlg_options['logout_redirect'])) {
        $logout_redirect = $cshlg_options['logout_redirect'];
    }

    wp_redirect( $logout_redirect );
    exit();
}

add_action( 'load-nav-menus.php', 'cshlg_op_register_menu_meta_box' );

function cshlg_op_register_menu_meta_box() {
    add_meta_box(
        'csh-meta-box-id',
        esc_html__('CSH Login', 'text-domain'),
        'cshlg_render_menu_meta_box',
        'nav-menus',
        'side',
        'high'
    );

function cshlg_render_menu_meta_box() {
    ?>
    <div id="posttype-csh-modal-link" class="posttypediv">

        <div id="tabs-panel-csh-modal-link" class="tabs-panel tabs-panel-active">

            <ul id="csh-modal-link-checklist" class="categorychecklist form-no-clear">
                <li>
                    <label class="menu-item-title">
                        <input type="checkbox" class="menu-item-checkbox" name="menu-item[-1][menu-item-object-id]"
                        value="-1"> <?php _e( 'Login'); ?>/<?php _e( 'Logout' ); ?>
                    </label>
                    <input type="hidden" class="menu-item-type" name="menu-item[-1][menu-item-type]" value="custom">
                    <input type="hidden" class="menu-item-title" name="menu-item[-1][menu-item-title]"
                    value="<?php _e( 'Login'); ?> // <?php _e( 'Logout'); ?>">
                    <input type="hidden" class="menu-item-url" name="menu-item[-1][menu-item-url]"
                    value="#csh_modal_login">
                </li>

                <li>
                    <label class="menu-item-title">
                        <input type="checkbox" class="menu-item-checkbox" name="menu-item[-1][menu-item-object-id]"
                        value="-1"> <?php _e( 'Register'); ?>
                    </label>
                    <input type="hidden" class="menu-item-type" name="menu-item[-1][menu-item-type]" value="custom">
                    <input type="hidden" class="menu-item-title" name="menu-item[-1][menu-item-title]"
                    value="<?php _e( 'Register'); ?>">
                    <input type="hidden" class="menu-item-url" name="menu-item[-1][menu-item-url]"
                    value="#csh_modal_register">
                </li>
            </ul>

        </div>

        <p class="button-controls">
            <span class="add-to-menu">
                <input type="submit" class="button-secondary submit-add-to-menu right"
                value="<?php _e( 'Add to Menu' ); ?>" name="add-post-type-menu-item"
                id="submit-posttype-csh-modal-link">
                <span class="spinner"></span>
            </span>
        </p>

    </div>
    <?php
    }
}

// Setup modal links attributes
add_filter( 'nav_menu_link_attributes', 'cshlg_filter_modal_link_atts', 10, 3 );

function cshlg_filter_modal_link_atts($atts, $item, $args) {
    if ('#csh_modal_login' === $atts['href']) {
        if (is_user_logged_in()) {
            $atts['href'] = wp_logout_url();
        }else {
            $atts['class'] = 'go_to_login_link';
            $atts['href'] = wp_login_url(); //for the default type login.
        }
    }elseif ('#csh_modal_register' === $atts['href']) {
        if (is_user_logged_in()) {
            $atts['style'] = 'display:none;';
        }else {
            $atts['class'] = 'menu_register_link';
            global $cshlg_options;
            if ( $cshlg_options['type_modal'] == 'LinkToDefault') {
//                $atts['href'] = wp_registration_url(); //for the default registration url.
                $atts['href'] = wp_register(); //for the default registration url.
            }
        }
    }
    return $atts;
}

// Use the right label when displaying modal login/logout link
add_filter( 'wp_nav_menu_objects', 'cshlg_filter_modal_link_label' );

function cshlg_filter_modal_link_label( $items ) {
    foreach ( $items as $i => $item ) {
        if ( '#csh_modal_login' === $item->url ) {
            $item_parts = explode( ' // ', $item->title );

            if ( is_user_logged_in() ) {
                $items[ $i ]->title = array_pop( $item_parts );
            }else {
                $items[ $i ]->title = array_shift( $item_parts );
            }
        }
    }
    return $items;
}

?>