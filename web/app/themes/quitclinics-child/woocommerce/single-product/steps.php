<?php
/**
 * Single Product steps
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/steps.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce\Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>

<?php if (get_field('steps')) : ?>
    <?php foreach(get_field('steps') as $tt) {

    } ?>
    <div class="product-steps">

        <?php foreach(get_field('steps') as $step) : ?>

            <div class="product-steps-item">
            <?php if ($step['steps_body']['icon']) : ?>
                <div class="product-steps-icon">
                    <img src="<?php echo $step['steps_body']['icon']['url']; ?>" alt="<?php echo $step['steps_body']['icon']['title']; ?>">
                </div>
            <?php endif; ?>
            <?php if ($step['steps_body']['text']) : ?>
                <div class="product-steps-text"><?php echo $step['steps_body']['text']; ?></div>
            <?php endif; ?>
            </div>
        <?php endforeach; ?>

    </div>
<?php endif; ?>