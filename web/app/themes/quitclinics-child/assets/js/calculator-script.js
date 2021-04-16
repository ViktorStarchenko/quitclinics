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