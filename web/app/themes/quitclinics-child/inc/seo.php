<?php
add_action( 'login_head', 'login_meta_description', 9);
function login_meta_description() {
    echo '<meta name="description" content="Login to your Quit Clinics account. Update your details. Check on the status of your prescription.">';
}



if(strpos($_SERVER['REQUEST_URI'], 'lost-password') !== false){
    function hook_header(){
        echo '<meta name="description" content="Lost your Quit Clinics password? No problem, we\'re here to help. Reset your password here.">';
    }
    add_action('wp_head','hook_header');
}