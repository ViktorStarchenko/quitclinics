// Show/hide Smokers radio
$('input[name="1yrGn~WZFBQ17nwr54W7v"]').on('click', function(){
    if($(this).val() == 'I\'ve never smoked') {
        $('.never-smoke').removeClass('hidden');
        $('.for-smokers').addClass('hidden');
        $('.for-smokers').removeClass('form-request-item');
        $('.hidden-fields').addClass('hidden');
        $(".questionnarie-sumit").attr("disabled", true);
    } else if ($(this).val() == 'Current/Ex-smoker') {
        $('.never-smoke').addClass('hidden');
        $('.for-smokers').removeClass('hidden');
        $('.for-smokers').addClass('form-request-item');
        $('.hidden-fields').removeClass('hidden');
        $(".questionnarie-sumit").attr("disabled", false);

    }
})
// Show/hide Nicotine Vaping radio
$('input[name="emDxFmHm1LidKT_L89icr"]').on('click', function(){
    if ($('input:checkbox[value="Nicotine Vaping"]').is(":checked")) {
        $('.nicotine-vaping').removeClass('hidden');
        $('.nicotine-vaping').addClass('form-request-item');
    } else if (!$('input:checkbox[value="Nicotine Vaping"]').is(":checked")) {
        $('.nicotine-vaping').addClass('hidden');
        $('.nicotine-vaping').removeClass('form-request-item');
        $( '.nicotine-vaping input' ).prop( "checked", false );
    }

})
// Show/hide Female radio
$('input[name="gender"]').on('click', function(){
    if($(this).val() == 'female') {
        $('.female').removeClass('hidden');
        $('.female').addClass('form-request-item');
    } else {
        $('.female').addClass('hidden');
        $('.female').removeClass('form-request-item');
        $( '.female input' ).prop( "checked", false );
    }
})

$("#country").countrySelect({
    defaultCountry: "gb",
    responsiveDropdown: true
});
var submit_cancel = true;
// Validate Radio
function validateRadio(data) {
    $('input[name="'+data+'"]').closest('.qc-form-group').removeClass('is-invalid')
    // console.log($('input[type="checkbox"][name="'+data+'"]'))
    if($('.form-request-item input[name="'+data+'"]:checked').length <=0) {
        submit_cancel = false;
        $('input[name="'+data+'"]').closest('.form-request-item').addClass('is-invalid')

        // console.log($('input[type="radio"][name="gender"]').closest('.form-group'))
    } else {
        submit_cancel = true;
        $('input[name="'+data+'"]').closest('.qc-form-group').removeClass('is-invalid')
    }
}
function validateText() {
    $('.questionnaire-form').find('input[type="text"], input[type="email"], input[type="tel"]').each(function() {
        console.log($(this))
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




$('.btn').on('click', function(){
    $(".questionnaire-form").submit()
    return false
})
$(".questionnaire-form").submit(function(event) {
    // создадим пустой объект
    var $data = {};
// переберём все элементы input, textarea и select формы с id="myForm "
    $('.questionnaire-form').find ('.form-request-item input[type="text"], .form-request-item input[type="tel"], .form-request-item input[type="email"],.form-request-item input[type="radio"]:checked, .form-request-item textearea, select').each(function() {
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

    var countryData = $("#country").countrySelect("getSelectedCountryData");

    $data['country'] = countryData['iso2'].toUpperCase()

    validateText()

    // for (const [key, value] of Object.entries($data)) {
    //     var nam = `${key}`
    //     var val = `${value}`
    //     if (val == '' && val.length <= 0 || nam.length <= 0) {
    //         let name = `${key}`
    //         submit_cancel = false;
    //         $('.form-request-item [name="'+nam+'"]').parent().addClass('is-invalid')
    //     } else {
    //         submit_cancel = true;
    //         $('.form-request-item [name="'+nam+'"]').parent().removeClass('is-invalid')
    //     }
    // }

    // Add dob
    $('.form-input-dob').each(function() {
        if($(this).val() == '' && $(this).val().length <= 0) {
            $(this).addClass('is-invalid')
        } else {
            $(this).removeClass('is-invalid')
        }
    })
    if ($('#dobyear').val() != '' && $('#dobyear').val().length != 0 && $('#dobmonth').val() != '' && $('#dobmonth').val().length != 0 && $('#dobday').val() != '' && $('#dobday').val().length != 0) {
        $data['dob'] = [$('#dobyear').val(), $('#dobmonth').val(), $('#dobday').val()].join('-')
        $('.form-input-dob').removeClass('is-invalid')
    }// Add dob


    // Validate radio
    let data_arr = [ 'gender','emDxFmHm1LidKT_L89icr', '1yrGn~WZFBQ17nwr54W7v', '0iw4CyzoA1R1jxkRdnnk9', 'TB3HclExciO9S0_uRTCLt', 'ZYA6ioeD3WkrWO0PAD7lX', 'KSW2s9naDT7hcdyY85xoj', '9rorbO3lgeONaNXt3h4V2', 'zCQ_zzpbA6CN15X86UA0m', 'gXRgxbIbZgk~MiqKaDCZA', 'evn4c1CYWy_IXe_T~a7~N'];

    for(i=0; i<data_arr.length; i++) {
        validateRadio(data_arr[i])
    }// Validate radio

    if($('.is-invalid').length > 0 ) {

        closeAlert()
        showAlert("error", "<strong>Please fill in all fields\n</strong>");
        return false
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
                // showAlert("warning", "<strong>Sending a request.</strong>");
                $('.questionnarie-submit').addClass('spinwheel')
            },
            success: function(data) {
                $('.questionnarie-submit').removeClass('spinwheel')
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
                    // showAlert("success", "<strong>It seems there are no errors on our part</strong>");
                    setTimeout( 'location="/cart/?add-to-cart=738";', 100 );
                }
                // console.log(xhr.status);
                // console.log(xhr.statusText);
                // console.log(xhr.responseText);
            }
        });
    }


    console.log('HELLLO')


    event.preventDefault();
})
