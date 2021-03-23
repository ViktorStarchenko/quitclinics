$(function() {
    $('.left-menu-class').click(function() {
        $(this).toggleClass('left-menu-mobile-visible')
        closeMenu()
    });
    $('body').on('click', function(e){
        let elem = $(e.target)[0]
        console.log(elem)
        if($(elem).parents('.left-menu-class').length) {
            $('.left-menu-class').addClass('left-menu-mobile-visible')
            console.log('YES WE HAVE PARENT')
            closeMenu()
        }
        if($(elem).hasClass('menu')) {
            $('.left-menu-class').addClass('left-menu-mobile-visible')
            closeMenu()
        }

    })
});

function closeMenu(){
    $('body').on('click', function(e){
        let elem = $(e.target)[0]
        if($(elem).hasClass('left-menu-class') == true) {
            console.log('YOBA')
        }
        // if($(elem).hasClass('woocommerce-MyAccount-navigation-link') == false) {
        //     $('.left-menu-class').removeClass('left-menu-mobile-visible')
        // }
        if($(elem).hasClass('menu') == false ) {
            $('.left-menu-class').removeClass('left-menu-mobile-visible')
        }

    })
}