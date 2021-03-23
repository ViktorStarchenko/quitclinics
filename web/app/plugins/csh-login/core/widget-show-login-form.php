<?php 
/**
 * Widget Class
 */
//add_action('widgets_init', create_function('', 'return register_widget("Widget_Login");'));
//add_action ('widgets_init', create_function ('', 'return register_widget("oa_social_login_widget");'));
function oa_social_login_init_widget ()
{
    return register_widget('Widget_Login');
}
add_action ('widgets_init', 'oa_social_login_init_widget');


class Widget_Login extends WP_Widget {
    /** constructor -- name this the same as the class above */
    function __construct() {
        parent::__construct(false, $name = 'CSH Login');	
    }


    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {
        $title = "";
        if ( isset( $instance[ 'title' ] ) ) {
            $title  = esc_attr($instance['title']);
        }
        $login = "";
        if ( isset( $instance[ 'login' ] ) ) {
            $login  = esc_attr($instance['login']);
        }
        $logout = "";
        if ( isset( $instance[ 'logout' ] ) ) {
            $logout  = esc_attr($instance['logout']);
        }	

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('login'); ?>"><?php _e('Login text'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('login'); ?>" name="<?php echo $this->get_field_name('login'); ?>" type="text" value="<?php echo $login; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('logout'); ?>"><?php _e('Logout text'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('logout'); ?>" name="<?php echo $this->get_field_name('logout'); ?>" type="text" value="<?php echo $logout; ?>" />
        </p>
        <?php 
    }


    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {   
        $instance = $old_instance;
        $instance['title']  = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['login']  = ( ! empty( $new_instance['login'] ) ) ? strip_tags( $new_instance['login'] ) : '';
        $instance['logout'] = ( ! empty( $new_instance['logout'] ) ) ? strip_tags( $new_instance['logout'] ) : '';
        return $instance;
    }


    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) { 
        extract( $args );
        $title  = apply_filters('widget_title', $instance['title']);
        $login  = $instance['login'];
        $logout = $instance['logout'];
        echo $before_widget;
        if ( $title ) echo $before_title . $title . $after_title;

        if (is_user_logged_in()){
            ?>
            <ul>
            <li><a href="<?php echo wp_logout_url()?>"><?php echo $logout; ?></a></li>
            </ul>
            <?php
        }

        if (!is_user_logged_in()) {
            ?>
            <a class="go_to_login_link" href="<?php echo wp_login_url() ?>" ><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
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
        echo $after_widget;
    }
} // end class Widget_Login

?>
