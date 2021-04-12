<?php
function cloudcheck_shortcodes_init()
{

    /** Enclosing main shortcode that shows the main container form.
     *  All other shortcodes must be placed inside this one.
     */
    function cloudcheck_main_form_shortcode($atts = [], $content = null)
    {
        $form = '<head><!-- <link rel="stylesheet" href="/app/plugins/cloudcheck/css/bootstrap.min.css">--><link rel="stylesheet" href="/app/plugins/cloudcheck/css/datepicker.min.css"><link rel="stylesheet" href="/app/plugins/cloudcheck/css/custom-styles.css"></head>
            <section id="cloudcheck_section">
                <div class="container">
                    <div class="row">
                <form id="cloudcheckForm" class="cloudcheckForm">'
            . do_shortcode($content)
            . '<div class="row">
                    <div class="qc-form-group w100">
                        <div class="form-check-group">
                            <div class="form-check">
                                <input class="form-check-input" name="is_agreed" type="checkbox" data-testid="checkbox" id="is_agreed" tabindex="-1" value="is_agreed" required>
                                <span class="custom-check-input"></span>
                                <div class="d-flex">
                                <label class="form-check-label bio" for="is_agreed" style="display:inline-block">I confirm I am the legal owner of the ID submitted and consent to my ID information only being shared with authorised third parties so that Quit Clinics can confirm my identity and date of birth. All medical information provided is strictly confidential, and will not be shared with any third party without my express written consent.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="form-group col-xs-12">
                        <button id="btnSubmit" class="btn-body btn-blue  btnSubmit button-primary" type="submit">Verify</button>
                    </div>
                    </div>
                </form>
                </div>
               
            </section>
            <!-- <script type="text/javascript" src="/app/plugins/cloudcheck/js/bootstrap.min.js"></script> -->
		    <script type="text/javascript" src="/app/plugins/cloudcheck/js/jquery-3.5.1.min.js"></script>
            <script type="text/javascript" src="/app/plugins/cloudcheck/js/datepicker.min.js"></script>
            <script type="text/javascript" src="/app/plugins/cloudcheck/js/dobpicker.js"></script>
            <script type="text/javascript" src="/app/plugins/cloudcheck/js/cloudcheck.js"></script>';
        return $form;
    }
    add_shortcode('cloudcheck_main_form', 'cloudcheck_main_form_shortcode');


    /** Shortcode that shows basic fields always required for verification:
     *  first name, middle name, surname, address
     */
    function cloudcheck_basic_info_shortcode($atts = [], $content = null)
    {
        $info = '<h5>Identity Verification</h5>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls ml-3">
							<label>Given Name</label>
                            <input id="name" class="form-control name" required type="text" placeholder="Given Name" />
                        </div>
                        <div class="form-group hidden col-xs-12 floating-label-form-group controls ml-3">
							<label>Middle Name</label>
                            <input id="middlename" class="form-control middlename"  type="text" placeholder="Middle Name"/>
                        </div>
                        <div class="form-group col-xs-12 floating-label-form-group controls mx-3">
							<label>Family Name</label>
                            <input id="surname" class="form-control surname" required type="text" placeholder="Family Name"/>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group hidden col-xs-12 floating-label-form-group controls mx-3">
							<label class="label-show">Date of birth</label>
                            <input id="dateofbirth" class="form-control dateofbirth date-mask"  type="text" placeholder="Date of birth"  />
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group hidden col-xs-12 floating-label-form-group controls ml-3">
							<label>Postcode</label>
                            <input id="postcode" class="form-control postcode" required type="text" placeholder="Postcode" value="1111" />
                        </div>
                        <div class="form-group hidden col-xs-12 floating-label-form-group controls ml-3">
							<label>City</label>
                            <input id="city" class="form-control city" required type="text" placeholder="City" value="city"/>
                        </div>
                        <div class="form-group hidden col-xs-12 floating-label-form-group controls mx-3">
							<label>Suburb</label>
                            <input id="suburb" class="form-control suburb" required type="text" placeholder="Suburb" value="suburb"/>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group hidden col-xs-12 floating-label-form-group controls ml-3">
							<label>Street</label>
                            <input id="street" class="form-control street" required type="text" placeholder="Street" value="street"/>
                        </div>
                        <div class="form-group hidden col-xs-12 floating-label-form-group controls mx-3">
							<label>Street number</label>
                            <input id="streetnumber" class="form-control streetnumber" required type="text" placeholder="Street number" value="1"/>
                        </div>
                    </div>';

        return $info;
    }
    add_shortcode('cloudcheck_basic_info', 'cloudcheck_basic_info_shortcode');

    /** Shortcode that shows MRZ checks:
     *  Client MRZ copy
     */
    function cloudcheck_mrz_shortcode($atts = [], $content = null)
    {
        $mrz = '<h5>MRZ</h5>
<p>Please upload a copy of your passport for verification</p>
                   <div class="row control-group">
                          <div class="form-group col-xs-12 floating-label-form-group controls ml-3">
							  <label>MRZ</label>
                              <input id="file" class="form-control file" required type="file" placeholder="Client email"/>
                          </div>
                          
                       
                    </div>';
        return $mrz;
    }
    add_shortcode('cloudcheck_mrz', 'cloudcheck_mrz_shortcode');

    /** Shortcode that shows NZ DOB fields:
     *  Client MRZ copy
     */
    function cloudcheck_nz_dob_shortcode($atts = [], $content = null)
    {
        $nz_dob = '<h5>Date of Birth</h5>
                   <div class="row control-group">
                          <div class="form-group col-xs-12 floating-label-form-group controls ml-3">
							  <label>Date of birth</label>
                              <select class="form-control form-input2 form-input-dob dobday" id="nz_dobday"></select>
                              <select class="form-control form-input2 form-input-dob dobmonth" id="nz_dobmonth"></select>
                              <select class="form-control form-input2 form-input-dob dobyear" id="nz_dobyear"></select>
                          </div>
                          
                       
                    </div>';
        return $nz_dob;
    }
    add_shortcode('cloudcheck_nz_dob', 'cloudcheck_nz_dob_shortcode');

    /** Shortcode that shows AU DOB fields:
     *  Client MRZ copy
     */
    function cloudcheck_au_dob_shortcode($atts = [], $content = null)
    {
        $au_dob = '<h5>Date of Birth</h5>
                   <div class="row control-group">
                          <div class="form-group col-xs-12 floating-label-form-group controls ml-3">
							  <label>Date of birth</label>
                              <select class="form-control form-input2 form-input-dob dobday" id="au_dobday"></select>
                              <select class="form-control form-input2 form-input-dob dobmonth" id="au_dobmonth"></select>
                              <select class="form-control form-input2 form-input-dob dobyear" id="au_dobyear"></select>
                          </div>
                          
                       
                    </div>';
        return $au_dob;
    }
    add_shortcode('cloudcheck_au_dob', 'cloudcheck_au_dob_shortcode');


    /** Shortcode that shows email fields:
     *  Client email, Agent email, Administrator email
     */
    function cloudcheck_emails_shortcode($atts = [], $content = null)
    {
        $emails = '<h5>Send Result To</h5>
                   <div class="row control-group">
                          <div class="form-group col-xs-12 floating-label-form-group controls ml-3">
							  <label>Client email</label>
                              <input id="clientemail" class="form-control" required type="email" placeholder="Client email"/>
                          </div>
                          <div class="form-group col-xs-12 floating-label-form-group controls ml-3">
							  <label>Agent email</label>
                              <input id="agentemail" class="form-control" required type="email" placeholder="Agent email"/>
                          </div>
                          <div class="form-group col-xs-12 floating-label-form-group controls mx-3">
							  <label>Administrator email</label>
                              <input id="adminemail" class="form-control" required type="email" placeholder="Administrator email" />
                          </div>
                    </div>';
        return $emails;
    }
    add_shortcode('cloudcheck_emails', 'cloudcheck_emails_shortcode');


    /** Shortcode that shows fields for verification by NZ passport:
     *  passport number, passport expiry
     */
    function cloudcheck_nz_passport_shortcode($atts = [], $content = null)
    {
        $passport = '<h5>New Zealand Passport</h5>
            <div class="row control-group">
            <div class="form-group col-xs-12 floating-label-form-group controls ml-3">
                <label>Passport Number</label>
                <input id="nz_passportnumber" class="form-control" type="text" pattern="^[A-Za-z]{2}[0-9]{6}$" title="Passport number can contain exactly 2 letters and 6 digits " placeholder="Passport number" />
            </div>
            <div class="form-group col-xs-12 floating-label-form-group controls mx-3">
                <label>Passport Expiry</label>
                <input id="nz_passportexpiry" class="form-control" type="date" placeholder="Passport expiry" />
            </div></div>';

        return $passport;
    }
    add_shortcode('cloudcheck_nz_passport', 'cloudcheck_nz_passport_shortcode');


    /** Shortcode that shows fields for verification by NZ driving license via NZTA:
     *  driving license number, driving llicense version
     */
    function cloudcheck_nz_driving_license_shortcode($atts = [], $content = null)
    {
        $driving = '<h5>New Zealand Driving License</h5>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls ml-3">
                    <label>Driver License Number</label>
                    <input id="nz_driverlicensenumber" class="form-control" type="text" pattern="^[A-Za-z]{2}[0-9]{6}$" title="License number can contain exactly 2 letters and 6 digits" placeholder="Driver license number" />
                </div>
                <div class="form-group col-xs-12 floating-label-form-group controls mx-3">
                    <label>Driver License Version</label>
                    <input id="nz_driverlicenseversion" class="form-control" type="text" pattern="^[0-9]{3}$" title="License version can contain exactly 3 digits" placeholder="Driver license version" />
                </div>
            </div>';

        return $driving;
    }
    add_shortcode('cloudcheck_nz_driving_license', 'cloudcheck_nz_driving_license_shortcode');


    /** Shortcode that shows fields for verification by vehicle plate number via NZTA:
     *  vehicle number plate
     */
    function cloudcheck_nz_vehicle_plate_number_shortcode($atts = [], $content = null)
    {
        $plate = '<h5>New Zealand Vehicle</h5>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls ml-3">
                    <label>Vehicle Plate Number</label>
                    <input id="nz_vehicleplatenumber" class="form-control" type="text" pattern="^[A-Za-z0-9]{1,6}$" title="Plate number can contain not more than 6 digits and letters" placeholder="Vehicle plate number" />
                </div>
            </div>';

        return $plate;
    }
    add_shortcode('cloudcheck_nz_vehicle_plate_number', 'cloudcheck_nz_vehicle_plate_number_shortcode');


    /** Shortcode that shows fields for verification by NZ birth certificate:
     *  birthcertificate
     */
    function cloudcheck_nz_birth_certificate_shortcode($atts = [], $content = null)
    {
        $birth = '<h5>New Zealand Birth Certificate</h5>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls mx-3">
                    <label>Birth Certificate Registration Number</label>
                    <input id="nz_birthcertificate" class="form-control" type="text" pattern="^[0-9]+$" title="Birth certificate number can contain only digits" placeholder="Birth Certificate Registration Number" />
                </div>
            </div>';

        return $birth;
    }
    add_shortcode('cloudcheck_nz_birth_certificate', 'cloudcheck_nz_birth_certificate_shortcode');


    /** Shortcode that shows fields for verification by NZ citizenship:
     *  certificatenumber, countryofbirth
     */
    function cloudcheck_nz_citizenship_shortcode($atts = [], $content = null)
    {
        $citizenship = '<h5>New Zealand Citizenship</h5>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls ml-3">
                    <label>Citizenship Certificate Number</label>
                    <input id="nz_citizenshipcertificate" class="form-control" type="text" pattern="^[0-9]{6,10}$" title="Certificate number can contain not more than 10 digits " placeholder="Citizenship Certificate Number" />
    			</div>
                <div class="form-group col-xs-12 floating-label-form-group controls mx-3">
                    <label>Country of Birth</label>
                    <input id="nz_citizenshipcountryofbirth" class="form-control" type="text" placeholder="Country of Birth" />
                </div>
            </div>';

        return $citizenship;
    }
    add_shortcode('cloudcheck_nz_citizenship', 'cloudcheck_nz_citizenship_shortcode');


    /** Shortcode that shows fields for verification by Australian passport:
     *  passport number, passport gender
     */
    function cloudcheck_au_passport_shortcode($atts = [], $content = null)
    {
        $passport = '<h5>Australian Passport</h5>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls ml-3">
                    <label>Passport Number</label>
                    <input id="au_passportnumber" class="form-control" type="text" pattern="[A-Za-z]{1,2}[0-9]{7}" title="Passport number can contain exactly 1 or 2 letters and 7 digits " placeholder="Passport number" />
                </div>
                <div class="form-group col-xs-12 floating-label-form-group controls mx-3">
                    <label>Passport Gender</label>
                    <select id="au_passportgender" class="form-control" placeholder="Passport gender">
    					<option value="F">Female</option>
    					<option value="M">Male</option>
    					<option value="X">X</option>
    				</select>
                </div>
            </div>';

        return $passport;
    }
    add_shortcode('cloudcheck_au_passport', 'cloudcheck_au_passport_shortcode');


    /** Shortcode that shows fields for verification by Australian citizenship:
     *  acquisition date, citizenship by descent, stock number
     */
    function cloudcheck_au_citizenship_shortcode($atts = [], $content = null)
    {
        $citizenship = '<h5>Australian Citizenship</h5>
            <div class="row control-group">
                <div class="form-check col-xs-12 floating-label-form-group controls ml-3">
                    <input id="au_citizenshipbydescent" class="form-check-input" type="checkbox"/>
                    <label>Citizenship By Descent</label>
    			</div>
                <div class="form-group col-xs-12 floating-label-form-group controls ml-3">
                    <label>Citizenship Acquisition Date</label>
                    <input id="au_citizenshipacquisitiondate" class="form-control" type="date" placeholder="Citizenship Acquisition Date" />
    			</div>
                <div class="form-group col-xs-12 floating-label-form-group controls mx-3" id="div_au_citizenshipstocknumber">
                    <label>Citizenship Stock Number</label>
                    <input id="au_citizenshipstocknumber" class="form-control" type="text" placeholder="Citizenship Stock Number" />
                </div>
            </div>';

        return $citizenship;
    }
    add_shortcode('cloudcheck_au_citizenship', 'cloudcheck_au_citizenship_shortcode');


    /** Shortcode that shows fields for verification by Australian driving license:
     *  state of issue, driving license number
     */
    function cloudcheck_au_driving_license_shortcode($atts = [], $content = null)
    {
        $driving = '<h5>Australian Driving License</h5>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls ml-3">
                    <label>Driver License Number</label>
                    <input id="au_driverlicensenumber" class="form-control" type="text" pattern="[A-Za-z0-9]*" title="License version can contain contain only letters and digits" placeholder="Driver license number" />
                </div>
                <div class="form-group col-xs-12 floating-label-form-group controls mx-3">
                    <label>Driver License State of Issue</label>
                    <select id="au_driverlicensestate" class="form-control" placeholder="Driver license state of issue" >
    					<option value="ACT">ACT</option>
    					<option value="NSW">NSW</option>
    					<option value="NT">NT</option>
    					<option value="QLD">QLD</option>
    					<option value="SA">SA</option>
    					<option value="TAS">TAS</option>
    					<option value="VIC">VIC</option>
    					<option value="WA">WA</option>
    				</select>
                </div>
            </div>';

        return $driving;
    }
    add_shortcode('cloudcheck_au_driving_license', 'cloudcheck_au_driving_license_shortcode');


    /** Shortcode that shows fields for verification by Australian Visa:
     *  Country of Issue, Passport Number
     */
    function cloudcheck_au_visa_shortcode($atts = [], $content = null)
    {
        $visa = '<h5>Australian Visa</h5>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls ml-3">
                    <label>Country of Issue</label>
                    <input id="au_visacountryofissue" class="form-control" type="text" pattern="[A-Za-z]{3}|[Dd]" title="Country code consitst of 3 letters" placeholder="Country of Issue" />
                </div>
                <div class="form-group col-xs-12 floating-label-form-group controls mx-3">
                    <label>Passport Number</label>
                    <input id="au_visapassportnumber" class="form-control" type="text" pattern="[A-Za-z0-9]*" title="Passport number can contain only letters and digits" placeholder="Passport number" />
                </div>
            </div>';

        return $visa;
    }
    add_shortcode('cloudcheck_au_visa', 'cloudcheck_au_visa_shortcode');


    /** Shortcode that shows fields for verification by Australian ImmiCard:
     *  immicard number
     */
    function cloudcheck_au_immicard_shortcode($atts = [], $content = null)
    {
        $immicard = '<h5>Australian ImmiCard</h5>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls mx-3">
                    <label>ImmiCard Number</label>
                    <input id="au_immicardnumber" class="form-control" type="text" pattern="[A-Za-z]{3}[0-9]{6}" title="ImmiCard number can contain 3 letters and 6 digits" placeholder="ImmiCard number" />
                </div>
            </div>';

        return $immicard;
    }
    add_shortcode('cloudcheck_au_immicard', 'cloudcheck_au_immicard_shortcode');

}
