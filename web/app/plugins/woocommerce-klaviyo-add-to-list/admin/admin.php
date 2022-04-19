



<h1 class="wckl_title"><?php esc_html_e('Woocommerce Klaviyo Add to List integration Setting', 'wckl')  ?> </h1>
<div class="">
    <p>Connect your Klaviyo account using your private key and start adding <a href="<?php echo admin_url('edit.php?post_type=wckl_intergation') ?>">integrations</a> </p>
</div>

<?php settings_errors(); ?>
<div class="wckl_content">
    <form action="options.php" method="post">
        <?php
            settings_fields('wckl_settings');
            do_settings_sections('wc_kl_integration');
            submit_button();
        ?>
    </form>
</div>