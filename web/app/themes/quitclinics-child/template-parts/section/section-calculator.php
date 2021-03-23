<?php get_template_part('template-parts/section/section', 'attributes'); ?>


<div class="calculator">
    <?php if(get_sub_field('enable_calculator')['form_subtitle']) : ?>
        <div class="calculator__subscription">
            <p><?php echo get_sub_field('enable_calculator')['form_subtitle']; ?></p>
        </div>
    <?php endif ?>

    <div class="calculator__box">
        <input class="calculator__input" type="number" min="0" value="<?php echo get_sub_field('enable_calculator')['sigarettes_per_day']; ?>">
        <input class="calculator__pack-price" type="hidden" value="<?php echo get_sub_field('enable_calculator')['sigarettes_price']; ?>">
        <input class="calculator__vape-price" type="hidden" value="<?php echo get_sub_field('enable_calculator')['vape_price']; ?>">
    </div>

    <div class="calculator__result">
        <div class="calculator__result-text">
            <p><?php echo get_sub_field('enable_calculator')['result_text']; ?></p>
        </div>
        <div class="calculator__result-price">
            <span class="calculator__result-currency"><?php echo get_sub_field('enable_calculator')['resultt_currency']; ?></span><span class="economy_day"></span><span> PER DAY</span>
        </div>
        <div class="calculator__result-price">
            <span class="calculator__result-currency"><?php echo get_sub_field('enable_calculator')['resultt_currency']; ?></span><span class="economy_week"></span><span> PER WEEK</span>
        </div>
        <div class="calculator__result-price">
            <span class="calculator__result-currency"><?php echo get_sub_field('enable_calculator')['resultt_currency']; ?></span><span class="economy_year"></span><span> PER YEAR</span>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script>

    $(document).ready(function() {
        console.log('calculatorf')
        calculate()
        $('input[type="number"]').on('change', function(){
            calculate()
        })
    })

    function calculate() {

            var pack_price = $('.calculator__pack-price').val()

            var sigs_in_pack = 20

            var sigs_per_day = $('input[type=number]').val()

            var pack_per_week = sigs_per_day/sigs_in_pack * 7
            var pack_per_year = sigs_per_day/sigs_in_pack * 365


            var coast_per_day = (pack_price/sigs_in_pack) * sigs_per_day
            var coast_per_week = ((pack_price/sigs_in_pack) * sigs_per_day) * 7
            var coast_per_year = ((pack_price/sigs_in_pack) * sigs_per_day) * 365

            var vape_price = $('.calculator__vape-price').val()
            var vape_price_per_week = (vape_price/3)/4
            var vape_price_per_day = vape_price_per_week/7
            var vape_price_per_year = vape_price_per_day * 365

            var economy_year = coast_per_year - vape_price_per_year
            economy_year = Math.round(economy_year * 100)/100
            var economy_week = coast_per_week - vape_price_per_week
            economy_week = Math.round(economy_week * 100)/100
            var economy_day = coast_per_day - vape_price_per_day
            economy_day = Math.round(economy_day * 100)/100

            if(economy_year <= 0) {
                economy_year = 0

            }if(economy_week <= 0) {
                economy_week = 0
            }
            if(economy_day <= 0) {
                economy_day = 0
            }



            $('.economy_year').html(economy_year)
            $('.economy_week').html(economy_week)
            $('.economy_day').html(economy_day)

        }
    
</script>