// document.addEventListener('touchstart', onTouchStart, {passive: true});
////////////////////////// Nav menu

function openSubmenuOnClick() {
    // $('.has-child').on('click', function(){
    //     console.log($(this))
    //     this.classList.toggle('active')
    // })
    $('.dropdown-arrow').on('click', function(){
        console.log($(this).parent('.has-child'))
        let parent = $(this).parent('.has-child')[0]
        if ($(parent).hasClass('active')) {
            $('.has-child').removeClass('active')
        } else {
            $('.has-child').removeClass('active')
            parent.classList.toggle('active')
        }


        console.log(parent)

    })
}

function headerFixed() {
    let header = $(".header_fixed").offset().top;
    let header_height = $(".header_fixed").height();
    let sticky = header.offsetTop;

    // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
    if (window.pageYOffset > 0) {
        $(".header_fixed").addClass("fixed");
        $("body").css( "padding-top",  header_height + "px" )
    } else {
        $(".header_fixed").removeClass("fixed");
        $("main").removeClass("header-padding");
        $("body").css( "padding-top", "0" )
    }
}

function setLogoWidth(logo) {
    if ($(logo).attr('data-width-desk').length > 0 || $(logo).attr('data-width-mob').length > 0) {
        let logo_width_desk = $(logo).attr('data-width-desk');
        let logo_width_mob = $(logo).attr('data-width-mob');
        console.log(logo_width_desk)
        if(window.innerWidth <= 767){
            console.log(logo_width_mob)
            if ($(logo).attr('data-width-mob').length > 0) {
                $(logo).css('max-width', logo_width_mob + 'px')
            }
        } else {
            if ($(logo).attr('data-width-desk')) {
                $(logo).css('max-width', logo_width_desk + 'px')
            }
        }
    }
}
// setLogoWidth('header .menu-logo')
// setLogoWidth('.footer .menu-logo')

$(document).ready(function(){
    headerFixed();
    $('header a[href^="#"]').addClass('crane')
    // Add CRANE class
    // let menu_links = $('header a');
    // for (i=0; i<menu_links.length; i++ ) {
    //     let link = menu_links[i];
    //     // console.log(link.href)
    //     if( link.href.indexOf('#') > -1 ) {
    //         menu_links[i].classList.add('crane')
    //     }
    // }
    $("body").on("click",'.crane', function (event) {
        // console.log($('header a[href^="#"]'));
        //отменяем стандартную обработку нажатия по ссылке
        event.preventDefault();
        //забираем идентификатор бока с атрибута href
        var id  = $(this).attr('href'),
            //узнаем высоту от начала страницы до блока на который ссылается якорь
            top = $(id).offset().top;
        //анимируем переход на расстояние - top за 1500 мс
        $('body,html').animate({scrollTop: top-100}, 1500);
    });
})
window.onload = function () {
    window.onscroll = function () {
        headerFixed();
    };

    //Change button text on mobile
    if(window.innerWidth <= 767){
        let mob_text = $('.nav-menu-btn').attr('data-mob-text');
        $('.nav-menu-btn').html(mob_text);

        openSubmenuOnClick();
    } else {
        
    }
};


////////////////////////// Adaptive WIDTH/HEIGHT for elements
function elAdaptiveWidthHeight(element) {
    let elem_llection = $(element)

    for(i=0; i<elem_llection.length; i++) {
        let elem = elem_llection[i];
        console.log(elem)
        if ($(elem).attr('data-width-desk').length > 0 || $(elem).attr('data-width-mob').length > 0) {
            let elem_width_desk = $(elem).attr('data-width-desk');
            let elem_width_mob = $(elem).attr('data-width-mob');
            console.log(elem_width_desk)
            if(window.innerWidth <= 767){
                console.log(elem_width_mob)
                if ($(elem).attr('data-width-mob').length > 0) {
                    $(elem).css('width', elem_width_mob + 'px')
                    $(elem).css('height', elem_width_mob + 'px')
                }
            } else {
                if ($(elem).attr('data-width-desk')) {
                    $(elem).css('width', elem_width_desk + 'px')
                    $(elem).css('height', elem_width_desk + 'px')
                }
            }
        }
    }

}
elAdaptiveWidthHeight('.adaptive-width')

////////////////////////// ACCORDION
var acc = document.getElementsByClassName("accordion__btn");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        console.log('HELLO')
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }
    });
}



// SHOW ALERT
function showAlert(type, text) {
    if (type == 'error') {
        $('#success').html("<div class='alert alert-danger'>");
        $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>");
        $('#success > .alert-danger').append(text);
        $('#success > .alert-danger').append('</div>');
        if($('.is-invalid').length > 0) {
            var is_invalid = $('.is-invalid')[0]
            $('html, body').animate({scrollTop:$(is_invalid).position().top - 85}, 500);
        }

    } else if (type == 'warning') {
        $('#success').html("<div class='alert alert-warning'>");
        $('#success > .alert-warning').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>");
        $('#success > .alert-warning').append(text);
        $('#success > .alert-warning').append('</div>');
    } else {
        $('#success').html("<div class='alert alert-success'>");
        $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>");
        $('#success > .alert-success').append(text);
        $('#success > .alert-success').append('</div>');
    }
    setTimeout(closeAlert, 100)
} //showAlert

// Close Alert
function closeAlert(){
    $('#success .close').on('click', function(){
        $('#success .alert').remove();
        $(".btnSubmit").attr("disabled", false);
    })
}// Close Alert

$("input#au_citizenshipbydescent").change(function (event) {
    var au_citizenshipbydescent = $("input#au_citizenshipbydescent").is(":checked");
    if(this.checked) {
        $("#div_au_citizenshipstocknumber").hide();
    } else {
        $("#div_au_citizenshipstocknumber").show();
    }
});



// Cloucheck tabs
$(document).ready(function(){
    $(".cloudcheck-regions-list li").on('click', function(){
        var cloudcheck_region = $(this).attr('data-region')
        var ckeckbox_list =  $('.ckeckbox-dropdown-list');
        $('.cloudcheck-regions-list li').removeClass('show')
        $(this).addClass('show')
        $('.cloudcheck-region-box').removeClass('show')
        $('.cloudcheck-region-box[data-region='+ cloudcheck_region +']').addClass('show')

    })
})


// REMOVE STRIPE PAYMENT BUY NOW BUTTON
function buyNowDisable(){
    if ($('#wc-stripe-payment-request-wrapper').length) {
        $('#wc-stripe-payment-request-wrapper button').detach();
    }
}
setTimeout(buyNowDisable, 100)




// CHANGE POSTCODE BILLING FIELD BACKGROUND
function billingFieldsBg(data) {
    $( "#" + data ).addClass('change-bg empty')
    $( "#" + data ).change(function() {
        console.log($(this).val().length)
        if($(this).length && $(this).val().length) {
            $(this).removeClass("empty");
        } else {
            $(this).addClass("empty");
        }
    });
}
$(document).ready(function() {
    let data_arr = ['billing_postcode'];
    for(i=0; i<=data_arr.length; i++) {
        billingFieldsBg(data_arr[i])
    }
    $( "#billing_postcode" ).prop('placeholder', 'Postcode')
})



// Autocomplete billings fields by Heydoc values
function autocompleteBillingsFieldsByHeydocValues(){
    console.log(autocompleteBillingsFieldsByHeydocValues)
    var data = sessionStorage['data'];
    if ( data ) {
        var values = JSON.parse(data);
        $('#billing_first_name').val(values.first)
        $('#billing_last_name').val(values.last)
        $('#billing_country option[value="'+ values.country +'"]').prop('selected', true);
        $('#billing_address_1').val(values.address)
        $('#billing_postcode').val(values.postcode)
        $('#billing_phone').val(values.phoneNumber)
        $('#billing_email').val(values.email)
    }
}// Autocomplete billings fields by Heydoc values
autocompleteBillingsFieldsByHeydocValues()


// // AUTOCOMPLETE CLOUDCHECK NAME FIELDS
// if($('.name').length > 0 && $('#billing_first_name').length > 0 ) {
//     $('input.name').val($('input#billing_first_name').val())
//     $('input#billing_first_name').change(function(){
//         $('input.name').val($('input#billing_first_name').val())
//     })
// }
// if($('.surname').length > 0 && $('#billing_last_name').length > 0 ) {
//     $('input.surname').val($('input#billing_last_name').val())
//     $('input#billing_last_name').change(function(){
//         $('input.surname').val($('input#billing_last_name').val())
//     })
// }// AUTOCOMPLETE CLOUDCHECK NAME FIELDS


// Add login/register forms labels
jQuery(document).ready(function(){
    var data = sessionStorage['data'];
    if($('.woocommerce-form-login #username' ).length > 0) {
        jQuery('#username').attr('placeholder', 'User Email');
    }
    if($('.woocommerce-form-login #password' ).length > 0) {
        jQuery('#password').attr('placeholder', 'User Password');
    }
    if($('.woocommerce-form-register #reg_email' ).length > 0) {
        jQuery('#reg_email').attr('placeholder', 'User Email');
        if ( data ) {
            var values = JSON.parse(data);
            jQuery('#reg_email').val(values.email);
        }
    }
    if($('.woocommerce-form-register #reg_password' ).length > 0) {
        jQuery('#reg_password').attr('placeholder', 'User Password');
    }
    if($('.woocommerce-form-register #reg_username' ).length > 0) {
        jQuery('#reg_username').attr('placeholder', 'Username');
    }
});// Add login/register forms labels



// init modal
function showModal(data = 'defaul data'){
    var button = $('.init-modal')[0]
    // $('.alert-heading').text('Something went wrong')
    // $('.alert-text').text(data)

    $('.try-again').on('click', function(){
        $('#success .alert').remove();
        $('#fancybox-close').click()
    })
    $('.open-chat').on('click', function(){
        $('#success .alert').remove();
        $('#fancybox-close').click()
        openChat()
    })
    $(button).click()
    console.log(data)
}// init modal

function openChat(){
    var iframe = document.getElementById("launcher");
    var elmnt = iframe.contentWindow.document.getElementsByTagName("button")[0];
    // elmnt.style.display = "none";
    var tt = $(elmnt)[0]
    $(tt).click()
}

// Related blog articles slider
$(document).ready(function() {
    if ($(window).width() < 760) {
        $('.post-slider-init').slick({
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    } else {
        $('.post-slider-init').slick({
            infinite: false,
            slidesToShow: 3,
            slidesToScroll: 1
        });
    }
});
$( window ).resize(function() {
    if ($(window).width() < 760) {
        $('.post-slider-init').slick("unslick");
        $('.post-slider-init').slick({
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    } else {
        $('.post-slider-init').slick("unslick");
        $('.post-slider-init').slick({
            infinite: false,
            slidesToShow: 3,
            slidesToScroll: 1
        });
    }
});