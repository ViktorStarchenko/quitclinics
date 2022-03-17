

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


function updateDob() {
    var str = jQuery('.dob-hidden').val();
    var arr = str.split("-");

    jQuery('#dobday').val(arr[2]);
    jQuery('#dobmonth').val(arr[1]);
    jQuery('#dobyear').val(arr[0]);
}
setTimeout(updateDob, 200)



// Validation functions
var submit_cancel = true;

// Validate Radio
function validateRadio(data) {
    $('input[name="'+data+'"]').closest('.qc-form-group').removeClass('is-invalid')
    // console.log($('input[name="'+data+'"]'))
    if($('.form-request-item input[name="'+data+'"]:checked').length <=0) {
        submit_cancel = false;
        $('input[name="'+data+'"]').closest('.form-request-item.qc-form-group').addClass('is-invalid')
console.log('НЕ ЧЕКНУТО')
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



$('.questionnarie-submit').on('click', function(){
    jQuery(this).addClass('clicked')

    $(".questionnaire-form").submit();
    return false
})
$(".questionnaire-form").submit(function(event) {

    // создадим пустой объект
    var $data = {};

// переберём все элементы input, textarea и select формы с id="myForm "
    $('.questionnaire-form').find ('.form-request-item input[type="text"], .form-request-item input[type="tel"], .form-request-item input[type="email"],.form-request-item input[type="radio"]:checked, .form-request-item textarea, select').each(function() {
        console.log($(this).val());
        // добавим новое свойство к объекту $data
        // имя свойства – значение атрибута name элемента
        // значение свойства – значение свойство value элемента
        $data[this.name] = $(this).val();
    });


    if ($('#dobyear').val() != '' && $('#dobyear').val().length != 0 && $('#dobmonth').val() != '' && $('#dobmonth').val().length != 0 && $('#dobday').val() != '' && $('#dobday').val().length != 0) {
        $data['dob'] = [$('#dobyear').val(), $('#dobmonth').val(), $('#dobday').val()].join('-')
        $('.form-input-dob').removeClass('is-invalid')
    }// Add dob

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


    validateText()



    // Add dob
    // $('.form-input-dob').each(function() {
    //     if($(this).val() == '' && $(this).val().length <= 0) {
    //         $(this).addClass('is-invalid')
    //     } else {
    //         $(this).removeClass('is-invalid')
    //     }
    // })




    // Validate radio
    let data_arr = [ 'gbHG9mDZV7bRmXggwJyYI4'];

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
                'action': 'cloudcheck_send_request_heydoc_renewal',
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
                    // setTimeout( 'location="/cart/?add-to-cart='+product_id+'";', 100 );
                    showAlert("success", "<strong>Medical history has been successfully saved.</strong>");
                }
            }
        });
    }


    event.preventDefault();
});
