<?php
$user_id = get_current_user_id();
?>


<div class="account-page-header">
    <div class="account-page-heading title-h4">Medical and Smoking History Questionnaire</div>
    <p class="account-page-description">If you are not vaping and would like to cancel your prescription you can so <a href="/my-account/subscriptions/">here</a></p>
    <p class="account-page-description">If you still require prescription please complete below:</p>
    <div class="separator"></div>
    <p class="account-page-description"><span class="span-icon"></span>Your profile was updated on <?php  echo get_user_meta($user_id, 'last_history_update', true); ?></p>
</div>


<form class="questionnaire-form renewal" action="#some" method="POST">


    <div class="form-inner">

        <!--FIRST NAME-->
        <div class="form-group qc-form-group w100 form-request-item">
            <div class="d-flex">
                <label class="bio">First name</label>
            </div>
            <input class="form-control form-input2" data-testid="input" id="first" name="first" autocomplete="given-name" type="text" value="<?php  echo get_user_meta($user_id, 'first', true); ?>" placeholder="Your First Name" >
        </div>

        <!--LAST NAME-->
        <div class="form-group qc-form-group w100 form-request-item">
            <div class="d-flex">
                <label class="bio">Last name</label>
            </div>
            <input class="form-control form-input2" data-testid="input" id="last" name="last" autocomplete="family-name" type="text" value="<?php  echo get_user_meta($user_id, 'last', true); ?>" placeholder="Your Last Name" >
        </div>

        <!--DOB-->
<!--        <div class="form-group qc-form-group w100 form-request-item">-->
<!--            <div class="d-flex">-->
<!--                <label class="bio">Date of birth</label>-->
<!--            </div>-->
<!---->
<!--            <input class="form-control form-input2" data-testid="input" id="dob" name="dob" autocomplete="" type="text" value="--><?php // echo get_user_meta($user_id, 'additional_dob', true); ?><!--" placeholder="Day of Birth" >-->
<!---->
<!--        </div>-->

        <!--DOB-->
        <div class="form-group text-group qc-form-group w49">
            <div class="d-flex">
                <label class="form-group-label bio">Date of birth</label>
            </div>
            <div class="dob-fields-wrap" >
                <input class="dob-hidden" type="hidden" value="<?php echo get_user_meta($user_id, 'dob', true); ?>">
                <select class="form-control form-input2 form-input-dob" id="dobday" required></select>
                <select class="form-control form-input2 form-input-dob" id="dobmonth" required></select>
                <select class="form-control form-input2 form-input-dob" id="dobyear" required></select>
            </div>


        </div>



        <div class="qc-form-group w100">
            <h4 class="subtitle">Smoking History</h4>
        </div>

        <div class="form-inner hidden-fields">
            <!--How long ago was your last cigarette?-->
            <div class="form-group qc-form-group w100 for-smokers form-request-item">
                <div class="d-flex"><label class="">How long ago was your last cigarette?</label></div>
                <div class="form-check-group">
                    <div class="form-check">
                        <input class="form-radio-input" type="radio" name="hvNck0WCKPsBb73XEzIF3" id="hvNck0WCKPsBb73XEzIF3_Today" tabindex="-1" value="Today" <?php  echo (get_user_meta($user_id, 'last_cigarette', true) == 'Today' ? 'checked' : ''); ?>>
                        <span class="custom-radio-input"></span>
                        <label class="form-check-label" for="hvNck0WCKPsBb73XEzIF3_Today">Today</label>
                    </div>
                </div>
                <div class="form-check-group">
                    <div class="form-check">
                        <input class="form-radio-input" type="radio" name="hvNck0WCKPsBb73XEzIF3" id="hvNck0WCKPsBb73XEzIF3_Within the past week" tabindex="-1" value="Within the past week" <?php  echo (get_user_meta($user_id, 'last_cigarette', true) == 'Within the past week' ? 'checked' : ''); ?>>
                        <span class="custom-radio-input"></span>
                        <label class="form-check-label" for="hvNck0WCKPsBb73XEzIF3_Within the past week">Within the past week</label>
                    </div>
                </div>
                <div class="form-check-group">
                    <div class="form-check">
                        <input class="form-radio-input" type="radio" name="hvNck0WCKPsBb73XEzIF3" id="hvNck0WCKPsBb73XEzIF3_Within the past month" tabindex="-1" value="Within the past month" <?php  echo (get_user_meta($user_id, 'last_cigarette', true) == 'Within the past month' ? 'checked' : ''); ?>>
                        <span class="custom-radio-input"></span>
                        <label class="form-check-label" for="hvNck0WCKPsBb73XEzIF3_Within the past month">Within the past month</label>
                    </div>
                </div>
                <div class="form-check-group">
                    <div class="form-check">
                        <input class="form-radio-input" type="radio" name="hvNck0WCKPsBb73XEzIF3" id="hvNck0WCKPsBb73XEzIF3_1-6 months ago" tabindex="-1" value="1-6 months ago" <?php  echo (get_user_meta($user_id, 'last_cigarette', true) == '1-6 months ago' ? 'checked' : ''); ?>>
                        <span class="custom-radio-input"></span>
                        <label class="form-check-label" for="hvNck0WCKPsBb73XEzIF3_1-6 months ago">1-6 months ago</label>
                    </div>
                </div>
                <div class="form-check-group">
                    <div class="form-check">
                        <input class="form-radio-input" type="radio" name="hvNck0WCKPsBb73XEzIF3" id="hvNck0WCKPsBb73XEzIF3_Over 1 year ago" tabindex="-1" value="Over 1 year ago" <?php  echo (get_user_meta($user_id, 'last_cigarette', true) == 'Over 1 year ago' ? 'checked' : ''); ?>>
                        <span class="custom-radio-input"></span>
                        <label class="form-check-label" for="hvNck0WCKPsBb73XEzIF3_Over 1 year ago">Over 1 year ago</label>
                    </div>
                </div>
            </div>


            <div class="qc-form-group w100">
                <h4 class="subtitle">Vaping History</h4>
            </div>
<!--            What vaping product/s are you currently using? (Please include brand, nicotine strength and how many mLs/pods used per day)-->
            <div class="form-group qc-form-group w100 form-request-item">
                <div class="d-flex">
                    <label class="">What vaping product/s are you currently using? (Please include brand, nicotine strength and how many mLs/pods used per day)
                    </label>
                </div>
                <input class="form-control form-input2" data-testid="input" id="Jobx7PHVwKL_yumEdi7Jl" name="Jobx7PHVwKL_yumEdi7Jl" autocomplete="family-name" type="text" value="<?php  echo get_user_meta($user_id, 'vaping_product', true); ?>" placeholder="Please Fill">
            </div>


            <div class="qc-form-group w100">
                <h4 class="subtitle">Medical History</h4>
            </div>

            <!--Have you had a stroke, heart attack, irregular heartbeat, uncontrolled hypertension or angina in the past month?-->
            <div class="form-group qc-form-group w100 form-request-item">
                <div class="d-flex">
                    <label class="">Have you had a stroke, heart attack, irregular heartbeat, uncontrolled hypertension or angina in the past month?
                    </label>
                </div>
                <div class="form-check-group">
                    <div class="form-check">
                        <input class="form-radio-input" type="radio" name="qceAKDJfEDuBQj7QD1gFF" id="qceAKDJfEDuBQj7QD1gFF_Yes" tabindex="-1" value="Yes" <?php  echo (get_user_meta($user_id, 'heart_attack', true) == 'Yes' ? 'checked' : ''); ?>>
                        <span class="custom-radio-input"></span>
                        <label class="form-check-label" for="qceAKDJfEDuBQj7QD1gFF_Yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-radio-input" type="radio" name="qceAKDJfEDuBQj7QD1gFF" id="qceAKDJfEDuBQj7QD1gFF_No" tabindex="-1" value="No" <?php  echo (get_user_meta($user_id, 'heart_attack', true) == 'No' ? 'checked' : ''); ?>>
                        <span class="custom-radio-input"></span>
                        <label class="form-check-label" for="qceAKDJfEDuBQj7QD1gFF_No">No</label>
                    </div>
                </div>
            </div>

            <!--Are you pregnant, or do you plan to become pregnant in the next 12 months?-->
            <div class="form-group qc-form-group w100 form-request-item">
                <div class="d-flex">
                    <label class="">Are you pregnant, or do you plan to become pregnant in the next 12 months?
                    </label>
                </div>
                <div class="form-check-group">
                    <div class="form-check">
                        <input class="form-radio-input" type="radio" name="3N7MEwRQQ8DyRyhUeWluZ3" id="3N7MEwRQQ8DyRyhUeWluZ3_Yes" tabindex="-1" value="Yes" <?php  echo (get_user_meta($user_id, 'are_you_pregnant', true) == 'Yes' ? 'checked' : ''); ?>>
                        <span class="custom-radio-input"></span>
                        <label class="form-check-label" for="3N7MEwRQQ8DyRyhUeWluZ3_Yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-radio-input" type="radio" name="3N7MEwRQQ8DyRyhUeWluZ3" id="3N7MEwRQQ8DyRyhUeWluZ3_No" tabindex="-1" value="No" <?php  echo (get_user_meta($user_id, 'are_you_pregnant', true) == 'No' ? 'checked' : ''); ?>>
                        <span class="custom-radio-input"></span>
                        <label class="form-check-label" for="3N7MEwRQQ8DyRyhUeWluZ3_No">No</label>
                    </div>
                </div>
            </div>





            <div class="qc-form-group w100 for-smokers">
                <h4 class="subtitle">Anything Else</h4>
            </div>
            <!--Do you have any special requirements or requests? Is there anything else you would like your doctor to know?-->
            <div class="form-group qc-form-group w100 form-request-item">
                <div class="d-flex">
                    <label class="">Do you have any special requirements or requests? Is there anything else you would like your doctor to know?
                    </label>
                </div>
                <input class="form-control form-input2" data-testid="input" id="vk1adCeUqE8VkWvf5Qqm6" name="vk1adCeUqE8VkWvf5Qqm6" autocomplete="family-name" type="text" value="<?php  echo get_user_meta($user_id, 'special_requirements', true); ?>" placeholder="Please Fill">
            </div>
            <!--Your documents will be securely emailed to you, and no one else, unless you request otherwise. If you would like us to also forward your prescription to a pharmacy, supplier or friend/carer, please enter their email address.-->
            <div class="form-group qc-form-group w100 form-request-item">
                <div class="d-flex">
                    <label class="">Your documents will be securely emailed to you, and no one else, unless you request otherwise. If you would like us to also forward your prescription to a pharmacy, supplier or friend/carer, please enter their email address.
                    </label>
                </div>
                <input class="form-control form-input2" data-testid="input" id="B90LYTslk__msuLzLkQ31" name="B90LYTslk__msuLzLkQ31" autocomplete="family-name" type="text" value="<?php  echo get_user_meta($user_id, 'emaile_documents', true); ?>" placeholder="Please Fill">
            </div>


            <div class="qc-form-group w100 for-smokers">
                <h4 class="subtitle">Safety Information and Consent</h4>
            </div>
            <!--Complete abstinence from-->
            <div class="form-group qc-form-group w100 for-smokers form-request-item">
                <div class="d-flex"><label class="">Complete abstinence from smoking and vaping is the safest option for your health. Nicotine is addictive, and the long-term risks of vaping are unknown. Currently no nicotine vaping products have been approved by the TGA, and the safety of these products has not yet been thoroughly assessed. In order to minimise risk of harm, only short-term use of e-cigarettes is recommended, and dual use (vaping plus smoking) needs to be avoided.</label></div>
                <div class="form-check-group">
                    <div class="form-check">
                        <input class="form-radio-input" type="radio" name="gbHG9mDZV7bRmXggwJyYI4" id="gbHG9mDZV7bRmXggwJyYI_I confirm that I have read and understand the above safety information" tabindex="-1" value="I confirm that I have read and understand the above safety information">
                        <span class="custom-radio-input"></span>
                        <label class="form-check-label" for="gbHG9mDZV7bRmXggwJyYI_I confirm that I have read and understand the above safety information">I confirm that I have read and understand the above safety information</label>
                    </div>
                </div>
            </div>

        </div><!--  HIDDEN FIELDS-->


        <!--BUTTON-->
        <div class="form-group qc-form-group w100  form-request-item">
            <button class="btn btn-body btn-blue questionnarie-submit" type="button">Save and submit</button>
        </div>




    </div><!-- Form inner-->
</form>

    <!--MESSAGE BLOCK-->
    <div id="success" class="success"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<?php wp_enqueue_script( 'dobpicker', get_theme_file_uri( '/assets/js/dobpicker.js' ), array(), '1', true ); ?>

<?php wp_enqueue_script( 'heydoc-renewal-js', get_theme_file_uri( '/assets/js/heydoc-renewal-script.js' ), array('jq-351'), '1', true ); ?>