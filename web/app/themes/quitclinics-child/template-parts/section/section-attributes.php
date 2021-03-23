<?php if (get_sub_field('section_attributes')['content_width']['content_width_nubmers']) : ?>
    <style>
        .acf-section-<?php echo get_row_index();?> .content__18px {
            max-width: <?php echo get_sub_field('section_attributes')['content_width']['content_width_nubmers']?><?php echo get_sub_field('section_attributes')['content_width']['content_width_value']; ?>;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
<?php endif // end content_width styles ?>

<?php if (get_sub_field('section_attributes')['section_min_height']['section_height_nubmers']) : ?>
<style>
    .acf-section-<?php echo get_row_index() ?> {
        min-height: <?php echo get_sub_field('section_attributes')['section_min_height']['section_height_nubmers']?><?php echo get_sub_field('section_attributes')['section_min_height']['section_height_value']; ?>;
    }
</style>
<?php endif // end section_min_height styles ?>

<?php if (get_sub_field('section_attributes')['background_color']) : ?>
    <style>
        .acf-section-<?php echo get_row_index() ?> {
            background-color: <?php echo get_sub_field('section_attributes')['background_color']; ?>;
        }
    </style>
<?php endif // end background_color styles ?>


<?php if (get_sub_field('section_attributes')['padding']['enable_padding'] == 'true') : ?>
    <style>
        .acf-section-<?php echo get_row_index() ?> {
            padding-top: <?php echo get_sub_field('section_attributes')['padding']['padding_desktop']['padding-top']; ?>;
            padding-bottom: <?php echo get_sub_field('section_attributes')['padding']['padding_desktop']['padding-bottom']; ?>;
        }
        @media screen and (max-width: 767px) {
            .acf-section-<?php echo get_row_index() ?> {
                padding-top: <?php echo get_sub_field('section_attributes')['padding']['padding_mobile']['padding-top']; ?>;
                padding-bottom: <?php echo get_sub_field('section_attributes')['padding']['padding_mobile']['padding-bottom']; ?>;
            }
        }
    </style>
<?php endif // end padding styles ?>


<?php if (get_sub_field('buttons_group')['buttons_alignment']) : ?>
    <style>
        .acf-section-<?php echo get_row_index() ?> .btn-block {
            justify-content: <?php echo get_sub_field('buttons_group')['buttons_alignment']; ?>;
        }
        @media screen and (max-width: 767px) {
            .acf-section-<?php echo get_row_index() ?> .btn-block {
                justify-content: <?php echo get_sub_field('buttons_group')['buttons_alignment_mobile']; ?>;
            }
        }
    </style>
<?php endif // end buttons_group styles ?>


<?php if (get_sub_field('content_direction_mobile')) : ?>
    <style>
        @media screen and (max-width: 767px) {
            .acf-section-<?php echo get_row_index() ?> .text-left__inner {
                flex-direction: <?php echo get_sub_field('content_direction_mobile'); ?>;
            }
        }
    </style>
<?php endif // end text left styles ?>


<?php if (get_field('header_logo_width_desktop', 'option')) : ?>
    <style>
        <?php if (get_field('header_logo_width_desktop', 'option')['logo_width_numbers']) : ?>
        header .menu-logo {
            max-width: <?php echo get_field('header_logo_width_desktop', 'option')['logo_width_numbers']; ?><?php echo get_field('header_logo_width_desktop', 'option')['logo_width_value']; ?>;
        }
        <?php endif ; ?>
    </style>
<?php endif // end LOGO width ?>

<?php if (get_field('header_logo_width_mobile', 'option')) : ?>
            <?php if (get_field('header_logo_width_mobile', 'option')['logo_width_numbers_mobile']) : ?>
        <style>
        @media screen and (max-width: 1024px) {
            header .menu-logo {
                max-width: <?php echo get_field('header_logo_width_mobile', 'option')['logo_width_numbers_mobile']; ?><?php echo get_field('header_logo_width_mobile', 'option')['logo_width_value_mobile']; ?>;
            }
        }
        <?php endif ; ?>
        </style>
<?php endif // end LOGO width ?>

<?php if (get_field('footer_logo_width_desktop', 'option')) : ?>
    <style>
        <?php if (get_field('footer_logo_width_desktop', 'option')['logo_width_numbers']) : ?>
        .footer .menu-logo {
            max-width: <?php echo get_field('footer_logo_width_desktop', 'option')['logo_width_numbers']; ?><?php echo get_field('footer_logo_width_desktop', 'option')['logo_width_value']; ?>;
        }
        <?php endif ; ?>
    </style>
<?php endif // end FOOTER LOGO width ?>

<?php if (get_field('footer_logo_width_mobile', 'option')) : ?>
            <?php if (get_field('footer_logo_width_mobile', 'option')['logo_width_numbers_mobile']) : ?>
        <style>
        @media screen and (max-width: 1024px) {
            .footer .menu-logo {
                max-width: <?php echo get_field('footer_logo_width_mobile', 'option')['logo_width_numbers_mobile']; ?><?php echo get_field('footer_logo_width_mobile', 'option')['logo_width_value_mobile']; ?>;
            }
        }
        <?php endif ; ?>
        </style>
<?php endif // end FOOTER LOGO width ?>


