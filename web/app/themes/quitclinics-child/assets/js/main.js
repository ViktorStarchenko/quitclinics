// document.addEventListener('touchstart', onTouchStart, {passive: true});
////////////////////////// Nav menu

function openSubmenuOnClick() {
    // jQuery('.has-child').on('click', function(){
    //     console.log(jQuery(this))
    //     this.classList.toggle('active')
    // })
    jQuery('.dropdown-arrow').on('click', function(){
        console.log(jQuery(this).parent('.has-child'))
        let parent = jQuery(this).parent('.has-child')[0]
        if (jQuery(parent).hasClass('active')) {
            jQuery('.has-child').removeClass('active')
        } else {
            jQuery('.has-child').removeClass('active')
            parent.classList.toggle('active')
        }


        console.log(parent)

    })
}

function headerFixed() {
    let header = jQuery(".header_fixed").offset().top;
    let header_height = jQuery(".header_fixed").height();
    let sticky = header.offsetTop;

    // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
    if (window.pageYOffset > 0) {
        jQuery(".header_fixed").addClass("fixed");
        jQuery("body").css( "padding-top",  header_height + "px" )
    } else {
        jQuery(".header_fixed").removeClass("fixed");
        jQuery("main").removeClass("header-padding");
        jQuery("body").css( "padding-top", "0" )
    }
}

function setLogoWidth(logo) {
    if (jQuery(logo).attr('data-width-desk').length > 0 || jQuery(logo).attr('data-width-mob').length > 0) {
        let logo_width_desk = jQuery(logo).attr('data-width-desk');
        let logo_width_mob = jQuery(logo).attr('data-width-mob');
        console.log(logo_width_desk)
        if(window.innerWidth <= 767){
            console.log(logo_width_mob)
            if (jQuery(logo).attr('data-width-mob').length > 0) {
                jQuery(logo).css('max-width', logo_width_mob + 'px')
            }
        } else {
            if (jQuery(logo).attr('data-width-desk')) {
                jQuery(logo).css('max-width', logo_width_desk + 'px')
            }
        }
    }
}
// setLogoWidth('header .menu-logo')
// setLogoWidth('.footer .menu-logo')

jQuery(document).ready(function(){
    headerFixed();
    jQuery('header a[href^="#"]').addClass('crane')
    // Add CRANE class
    // let menu_links = jQuery('header a');
    // for (i=0; i<menu_links.length; i++ ) {
    //     let link = menu_links[i];
    //     // console.log(link.href)
    //     if( link.href.indexOf('#') > -1 ) {
    //         menu_links[i].classList.add('crane')
    //     }
    // }
    jQuery("body").on("click",'.crane', function (event) {
        // console.log(jQuery('header a[href^="#"]'));
        //отменяем стандартную обработку нажатия по ссылке
        event.preventDefault();
        //забираем идентификатор бока с атрибута href
        var id  = jQuery(this).attr('href'),
            //узнаем высоту от начала страницы до блока на который ссылается якорь
            top = jQuery(id).offset().top;
        //анимируем переход на расстояние - top за 1500 мс
        jQuery('body,html').animate({scrollTop: top-100}, 1500);
    });
})
window.onload = function () {
    window.onscroll = function () {
        headerFixed();
    };

    //Change button text on mobile
    if(window.innerWidth <= 767){
        let mob_text = jQuery('.nav-menu-btn').attr('data-mob-text');
        jQuery('.nav-menu-btn').html(mob_text);

        openSubmenuOnClick();
    } else {

    }
};


////////////////////////// Adaptive WIDTH/HEIGHT for elements
function elAdaptiveWidthHeight(element) {
    let elem_llection = jQuery(element)

    for(i=0; i<elem_llection.length; i++) {
        let elem = elem_llection[i];
        console.log(elem)
        if (jQuery(elem).attr('data-width-desk').length > 0 || jQuery(elem).attr('data-width-mob').length > 0) {
            let elem_width_desk = jQuery(elem).attr('data-width-desk');
            let elem_width_mob = jQuery(elem).attr('data-width-mob');
            console.log(elem_width_desk)
            if(window.innerWidth <= 767){
                console.log(elem_width_mob)
                if (jQuery(elem).attr('data-width-mob').length > 0) {
                    jQuery(elem).css('width', elem_width_mob + 'px')
                    jQuery(elem).css('height', elem_width_mob + 'px')
                }
            } else {
                if (jQuery(elem).attr('data-width-desk')) {
                    jQuery(elem).css('width', elem_width_desk + 'px')
                    jQuery(elem).css('height', elem_width_desk + 'px')
                }
            }
        }
    }

}
elAdaptiveWidthHeight('.adaptive-width')

////////////////////////// ACCORDION

var acc = document.getElementsByClassName("accordion__btn");
console.log(acc)
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
        jQuery('#success').html("<div class='alert alert-danger'>");
        jQuery('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>");
        jQuery('#success > .alert-danger').append(text);showAlert
        jQuery('#success > .alert-danger').append('</div>');
        if(jQuery('.is-invalid').length > 0) {
            var is_invalid = jQuery('.is-invalid')[0]
            jQuery('html, body').animate({scrollTop:jQuery(is_invalid).position().top - 85}, 500);
        }

    } else if (type == 'warning') {
        jQuery('#success').html("<div class='alert alert-warning'>");
        jQuery('#success > .alert-warning').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>");
        jQuery('#success > .alert-warning').append(text);
        jQuery('#success > .alert-warning').append('</div>');
    } else {
        jQuery('#success').html("<div class='alert alert-success'>");
        jQuery('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>");
        jQuery('#success > .alert-success').append(text);
        jQuery('#success > .alert-success').append('</div>');
    }
    setTimeout(closeAlert, 100)
} //showAlert

// Close Alert
function closeAlert(){
    jQuery('#success .close').on('click', function(){
        jQuery('#success .alert').remove();
        jQuery(".btnSubmit").attr("disabled", false);
    })
}// Close Alert

function hideAlert() {
    jQuery('#success > .alert').remove();
}

jQuery("input#au_citizenshipbydescent").change(function (event) {
    var au_citizenshipbydescent = jQuery("input#au_citizenshipbydescent").is(":checked");
    if(this.checked) {
        jQuery("#div_au_citizenshipstocknumber").hide();
    } else {
        jQuery("#div_au_citizenshipstocknumber").show();
    }
});



// Cloucheck tabs
jQuery(document).ready(function(){
    jQuery(".cloudcheck-regions-list li").on('click', function(){
        var cloudcheck_region = jQuery(this).attr('data-region')
        var ckeckbox_list =  jQuery('.ckeckbox-dropdown-list');
        jQuery('.cloudcheck-regions-list li').removeClass('show')
        jQuery(this).addClass('show')
        jQuery('.cloudcheck-region-box').removeClass('show')
        jQuery('.cloudcheck-region-box[data-region='+ cloudcheck_region +']').addClass('show')

    })
})


// REMOVE STRIPE PAYMENT BUY NOW BUTTON
function buyNowDisable(){
    if (jQuery('#wc-stripe-payment-request-wrapper').length) {
        jQuery('#wc-stripe-payment-request-wrapper button').detach();
    }
}
setTimeout(buyNowDisable, 100)




// CHANGE POSTCODE BILLING FIELD BACKGROUND
function billingFieldsBg(data) {
    jQuery( "#" + data ).addClass('change-bg empty')
    jQuery( "#" + data ).change(function() {
        console.log(jQuery(this).val().length)
        if(jQuery(this).length && jQuery(this).val().length) {
            jQuery(this).removeClass("empty");
        } else {
            jQuery(this).addClass("empty");
        }
    });
}
jQuery(document).ready(function() {
    let data_arr = ['billing_postcode'];
    for(i=0; i<=data_arr.length; i++) {
        billingFieldsBg(data_arr[i])
    }
    jQuery( "#billing_postcode" ).prop('placeholder', 'Postcode')
})



// Autocomplete billings fields by Heydoc values
function autocompleteBillingsFieldsByHeydocValues(){
    console.log(autocompleteBillingsFieldsByHeydocValues)
    var data = sessionStorage['data'];
    if ( data ) {
        var values = JSON.parse(data);
        jQuery('#billing_first_name').val(values.first)
        jQuery('#billing_last_name').val(values.last)
        jQuery('#billing_country option[value="'+ values.country +'"]').prop('selected', true);
        jQuery('#billing_address_1').val(values.address)
        jQuery('#billing_postcode').val(values.postcode)
        jQuery('#billing_phone').val(values.phoneNumber)
        jQuery('#billing_email').val(values.email)
    }
}// Autocomplete billings fields by Heydoc values
autocompleteBillingsFieldsByHeydocValues()


// // AUTOCOMPLETE CLOUDCHECK NAME FIELDS
// if(jQuery('.name').length > 0 && jQuery('#billing_first_name').length > 0 ) {
//     jQuery('input.name').val(jQuery('input#billing_first_name').val())
//     jQuery('input#billing_first_name').change(function(){
//         jQuery('input.name').val(jQuery('input#billing_first_name').val())
//     })
// }
// if(jQuery('.surname').length > 0 && jQuery('#billing_last_name').length > 0 ) {
//     jQuery('input.surname').val(jQuery('input#billing_last_name').val())
//     jQuery('input#billing_last_name').change(function(){
//         jQuery('input.surname').val(jQuery('input#billing_last_name').val())
//     })
// }// AUTOCOMPLETE CLOUDCHECK NAME FIELDS


// Add login/register forms labels
jQuery(document).ready(function(){
    var data = sessionStorage['data'];
    if(jQuery('.woocommerce-form-login #username' ).length > 0) {
        jQuery('#username').attr('placeholder', 'User Email');
    }
    if(jQuery('.woocommerce-form-login #password' ).length > 0) {
        jQuery('#password').attr('placeholder', 'User Password');
    }
    if(jQuery('.woocommerce-form-register #reg_email' ).length > 0) {
        jQuery('#reg_email').attr('placeholder', 'User Email');
        if ( data ) {
            var values = JSON.parse(data);
            jQuery('#reg_email').val(values.email);
        }
    }
    if(jQuery('.woocommerce-form-register #reg_password' ).length > 0) {
        jQuery('#reg_password').attr('placeholder', 'User Password');
    }
    if(jQuery('.woocommerce-form-register #reg_username' ).length > 0) {
        jQuery('#reg_username').attr('placeholder', 'Username');
    }
});// Add login/register forms labels



// init modal
function showModal(data = 'defaul data'){
    var button = jQuery('.init-modal')[0]
    // jQuery('.alert-heading').text('Something went wrong')
    // jQuery('.alert-text').text(data)

    jQuery('.try-again').on('click', function(){
        jQuery('#success .alert').remove();
        jQuery('#fancybox-close').click()
    })
    jQuery('.open-chat').on('click', function(){
        jQuery('#success .alert').remove();
        jQuery('#fancybox-close').click()
        openChat()
    })
    jQuery(button).click()
    console.log(data)
}// init modal

function openChat(){
    var iframe = document.getElementById("launcher");
    var elmnt = iframe.contentWindow.document.getElementsByTagName("button")[0];
    // elmnt.style.display = "none";
    var tt = jQuery(elmnt)[0]
    jQuery(tt).click()
}

// Related blog articles slider
jQuery(document).ready(function() {
    if (jQuery(window).width() < 760) {
        jQuery('.post-slider-init').slick({
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    } else {
        jQuery('.post-slider-init').slick({
            infinite: false,
            slidesToShow: 3,
            slidesToScroll: 1
        });
    }
});
jQuery( window ).resize(function() {
    if (jQuery(window).width() < 760) {
        jQuery('.post-slider-init').slick("unslick");
        jQuery('.post-slider-init').slick({
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    } else {
        jQuery('.post-slider-init').slick("unslick");
        jQuery('.post-slider-init').slick({
            infinite: false,
            slidesToShow: 3,
            slidesToScroll: 1
        });
    }
});



// Bordered form/checkbox radio styles
jQuery('.bordered input[type="radio"]').on('change', function(){
    console.log(jQuery(this).closest('.form-group').find('.form-check'))
    jQuery(this).closest('.form-step').find('.form-check').removeClass('checked')
    jQuery(this).closest('.form-check').addClass('checked')
})

jQuery(function(){
    jQuery('.bordered input[type="checkbox"]').click(function() {
        if(jQuery(this).is(':checked'))
            jQuery(this).closest('.form-check').addClass('checked')
        else
            jQuery(this).closest('.form-check').removeClass('checked')
    });
});


/////////////////////////////////////////////  Alignment heigh of similar blocks
function normalizeHeigh(data) {
    let data_height = jQuery('[data-height=' +  data + ']')

    let data_allHeight = [];
    data_height.each(function(elem){
        // console.log(jQuery(this).height())
        data_allHeight.push(parseInt(jQuery(this).height()));
    })
    slider1_maxHeight = Math.max.apply(Math, data_allHeight);
    jQuery('[data-height=' +  data + ']').height(slider1_maxHeight)
    // console.log(data_height);
}

jQuery(document).ready(function() {
    let data_arr = [];

    for(i=0; i<=data_arr.length; i++) {
        normalizeHeigh(data_arr[i])
    }
})


//////////////////////////////// Popup

jQuery('.popup_button').on('click', function () {
    console.log(this)
    // jQuery("#popup-main-wrapper").empty();
    // jQuery(this).siblings(".item_popup_wrapper").clone().appendTo( "#popup-main-wrapper" );
    jQuery(this).siblings(".popup-main-wrapper").addClass('popup_opened');
});

jQuery(document).on('click', '#popup_close_button', function () {
    jQuery(".popup-main-wrapper").removeClass('popup_opened');

});


// Custom dropdown
jQuery('.dropdown-item').on('click', function(){
    let btn_text = jQuery(this).text();
    // console.log(jQuery(this).closest('.dropdown-content').siblings('.dropbtn'))
    jQuery(this).closest('.dropdown-content').siblings('.dropbtn').text(btn_text)
})



jQuery('select').each(function(){
    let options = jQuery(this).children('option')
    // console.log(options)
})


// setTimeout(customizeSelect, 1000)


// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {

    if (!event.target.matches('.dropbtn')) {

        var dropdowns = document.getElementsByClassName("dropdown-content");

        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
jQuery('.dropbtn').on('click', function(){
    let data_dropdown = jQuery(this).attr('data-dropdown')
    var dropdowns = document.querySelectorAll('.dropdown-content[data-dropdown="'+data_dropdown+'"]');
    jQuery('.dropdown-content').removeClass('show')
    jQuery(dropdowns).toggleClass('show')
})