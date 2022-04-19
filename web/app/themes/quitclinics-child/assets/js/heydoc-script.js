//////////////////////////// Fields conditional logic
$('input[name="3hC7sLm3JSsfqiM0ulcX8"]').on('click', function(){
    // console.log($(this).val())
    if($(this).val() == 'I\'ve never smoked') {
        jQuery('.form-step.smokers').removeClass('form-request-item')
        $('.never-smoke').addClass('form-request-item');
    } else if ($(this).val() == 'Current or ex-smoker') {
        jQuery('.form-step.smokers').addClass('form-request-item');
        $('.never-smoke').addClass('hidden');
        $('.never-smoke').removeClass('form-request-item');
        $('.quesionnaire-nav-next').removeClass('hidden');
    }
    refreshDataStep( )
})

// Show/hide Vaping History
$('input[name="DWwVhzdpzYV_S6W_Pzf5V"]').on('click', function(){
    if($(this).val() == 'Yes') {
        jQuery('.form-step.vaping-history').addClass('form-request-item')
    } else {
        jQuery('.form-step.vaping-history').removeClass('form-request-item')
    }
    refreshDataStep()
})
// Show/hide Female radio
$('input[name="gender"]').on('click', function(){
    if($(this).val() == 'female') {
        jQuery('.form-step.s-female').addClass('form-request-item')
    } else {
        jQuery('.form-step.s-female').removeClass('form-request-item')
    }
    refreshDataStep()
})

// Show/hide Nicotine Vaping radio
$('input[name="emDxFmHm1LidKT_L89icr"]').on('click', function(){
    if ($('input:checkbox[value="Nicotine Vaping"]').is(":checked")) {
        jQuery('.form-step.vapers').addClass('form-request-item')
    } else if (!$('input:checkbox[value="Nicotine Vaping"]').is(":checked")) {
        jQuery('.form-step.vapers').removeClass('form-request-item')
        $( '.nicotine-vaping input' ).prop( "checked", false );
    }
    refreshDataStep( )
})

function initTreatmentSlider () {

        if (jQuery(window).width() < 760) {
            let is_initiated = jQuery('.slick-initialized');
            if (is_initiated.length <= 0) {
                console.log(is_initiated)
                jQuery('.what-to-expect-slider').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: true,
                    centerMode: false,
                    centerPadding: false,
                    infinite: true,
                    autoplay: true,
                    autoplaySpeed: 2000,
                });
            }

        }

}

///////////////////////////////////////////// Multi step functionallity
let step_counter = 0;
function refreshDataStep( ){
    $('.form-step.form-request-item').each((idx, item) => {
        // console.log($('.form-step.form-request-item').length)
        $(item).attr("data-form-step",idx)
    })
}

function hideNavButtons() {
    if( jQuery('.form-step.active').data('form-step') >= $('.form-step.form-request-item').length - 1  || $('.form-step.active.form-request-item').hasClass('never-smoke')) {
        $('.quesionnaire-nav-next').addClass('hidden');
        // console.log('Все, конец')
    } else if (!$('.form-step.active.form-request-item').hasClass('never-smoke') && jQuery('.form-step.active').data('form-step') < $('.form-step.form-request-item').length - 1) {
        $('.quesionnaire-nav-next').removeClass('hidden');
    }

    if (jQuery('.form-step.active').data('form-step') == '0') {
        jQuery('.quesionnaire-nav-prev').addClass('disabled');
    } else {
        jQuery('.quesionnaire-nav-prev').removeClass('disabled');
    }
    // console.log($('.form-step.form-request-item').length - 1)
    // console.log(jQuery('.form-step.active').data('form-step'))
}

jQuery('.quesionnaire-nav-prev').on('click', function() {
    refreshDataStep()
    let current_step = jQuery('.form-step.active').data('form-step');
    let prev_step = step_counter - 1;
    jQuery('.form-step').removeClass('active')
    jQuery('.form-step').addClass('hidden')
    jQuery('.form-step.form-request-item[data-form-step='+prev_step+']').removeClass('hidden')
    jQuery('.form-step.form-request-item[data-form-step='+prev_step+']').addClass('active')

    $('.quesionnaire-nav-prev-num').html(parseInt(prev_step) - 1)
    $('.quesionnaire-nav-cur-num').html(step_counter)
    $('.quesionnaire-nav-next-num').html(current_step)

    hideNavButtons()
    step_counter--
    return false
})


jQuery('.quesionnaire-nav-next').on('click', function() {
    refreshDataStep()

    let current_step = jQuery('.form-step.active').data('form-step');
    let next_step = step_counter + 1;
    hideAlert()
    validateCurrentStep()
    // console.log(jQuery('.form-step.active').find('.is-invalid'));
    if(jQuery('.form-step.active').find('.is-invalid').length > 0 ) {
        closeAlert()
        showAlert("error", "<strong>Please fill in all fields\n</strong>");
        return false
    } else {
        jQuery('.form-step').removeClass('active')
        jQuery('.form-step').addClass('hidden')
        jQuery('.form-request-item[data-form-step='+next_step+']').removeClass('hidden')
        jQuery('.form-request-item[data-form-step='+next_step+']').addClass('active')

        $('.quesionnaire-nav-prev-num').html(current_step)
        $('.quesionnaire-nav-cur-num').html(next_step)
        $('.quesionnaire-nav-next-num').html(parseInt(next_step) + 1)
    }

    let top = jQuery('.form-request-item[data-form-step='+next_step+']').offset().top;
    //анимируем переход на расстояние - top за 1500 мс
    $('body,html').animate({scrollTop: top-100}, 800);
    initTreatmentSlider ()
    hideNavButtons()

    step_counter++
    return false
})




// Country select
$("#country").countrySelect({
    defaultCountry: "au",
    responsiveDropdown: true
});



// Global DOB
function global_dob(data) {
    var fd = new FormData();
    let dob = data;
    fd.append('dob',dob);
    fd.append('action','cloudcheck_dob_verification');

    $.ajax({
        url: "/wp/wp-admin/admin-ajax.php",
        type: "POST",
        dataType: "JSON",
        data: fd,
        contentType: false,
        processData: false,
        cache: false,
        success: function(data) {
            console.log(data.type)
            // showAlert(data.type, "<p><strong>"+ data.message +"</strong></p>");
            if(data.type == 'success') {
                console.log('DOB success')
            } else {
                console.log('DOB fail')
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(xhr.statusText);
            console.log(xhr.responseText);
            console.log(thrownError);
            console.log(ajaxOptions);
            // showAlert("error", "<p><strong>"+ xhr.responseText +"</strong></p>");
            if ( xhr.responseText == 'success0') {
                console.log('DOB success')
            } else {
                console.log('DOB fail')
            }
        },
    });
}// Global DOB



// Validation functions
var submit_cancel = true;

// Validate DOB
function validateDob() {
    // Add dob
    $('.form-input-dob').each(function() {
        if($(this).val() == '' && $(this).val().length <= 0) {
            $(this).addClass('is-invalid')
        } else {
            $(this).removeClass('is-invalid')
        }
    })
}

// Validate DOB ForCurrentStep()
function validateDobForCurrentStep() {
    // Add dob
    $('.form-input-dob[required]').each(function() {
        if($(this).val() == '' && $(this).val().length <= 0) {
            $(this).addClass('is-invalid')
        } else {
            $(this).removeClass('is-invalid')
        }
    })
}
// Validate Radio
function validateRadio(data) {
    $('input[name="'+data+'"]').closest('.qc-form-group').removeClass('is-invalid')
    // console.log($('input[type="checkbox"][name="'+data+'"]'))
    if($('.form-request-item input[name="'+data+'"]:checked').length <=0) {
        submit_cancel = false;
        $('input[name="'+data+'"]').closest('.form-request-item .qc-form-group').addClass('is-invalid')

        // console.log($('input[type="radio"][name="gender"]').closest('.form-group'))
    } else {
        submit_cancel = true;
        $('input[name="'+data+'"]').closest('.qc-form-group').removeClass('is-invalid')
    }
}

function validateText() {
    $('.questionnaire-form').find('input[type="text"][required], input[type="email"][required], input[type="tel"][required], textarea[required]').each(function() {
        // console.log($(this))
        $(this).closest('.qc-form-group').removeClass('is-invalid')
        // console.log($('input[type="checkbox"][name="'+data+'"]'))
        if($(this).val().length <=0) {
            $(this).closest('.form-request-item').addClass('is-invalid')

            // console.log($('input[type="radio"][name="gender"]').closest('.form-group'))
        } else {
            submit_cancel = true;
            $(this).closest('.form-request-item').removeClass('is-invalid')
        }
        // $data[this.name] = $(this).val();
    });
}

// Validate text
function validateTextForCurrentStep() {
    $('.form-step.active.form-request-item').find('input[type="text"][required], input[type="email"][required], input[type="tel"][required], textarea[required]').each(function() {
        $(this).closest('.qc-form-group').removeClass('is-invalid')
        // console.log($('input[type="checkbox"][name="'+data+'"]'))
        if($(this).val().length <=0) {
            $(this).closest('.qc-form-group').addClass('is-invalid')

            // console.log($('input[type="radio"][name="gender"]').closest('.form-group'))
        } else {
            submit_cancel = true;
            $(this).closest('.qc-form-group').removeClass('is-invalid')
        }
        // $data[this.name] = $(this).val();
    });
}


function validateCurrentStep() {
    let validation = $('.form-step.active.form-request-item input[required]')
    validateTextForCurrentStep()
    validateDobForCurrentStep()
    $(validation).each(function() {
        // Validate radio
        if ($(this).is(':radio') || $(this).is(':checkbox')) {
            // console.log($(this).attr('name'))
            validateRadio($(this).attr('name'))
        }
    });
}

$(document).ready(function(){

    $.dobPicker({
// Selectopr IDs
        daySelector: '#dobday',
        monthSelector: '#dobmonth',
        yearSelector: '#dobyear',

// Default option values
        dayDefault: 'Day',
        monthDefault: 'Month',
        yearDefault: 'Year',

// Minimum age
//         minimumAge: 18,

// Maximum age
        maximumAge: 110
    });

});




$('.questionnarie-submit').on('click', function(){
    jQuery(this).addClass('clicked')

    $(".questionnaire-form").submit();
    return false
})
$(".questionnaire-form").submit(function(event) {
    let product_id = $('.questionnarie-submit.clicked').attr('data-product-id');
    let product_name = $('.questionnarie-submit.clicked').attr('data-product-name');
    console.log(product_id);
    // создадим пустой объект
    var $data = {};
    $data['product_id'] = product_id;
    $data['product_name'] = product_name;
// переберём все элементы input, textarea и select формы с id="myForm "
    $('.questionnaire-form').find ('.form-request-item input[type="text"], .form-request-item input[type="tel"], .form-request-item input[type="email"],.form-request-item input[type="radio"]:checked, .form-request-item textarea, select').each(function() {
        // добавим новое свойство к объекту $data
        // имя свойства – значение атрибута name элемента
        // значение свойства – значение свойство value элемента
        $data[this.name] = $(this).val();
    });

    if ($('input[type="checkbox"][name="emDxFmHm1LidKT_L89icr"]:checked').length > 0) {
        var emDxFmHm1LidKT_L89icr = []
        $('.questionnaire-form').find($('input[type="checkbox"][name="emDxFmHm1LidKT_L89icr"]:checked')).each(function(){
            emDxFmHm1LidKT_L89icr.push($(this).val())

        })
        $data['emDxFmHm1LidKT_L89icr'] = emDxFmHm1LidKT_L89icr
    }

    if ($('input[type="checkbox"][name="BCy65jqX6Q1FJN1rePAZ4"]:checked').length > 0) {
        var emDxFmHm1LidKT_L89icr = []
        $('.questionnaire-form').find($('input[type="checkbox"][name="BCy65jqX6Q1FJN1rePAZ4"]:checked')).each(function(){
            emDxFmHm1LidKT_L89icr.push($(this).val())

        })
        $data['BCy65jqX6Q1FJN1rePAZ4'] = emDxFmHm1LidKT_L89icr
    }

    var countryData = $("#country").countrySelect("getSelectedCountryData");

    $data['country'] = countryData['iso2'].toUpperCase();

    validateText()



    // Add dob
    // $('.form-input-dob').each(function() {
    //     if($(this).val() == '' && $(this).val().length <= 0) {
    //         $(this).addClass('is-invalid')
    //     } else {
    //         $(this).removeClass('is-invalid')
    //     }
    // })



    if ($('#dobyear').val() != '' && $('#dobyear').val().length != 0 && $('#dobmonth').val() != '' && $('#dobmonth').val().length != 0 && $('#dobday').val() != '' && $('#dobday').val().length != 0) {
        $data['dob'] = [$('#dobyear').val(), $('#dobmonth').val(), $('#dobday').val()].join('-')
        $('.form-input-dob').removeClass('is-invalid')
    }// Add dob


    // Validate radio
    let data_arr = [ 'gender','emDxFmHm1LidKT_L89icr', '3hC7sLm3JSsfqiM0ulcX8338', '0iw4CyzoA1R1jxkRdnnk9', 'TB3HclExciO9S0_uRTCLt', 'ZYA6ioeD3WkrWO0PAD7lX', 'KSW2s9naDT7hcdyY85xoj', '9rorbO3lgeONaNXt3h4V2', 'zCQ_zzpbA6CN15X86UA0m', 'gXRgxbIbZgk~MiqKaDCZA', 'evn4c1CYWy_IXe_T~a7~N'];

    for(i=0; i<data_arr.length; i++) {
        validateRadio(data_arr[i])
    }// Validate radio

    if($('.is-invalid').length > 0 ) {

        closeAlert()
        showAlert("error", "<strong>Please fill in all fields\n</strong>");
        return false
        // if( 10 == 20) {

    } else {
        console.log($data)
        sessionStorage['data'] = JSON.stringify($data);
        // var form_data = JSON.stringify($data)
        var form_data = JSON.stringify($data)
        closeAlert()

        $.ajax({
            url: "/wp/wp-admin/admin-ajax.php",
            type: "POST",
            dataType: "JSON",
            data: {
                'action': 'cloudcheck_send_request_heydoc',
                'data': $data
            },
            cache: false,
            beforeSend: function(){
                $('.questionnarie-submit.clicked').addClass('spinwheel')
            },
            success: function(data) {
                $('.questionnarie-submit.clicked').removeClass('spinwheel')
                console.log("Cloudcheck response: " + JSON.stringify(data));
                if(JSON.stringify(data.status) == 500) {
                    showAlert("error", "<strong>Some of the fields were not filled. Please fill in all fields or contact the site support.</strong>");
                } else if (JSON.stringify(data.status) == 400) {
                    showAlert("error", "<strong>Some of the fields were not filled. Please fill in all fields or contact the site support.</strong>");
                }

            },
            error:function (xhr, ajaxOptions, thrownError){
                $('.questionnarie-submit').removeClass('spinwheel')
                if(xhr.status == 404) {
                    showAlert("error", "<strong>Something went wrong. Please try again or contact the site support.</strong>");
                } else if(xhr.responseText == 'error') {
                    showAlert("error", "<strong>Seems to be an internal error. Please try again or contact site support.</strong>");
                } else if(xhr.responseText.status == 400) {
                    showAlert("error", "<strong>Some of the fields were not filled. Please fill in all fields or contact the site support.</strong>");
                } else if (xhr.responseText.status == undefined || xhr.responseText.status == '') {
                    global_dob($data['dob']);
                    setTimeout( 'location="/cart/?add-to-cart='+product_id+'";', 100 );
                }
            }
        });
    }


    event.preventDefault();
});
