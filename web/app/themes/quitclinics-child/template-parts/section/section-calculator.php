<?php get_template_part('template-parts/section/section', 'attributes'); ?>


<div class="calculator">
    <?php if(get_sub_field('enable_calculator')['form_subtitle']) : ?>
        <div class="calculator__subscription">
            <p><?php echo get_sub_field('enable_calculator')['form_subtitle']; ?></p>
        </div>
    <?php endif ?>

    <div class="calculator__box">
        <?php if( get_sub_field('enable_calculator')['sigarettes_per_day'] ): ?>
        <input class="calculator__input" type="number" min="0" value="<?php echo get_sub_field('enable_calculator')['sigarettes_per_day']; ?>">
        <?php endif ?>
        <?php if( get_sub_field('enable_calculator')['sigarettes_price'] ): ?>
        <input class="calculator__pack-price" type="hidden" value="<?php echo get_sub_field('enable_calculator')['sigarettes_price']; ?>">
        <?php endif ?>
        <?php if( get_sub_field('enable_calculator')['vape_price'] ): ?>
        <input class="calculator__vape-price" type="hidden" value="<?php echo get_sub_field('enable_calculator')['vape_price']; ?>">
        <?php endif ?>
    </div>

    <div class="calculator__result">
        <?php if( get_sub_field('enable_calculator')['result_text'] ): ?>
        <div class="calculator__result-text">
            <p><?php echo get_sub_field('enable_calculator')['result_text']; ?></p>
        </div>
        <?php endif ?>
        <div class="calculator__result-price">
            <?php if( get_sub_field('enable_calculator')['resultt_currency'] ): ?><span class="calculator__result-currency"><?php echo get_sub_field('enable_calculator')['resultt_currency']; ?></span><?php endif ?><span class="economy_day"></span><span> PER DAY</span>
        </div>
        <div class="calculator__result-price">
            <?php if( get_sub_field('enable_calculator')['resultt_currency'] ): ?><span class="calculator__result-currency"><?php echo get_sub_field('enable_calculator')['resultt_currency']; ?></span><?php endif ?><span class="economy_week"></span><span> PER WEEK</span>
        </div>
        <div class="calculator__result-price">
            <?php if( get_sub_field('enable_calculator')['resultt_currency'] ): ?><span class="calculator__result-currency"><?php echo get_sub_field('enable_calculator')['resultt_currency']; ?></span><?php endif ?><span class="economy_year"></span><span> PER YEAR</span>
        </div>
    </div>

</div>

<?php wp_enqueue_script( 'calculator-script', get_theme_file_uri( '/assets/js/calculator-script.js' ), array('jq-351'), '1', true ); ?>