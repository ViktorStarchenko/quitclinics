(function($) {

    $(".cloudcheckForm").submit(function(event) {
        console.log($(this))
        closeAlert()



        // Prevent spam click and default submit behaviour
        // $(".btnSubmit").attr("disabled", true);
        event.preventDefault();

        // get basic info from FORM
        var name = $(this).find("input.name").val();
        var surname = $(this).find("input.surname").val();
        var middlename = $(this).find("input.middlename").val();
        var dateofbirth = $(this).find("input.dateofbirth").val();
        var city = $(this).find("input.city").val();
        var suburb = $(this).find("input.suburb").val();
        var streetnumber = $(this).find("input.streetnumber").val();
        var street = $(this).find("input.street").val();
        var postcode = $(this).find("input.postcode").val();

        // get dob from FORM
        var dobmonth = $(this).find('select.dobmonth').val();
        var dobyear = $(this).find('select.dobyear').val();
        var dobday = $(this).find('select.dobday').val();
        // Add dob
        if(dobyear && dobmonth && dobday){
            if (dobyear != '' && dobyear.length != 0 && dobmonth != '' && dobmonth.length != 0 && dobday != '' && dobday.length != 0) {
                var dob = [dobyear, dobmonth, dobday].join('-')
            }
        }


        //get emails from FORM for sending resulted PDF
        var clientemail = $("input#clientemail").val();
        var agentemail = $("input#agentemail").val();
        var adminemail = $("input#adminemail").val();
        var emailList = [clientemail, agentemail, adminemail];

        //get NZ specific fields from FORM
        var nz_passportnumber = $("input#nz_passportnumber").val();
        var nz_passportexpiry = $("input#nz_passportexpiry").val();
        var nz_driverlicensenumber = $("input#nz_driverlicensenumber").val();
        var nz_driverlicenseversion = $("input#nz_driverlicenseversion").val();
        var nz_vehicleplatenumber = $("input#nz_vehicleplatenumber").val();
        var nz_birthcertificate = $("input#nz_birthcertificate").val();
        var nz_citizenshipcertificate = $("input#nz_citizenshipcertificate").val();
        var nz_citizenshipcountryofbirth = $("input#nz_citizenshipcountryofbirth").val();

        //get AU specific fields from FORM
        var au_passportnumber = $("input#au_passportnumber").val();
        var au_passportgender = $("select#au_passportgender").val();
        var au_citizenshipacquisitiondate = $("input#au_citizenshipacquisitiondate").val();
        var au_citizenshipbydescent = $("input#au_citizenshipbydescent").is(":checked");
        var au_citizenshipstocknumber = $("input#au_citizenshipstocknumber").val();
        var au_driverlicensenumber = $("input#au_driverlicensenumber").val();
        var au_driverlicensestate = $("select#au_driverlicensestate").val();
        var au_visacountryofissue = $("input#au_visacountryofissue").val();
        var au_visapassportnumber = $("input#au_visapassportnumber").val();
        var au_immicardnumber = $("input#au_immicardnumber").val();


        //prepare json data
        var data = { 'details' : {}, 'reference' : '1', 'consent': 'Yes', 'capturereference': 'a09b1dc5-ea4f-4591-9e44-1fca76dfd000' };

        data.details.name = { 'given' : name, 'family': surname };
        if ( middlename ) {
            data.details.name.middle = middlename;
        }
        // data.details.dateofbirth = dateofbirth;
        data.details.dateofbirth = dob;
        data.details.address = { 'city' : city,
            'suburb' : suburb,
            'postcode' : postcode,
            'streetname' : street,
            'streetnumber' : streetnumber };

        if ( nz_passportnumber ) {
            data.details.passport = { 'number' : nz_passportnumber,
                'expiry' : nz_passportexpiry };
        };
        if ( nz_driverlicensenumber ) {
            data.details.driverslicence = { 'number' : nz_driverlicensenumber,
                'version' : nz_driverlicenseversion };
        };
        if ( nz_vehicleplatenumber ) {
            data.details.vehicle = { 'numberplate' : nz_vehicleplatenumber };
        };
        if ( nz_birthcertificate ) {
            data.details.birthcertificate = { 'registrationnumber' : nz_birthcertificate };
        };
        if ( nz_citizenshipcertificate ) {
            data.details.citizenship = { 'certificatenumber' : nz_citizenshipcertificate,
                'countryofbirth' : nz_citizenshipcountryofbirth };
        };
        if ( au_passportnumber ) {
            data.details.australianpassport = { 'number' : au_passportnumber,
                'gender' : au_passportgender };
        };
        if ( au_visapassportnumber ) {
            data.details.visa = { 'passportnumber' : au_visapassportnumber,
                'countryofissue' : au_visacountryofissue };
        };
        if ( au_driverlicensenumber ) {
            data.details.australiandriverslicence = { 'number' : au_driverlicensenumber,
                'state' : au_driverlicensestate };
        };
        if ( au_citizenshipacquisitiondate ) {
            if ( au_citizenshipbydescent == true ) {
                data.details.citizenshipbydescent = { 'acquisitiondate' : au_citizenshipacquisitiondate };
            } else {
                data.details.australiancitizenship = { 'acquisitiondate' : au_citizenshipacquisitiondate,
                    'stocknumber' : au_citizenshipstocknumber };
            }
        };
        if ( au_immicardnumber ) {
            data.details.immicard = { 'number' : au_immicardnumber };
        };


        var requestJson = JSON.stringify(data);
        // console.log("Cloudcheck request: " + requestJson);
        showAlert("success", "<strong>We are verifying your details.</strong>");


        let is_agreed = $('input[name="is_agreed"]:checked').val();
        console.log(is_agreed)
        if (is_agreed == 'is_agreed') {
            console.log('Да, отмечено')
            if ($(this).find("input#file").val() ) {
                mrz(requestJson)
            } else {
                au_nz_verification(requestJson)
            }
        } else {

        }
        // au_nz_verification(requestJson)
    }); //cloudcheckForm submit


    // Global DOB
    function global_dob(data) {
        console.log(data)
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
                    console.log('DOB success')
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
                    console.log('DOB success')
                }
            },
        });
    }// Global DOB


    // Agreement checkox
    function global_agreement() {
        var fd = new FormData();
        let is_agreed = $('input[name="is_agreed"]:checked').val();
        var user_id = $('#user_id').val();
        console.log($('#user_id').val())
        var fd = new FormData();
        if(user_id) {
            fd.append('user_id',user_id);
            fd.append('is_agreed',is_agreed);
            fd.append('action','global_agreement');
        } else {
            fd.append('is_agreed',is_agreed);
            fd.append('action','global_agreement');
        }

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
                showAlert(data.type, "<p><strong>"+ data.message +"</strong></p>");
                if(data.type == 'success') {
                    $('.checkout-wrapper').addClass('ready')
                    console.log('entry made')
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(xhr.statusText);
                console.log(xhr.responseText);
                console.log(thrownError);
                console.log(ajaxOptions);
                showAlert("error", "<p><strong>"+ xhr.responseText +"</strong></p>");
                if ( xhr.responseText == 'success0') {
                    console.log('agreement was successful')
                } else {

                }
            },
        });
    }// Global verification


    // Global verification
    function global_verification() {
        var user_id = $('#user_id').val();
        console.log($('#user_id').val())
        var fd = new FormData();
        if(user_id) {
            fd.append('user_id',user_id);
            fd.append('action','cloudcheck_global_verification');
        } else {
            fd.append('action','cloudcheck_global_verification');
        }
        $.ajax({
            url: "/wp/wp-admin/admin-ajax.php",
            type: "POST",
            dataType: "JSON",
            data: fd,
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
                console.log(data)
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(xhr.statusText);
                console.log(xhr.responseText);
                showAlert("success", "<p><strong>"+ xhr.responseText +"</strong></p>");
                global_agreement()
            },
        });
    }// Global verification

    function au_nz_verification(requestJson){
        $.ajax({
            url: "/wp/wp-admin/admin-ajax.php",
            type: "POST",
            dataType: "JSON",
            data: {
                'action': 'cloudcheck_send_request',
                'request': requestJson,
                'path': '/verify/'
            },
            cache: false,
            beforeSend: function(){
                // showAlert("warning", "<strong>Sending a request.</strong>");
                $('.btnSubmit').addClass('spinwheel');
            },
            success: function(data) {
                $('.btnSubmit').removeClass('spinwheel');
                console.log(data)
                if (data.verification.validated['dateofbirth'] == true && data.verification.validated['name'] == true) {
                    console.log('all true')
                    $('.checkout-wrapper').addClass('ready')
                    showAlert("success", "<p><strong>Verification completed successfully.</strong></p>");
                    global_verification()
                    global_dob(data.verification.details['dateofbirth'])
                } else {
                    showAlert("error", "<p><strong>Some of the required data was not received or was received incorrectly. Please fill in the fields and try again.</strong></p>");
                    showModal()
                }
                var ref = data.verification.verificationReference;
                var errorDetail = data.verification.errorDetail;
                var errorMessage = data.verification.message;
                var errorCode = data.verification.error;
                var errorFields = data.verification.fields;

                $("#btnSubmit").attr("disabled", false);

            },
            error: function() {
                $('.btnSubmit').removeClass('spinwheel');
                // Fail message
                showAlert("error", "<strong>It seems that Cloudcheck service is not responding. Please try again later</strong>");
                // Enable button
                showModal()
                $("#btnSubmit").attr("disabled", false);
            },
        });
    } // main function


    function mrz(requestJson) {

        const inputElement = document.getElementById("file");
        var image_object = JSON.parse(JSON.stringify(inputElement.files[0]))

        var fd = new FormData();
        var files = $('#file')[0].files;


        console.log(fd)

        var tt = JSON.parse(JSON.stringify(requestJson))
        // console.log(tt)
        // var fileInput = document.getElementById('file').files[0]
        // var fileInput = $('#file').val()
        var fileInput = document.getElementById("file").files[0].name
        var data_array = {"reference": "MRZ Check 101", "consent": "Yes"}
        var data_detail = JSON.parse(JSON.stringify(data_array))

        // var file = 'http://c.vsbookcollection.space/wp-content/uploads/2021/02/8.jpg'
        console.log(data_detail)

        fd.append('file',files[0]);
        fd.append('action','cloudcheck_send_request_ss');
        fd.append('path','/mrz/runcheck/');
        fd.append('data',{"reference": "MRZ Check 101", "consent": "Yes"});
        fd.append('file',fileInput);

        $.ajax({
            url: "/wp/wp-admin/admin-ajax.php",
            type: "POST",
            dataType: "JSON",
            data: fd,
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function(){
                // showAlert("warning", "<strong>Sending a request.</strong>");
                $('.btnSubmit').addClass('spinwheel');
            },
            success: function(data) {
                $('.btnSubmit').removeClass('spinwheel');
                console.log("Cloudcheck response: " + JSON.stringify(data));
                // console.log("Cloudcheck response: " + data);
                if (JSON.stringify(data.notes)) {
                    showAlert("error", "<strong>" + JSON.stringify(data.notes) + "</strong>");
                    showModal()
                } else if (JSON.stringify(data.verification)) {
                    // showAlert("error", "<strong>" + JSON.stringify(data.verification) + "</strong>");
                    showAlert("error", "<strong>" + JSON.stringify(data.verification.message) + "</strong>");
                    showModal()
                } else if (JSON.stringify(data.error)) {
                    showAlert("error", "<strong>" + JSON.stringify(data.message) + "</strong>");
                    showModal()
                } else {
                    showAlert("success", "<strong>Verification completed successfully.</strong> ");
                    $('.checkout-wrapper').addClass('ready')
                    showAlert("success", "<p><strong>Verification completed successfully.</strong></p>");
                    global_verification()
                }
            },
            error: function() {
                $('.btnSubmit').removeClass('spinwheel');
                // Fail message
                showAlert("error", "<strong>It seems that Cloudcheck service is not responding.</strong>");
            },



        });


    } //mrz


    function getPdf(reference, emailList) {
        $.ajax({
            // url: "/wp-admin/admin-ajax.php",
            url: "/wp/wp-admin/admin-ajax.php",
            type: "POST",
            dataType: "JSON",
            data: {
                'action': 'cloudcheck_send_request',
                'request': reference,
                'path': '/verify/pdf'
            },
            cache: false,
            success: function(data) {
                // console.log("Cloudcheck response: " + JSON.stringify(data));
                showAlert("success", "<strong>Verification completed successfully. Getting resulted PDF...</strong>");

                //open pdf in new tab
                window.open(data.pdfUrl, '_blank');
                //send email
                sendEmail(emailList, data.pdfPath);
            },
            error: function() {
                // Fail message
                showAlert("error", "<strong>It seems that Cloudcheck service is not responding.</strong>");
            },
        });
    } //getPdf

    function sendEmail(emailList, filepath) {
        console.log("Sending email to: " + JSON.stringify(emailList));
        console.log("Attachment: " + filepath);
        $.ajax({
            // url: "/wp-admin/admin-ajax.php",
            url: "/wp/wp-admin/admin-ajax.php",
            type: "POST",
            dataType: "JSON",
            data: {
                'action': 'cloudcheck_send_email',
                'emaillist': emailList,
                'filepath' : filepath
            },
            cache: false,
            success: function(data) {
                // console.log("Cloudcheck response: " + JSON.stringify(data));
                showAlert("success", "<strong>Verification completed successfully. Resulted PDF has been sent by email</strong>");
            },
            error: function() {
                // Fail message
                showAlert("error", "<strong>Couldn't send resulted PDF by email. Please, check settings of email server</strong>");
            },
        });
    } //sendEmail

    function showAlert(type, text) {
        if (type == 'error') {
            $('#success').html("<div class='alert alert-danger'>");
            $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>");
            $('#success > .alert-danger').append(text);
            $('#success > .alert-danger').append('</div>');
        } else {
            $('#success').html("<div class='alert alert-success'>");
            $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>");
            $('#success > .alert-success').append(text);
            $('#success > .alert-success').append('</div>');
        }
        setTimeout(closeAlert, 100)
    } //showAlert

    $("input#au_citizenshipbydescent").change(function (event) {
        var au_citizenshipbydescent = $("input#au_citizenshipbydescent").is(":checked");
        if(this.checked) {
            $("#div_au_citizenshipstocknumber").hide();
        } else {
            $("#div_au_citizenshipstocknumber").show();
        }
    });

    function closeAlert(){
        $('#success .close').on('click', function(){
            $('#success .alert').remove();
            $(".btnSubmit").attr("disabled", false);
        })
    }

    // get NZ DOB fields from FORM
    $.dobPicker({
        // Selectopr IDs
        daySelector: '#nz_dobday',
        monthSelector: '#nz_dobmonth',
        yearSelector: '#nz_dobyear',
        // Default option values
        dayDefault: 'Day',
        monthDefault: 'Month',
        yearDefault: 'Year',
        // Minimum age
        // minimumAge: 18,
        // Maximum age
        maximumAge: 110
    });

    // get AU DOB fields from FORM
    $.dobPicker({
        // Selectopr IDs
        daySelector: '#au_dobday',
        monthSelector: '#au_dobmonth',
        yearSelector: '#au_dobyear',
        // Default option values
        dayDefault: 'Day',
        monthDefault: 'Month',
        yearDefault: 'Year',
        // Minimum age
        // minimumAge: 18,
        // Maximum age
        maximumAge: 110
    });





///////////////////////////////////// TELEPHONE MASK///////////////////
//     $(".date-mask").mask("12354");



    // $( ".dateofbirth" ).focus(function() {
    //     $(".dateofbirth").prop("type", "date");
    //     $(".dateofbirth").prop("placeholder", "yyyy-mm-dd");
    // })
    // $( ".dateofbirth" ).focusout(function() {
    //     $(".dateofbirth").prop("type", "text");
    //     $(".dateofbirth").prop("placeholder", "Date of birth");
    // })

    // $('.dateofbirth').datepicker({
    //     format: 'yyyy-mm-dd'
    // });
}) ( jQuery );


