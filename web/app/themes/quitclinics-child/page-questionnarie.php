<?php
/**
 * Template Name: Questionnarie
 * Template Post Type: page
 *
 *
 *
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
?>
<?php get_header(); ?>
<div id="content">
    <div class="header questionnaire-header">
        <div class="row wrapper-1240">
            <a class="menu-logo" <?php if(is_front_page()) { ?>  <?php } else { ?> href="<?php echo home_url();?>" <?php } ?> >
                <img src="<?php echo get_field('logo_image', 'option')['url']; ?>" alt="<?php echo get_field('logo_image', 'option')['title']; ?>" >
            </a>
        </div>
    </div>

    <section class="section-breadcrumbs">
        <div class="row wrapper-1240">
            <div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
                <?php
                if(function_exists('bcn_display'))
                {
                    bcn_display();
                }?>
            </div>
        </div>
    </section>
    <div class="questionnarie-section">
        <div class="wrapper-1240">
            <div id="root">
                <div class="container questionnarie-inner">

                    <form class="questionnaire-form" action="#some" method="POST">
                        <div class="form-inner">

                            <!--Step 1-->
                            <div class="form-step active form-request-item wrapper-904" data-form-step="0">
                                <div class="form-input-list">
                                    <div class="form-heading-block">
                                        <?php if (get_field('personal_information_title')) :?>
                                        <div class="form-heading"><?php echo get_field('personal_information_title') ?></div>
                                        <?php endif ?>
                                        <?php if (get_field('personal_information_description')) :?>
                                        <div class="form-description"><?php echo get_field('personal_information_description') ?></div>
                                        <?php endif ?>
                                    </div>
                                    <div class="separator"></div>
                                    <!--FIRST NAME-->
                                    <div class="form-group text-group qc-form-group w100">
                                        <div class="d-flex">
                                            <label class="form-group-label bio">First name</label>
                                        </div>
                                        <input class="form-control form-input2" data-testid="input" id="first" name="first" autocomplete="given-name" type="text" value="" placeholder="Your First Name">
                                    </div>
                                    <!--LAST NAME-->
                                    <div class="form-group text-group qc-form-group w100">
                                        <div class="d-flex">
                                            <label class="form-group-label bio">Last name</label>
                                        </div>
                                        <input class="form-control form-input2" data-testid="input" id="last" name="last" autocomplete="family-name" type="text" value="" placeholder="Your Last Name">
                                    </div>
                                    <!--EMAIL-->
                                    <div class="form-group text-group qc-form-group w100">
                                        <div class="d-flex">
                                            <label class="form-group-label bio">Email</label>
                                        </div>
                                        <input class="form-control form-input2" data-testid="input" id="email" name="email" type="email" autocomplete="email" value="" placeholder="Email">
                                    </div>
                                    <!--DOB-->
                                    <div class="form-group text-group qc-form-group w100">
                                        <div class="d-flex">
                                            <label class="form-group-label bio">Date of birth</label>
                                        </div>
                                        <div class="dob-fields-wrap" >
                                            <select class="form-control form-input2 form-input-dob" id="dobday"></select>
                                            <select class="form-control form-input2 form-input-dob" id="dobmonth"></select>
                                            <select class="form-control form-input2 form-input-dob" id="dobyear"></select>
                                        </div>


                                    </div>
                                    <!--GENDER-->
                                    <div class="form-group text-group qc-form-group w100 bordered">
                                        <div class="d-flex">
                                            <label class="form-group-label bio">Gender</label>
                                        </div>
                                        <div class="form-check-inline form-check-group">
                                            <select class="form-control form-input2"  name="gender">
                                                <option id="gender_male" selected value="male">Male</option>
                                                <option id="gender_female" value="female">Female</option>
                                                <option id="gender_other specific" value="other specific">Other</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="separator"></div>

                                    <!--ADRESS-->
                                    <div class="form-group text-group qc-form-group w100">
                                        <div class="d-flex"><label class="form-group-label bio">Street Address</label></div>
                                        <input class="form-control form-input2" data-testid="input" id="address" name="address" aria-label="street address" placeholder="Street Address" autocomplete="street-address" type="text" value="">
                                    </div>
                                    <!--CITY-->
                                    <div class="form-group text-group qc-form-group w49">
                                        <div class="d-flex"><label class="form-group-label bio">City/Town</label></div>
                                        <input class="form-control form-input2" data-testid="input" name="city" id="city" aria-label="city or town" placeholder="City or Town" autocomplete="address-level2" type="text" value="">
                                    </div>

                                    <!--POSTCODE-->
                                    <div class="form-group text-group qc-form-group w49">
                                        <div class="d-flex"><label class="form-group-label bio">Postcode</label></div>
                                        <input class="form-control input__medium form-input2" data-testid="input" id="postcode" name="postcode" aria-label="postal code" placeholder="Postcode" autocomplete="postal-code" type="text" value="">
                                    </div>
                                    <!--COUNTRY-->
                                    <div class="form-group text-group qc-form-group w100">
                                        <div class="d-flex"><label class="form-group-label bio">Country</label></div>
                                        <div class="dropdown form-style form-input2">
                                            <input class="dropdown-toggle" type="text" id="country">
                                            <input type="hidden" id="country_code" />
                                        </div>
                                    </div>
                                    <!--PHONE NUMBER-->
                                    <div class="form-group text-group qc-form-group w100">
                                        <div class="d-flex">
                                            <label class="form-group-label bio">Mobile number</label>
                                        </div>
                                        <input class="form-control form-input2" data-testid="input" name="phoneNumber" id="phoneNumber" type="tel" autocomplete="tel" value="" placeholder="Phone number">
                                    </div>
                                </div>

                                <div class="form-input-list transparent description">
                                    <div class="tiles__list expect-description">

                                        <div class="tiles__item expect-description__item">
                                            <div class="step-description-icon">
                                                <img src="/app/themes/quitclinics-child/assets/images/icons/icons8-prescription.svg" alt="prescription">
                                            </div>
                                            <div class="treatment-selection__content">
                                                <div class="treatment-selection__desc text-center">Online Prescriptions for Vaping</div>
                                            </div>
                                        </div>
                                        <div class="tiles__item expect-description__item">
                                            <div class="step-description-icon">
                                                <img src="/app/themes/quitclinics-child/assets/images/icons/icons8-last-24-hours.svg" alt="icons8-last-24-hours">
                                            </div>
                                            <div class="treatment-selection__content">
                                                <div class="treatment-selection__desc text-center">Receive Prescription in 24 Hours</div>
                                            </div>
                                        </div>
                                        <div class="tiles__item expect-description__item">
                                            <div class="step-description-icon">
                                                <img src="/app/themes/quitclinics-child/assets/images/icons/icons8-chat.svg" alt="icons8-chat">
                                            </div>
                                            <div class="treatment-selection__content">
                                                <div class="treatment-selection__desc text-center">Free Guidance On Your Smoke Free Journey</div>
                                            </div>
                                        </div>

                                    </div>
                                </div>



                            </div>

                            <!--Step Smoking History-->
                            <div class="form-step form-request-item hidden wrapper-904" data-form-step="1">
                                <div class="form-input-list">
                                    <div class="form-heading-block">
                                        <?php if (get_field('smoking_history_title')) :?>
                                            <div class="form-heading"><?php echo get_field('smoking_history_title') ?></div>
                                        <?php endif ?>
                                        <?php if (get_field('smoking_history_description')) :?>
                                            <div class="form-description"><?php echo get_field('smoking_history_description') ?></div>
                                        <?php endif ?>
                                    </div>
                                    <div class="separator"></div>

                                    <!--Which best describes you?-->
                                    <div class="form-group radio-group bordered qc-form-group w100 form-request-item">
                                        <div class="d-flex"><label class="form-group-label ">Which best describes you?</label></div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="3hC7sLm3JSsfqiM0ulcX8" id="3hC7sLm3JSsfqiM0ulcX8_I&#39;ve never smoked" tabindex="-1" value="I&#39;ve never smoked">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="3hC7sLm3JSsfqiM0ulcX8_I&#39;ve never smoked">I've never smoked</label>  </div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="3hC7sLm3JSsfqiM0ulcX8" id="3hC7sLm3JSsfqiM0ulcX8_Current or ex-smoker" tabindex="-1" value="Current or ex-smoker">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="3hC7sLm3JSsfqiM0ulcX8_Current or ex-smoker">Current or ex-smoker</label></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!--Step-->
                            <div class="form-step hidden never-smoke wrapper-904" data-form-step="">
                                <div class="form-input-list">
                                    <section class="centered-text text-center">
                                        <div class="row wrapper-1240">
                                            <div class="content__18px">
                                                <?php if (get_field('newer_smoked_title')) :?>
                                                <p class="title-h4 subtitle"><?php echo get_field('newer_smoked_title') ?></p>
                                                <?php endif ?>
                                            </div>
                                            <?php if (get_field('newer_smoked_description')) :?>
                                            <p><?php echo get_field('newer_smoked_description') ?>&nbsp;</p>
                                            <?php endif ?>
                                        </div>

                                    </section>
                                </div>

                            </div>

                            <!--Step 2-->
                            <div class="form-step smokers hidden wrapper-904" data-form-step="">
                                <div class="form-input-list">
                                    <div class="form-heading-block">
                                        <?php if (get_field('smoking_history_title')) :?>
                                            <div class="form-heading"><?php echo get_field('smoking_history_title') ?></div>
                                        <?php endif ?>
                                        <?php if (get_field('smoking_history_description')) :?>
                                            <div class="form-description"><?php echo get_field('smoking_history_description') ?></div>
                                        <?php endif ?>
                                    </div>
                                    <div class="separator"></div>

                                    <!--When you were smoking at your heaviest, how many cigarettes did you smoke per day?-->
                                    <div class="form-group radio-group qc-form-group w100 for-smokers">
                                        <div class="d-flex"><label class="form-group-label">When you were smoking at your heaviest, how many cigarettes did you smoke per day?</label></div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="_43BE13FsOc866RqRYOQ4" id="_43BE13FsOc866RqRYOQ4_Fewer than 5" tabindex="-1" value="Fewer than 5">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="_43BE13FsOc866RqRYOQ4_Fewer than 5">Fewer than 5</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="_43BE13FsOc866RqRYOQ4" id="_43BE13FsOc866RqRYOQ4_5-10" tabindex="-1" value="5-10">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="_43BE13FsOc866RqRYOQ4_5-10">5-10</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="_43BE13FsOc866RqRYOQ4" id="_43BE13FsOc866RqRYOQ4_11-20" tabindex="-1" value="11-20">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="_43BE13FsOc866RqRYOQ4_11-20">11-20</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="_43BE13FsOc866RqRYOQ4" id="_43BE13FsOc866RqRYOQ4_20-40" tabindex="-1" value="20-40">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="_43BE13FsOc866RqRYOQ4_20-40">20-40</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="_43BE13FsOc866RqRYOQ4" id="_43BE13FsOc866RqRYOQ4_40+" tabindex="-1" value="40+">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="_43BE13FsOc866RqRYOQ4_40+">40+</label></div>

                                        </div>
                                    </div>

                                    <div class="separator"></div>
                                    <!--How many years have you smoked in total?-->
                                    <div class="form-group radio-group qc-form-group w100 for-smokers">
                                        <div class="d-flex"><label class="form-group-label">How many years have you smoked in total?</label></div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="rRPAX~NegkGzMk1axpM4p" id="rRPAX~NegkGzMk1axpM4p_5 or fewer" tabindex="-1" value="5 or fewer">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="rRPAX~NegkGzMk1axpM4p_5 or fewer">5 or fewer</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="rRPAX~NegkGzMk1axpM4p" id="rRPAX~NegkGzMk1axpM4p_5-10" tabindex="-1" value="5-10">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="rRPAX~NegkGzMk1axpM4p_5-10">5-10</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="rRPAX~NegkGzMk1axpM4p" id="rRPAX~NegkGzMk1axpM4p_10-20" tabindex="-1" value="20-30">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="rRPAX~NegkGzMk1axpM4p_10-20">10-20</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="rRPAX~NegkGzMk1axpM4p" id="rRPAX~NegkGzMk1axpM4p_20-30" tabindex="-1" value="20-30">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="rRPAX~NegkGzMk1axpM4p_20-30">20-30</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="rRPAX~NegkGzMk1axpM4p" id="rRPAX~NegkGzMk1axpM4p_30+" tabindex="-1" value="30+">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="rRPAX~NegkGzMk1axpM4p_30+">30+</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="separator"></div>

                                    <!--What method(s) have you previously tried to assist you in quitting? (please tick all that apply)-->
                                    <div class="form-group radio-group qc-form-group w100 for-smokers">
                                        <div class="d-flex"><label class="form-group-label">What method(s) have you previously tried to assist you in quitting? (please tick all that apply)</label></div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-check-input" name="BCy65jqX6Q1FJN1rePAZ4" type="checkbox" data-testid="checkbox" id="BCy65jqX6Q1FJN1rePAZ4_Cold-Turkey" tabindex="-1" value="Cold-Turkey">
                                                <span class="custom-check-input"></span>
                                                <div class="d-flex"><label class="form-check-label" for="BCy65jqX6Q1FJN1rePAZ4_Cold-Turkey">Cold-Turkey</label></div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="BCy65jqX6Q1FJN1rePAZ4" type="checkbox" data-testid="checkbox" id="BCy65jqX6Q1FJN1rePAZ4_Nicotine Replacement Gum" tabindex="-1" value="Nicotine Replacement Gum">
                                                <span class="custom-check-input"></span>
                                                <div class="d-flex"><label class="form-check-label" for="BCy65jqX6Q1FJN1rePAZ4_Nicotine Replacement Gum">Nicotine Replacement Gum</label></div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="BCy65jqX6Q1FJN1rePAZ4" type="checkbox" data-testid="checkbox" id="BCy65jqX6Q1FJN1rePAZ4_Nicotine Replacement Patches" tabindex="-1" value="Nicotine Replacement Patches">
                                                <span class="custom-check-input"></span>
                                                <div class="d-flex"><label class="form-check-label" for="BCy65jqX6Q1FJN1rePAZ4_Nicotine Replacement Patches">Nicotine Replacement Patches</label></div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="BCy65jqX6Q1FJN1rePAZ4" type="checkbox" data-testid="checkbox" id="BCy65jqX6Q1FJN1rePAZ4_Nicotine Replacement Lozenges/Sprays" tabindex="-1" value="Nicotine Replacement Lozenges/Sprays">
                                                <span class="custom-check-input"></span>
                                                <div class="d-flex"><label class="form-check-label" for="BCy65jqX6Q1FJN1rePAZ4_Nicotine Replacement Lozenges/Sprays">Nicotine Replacement Lozenges/Sprays</label></div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="BCy65jqX6Q1FJN1rePAZ4" type="checkbox" data-testid="checkbox" id="BCy65jqX6Q1FJN1rePAZ4_Counselling/Quitline" tabindex="-1" value="Counselling/Quitline">
                                                <span class="custom-check-input"></span>
                                                <div class="d-flex"><label class="form-check-label" for="BCy65jqX6Q1FJN1rePAZ4_Counselling/Quitline">Counselling/Quitline</label></div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="BCy65jqX6Q1FJN1rePAZ4" type="checkbox" data-testid="checkbox" id="BCy65jqX6Q1FJN1rePAZ4_Hypnotherapy" tabindex="-1" value="Hypnotherapy">
                                                <span class="custom-check-input"></span>
                                                <div class="d-flex"><label class="form-check-label" for="BCy65jqX6Q1FJN1rePAZ4_Hypnotherapy">Hypnotherapy</label></div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="BCy65jqX6Q1FJN1rePAZ4" type="checkbox" data-testid="checkbox" id="BCy65jqX6Q1FJN1rePAZ4_Varenicline (Champix)" tabindex="-1" value="Varenicline (Champix)">
                                                <span class="custom-check-input"></span>
                                                <div class="d-flex"><label class="form-check-label" for="BCy65jqX6Q1FJN1rePAZ4_Varenicline (Champix)">Varenicline (Champix)</label></div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="BCy65jqX6Q1FJN1rePAZ4" type="checkbox" data-testid="checkbox" id="Cy65jqX6Q1FJN1rePAZ4_Buproprion (Zyban)" tabindex="-1" value="Buproprion (Zyban)">
                                                <span class="custom-check-input"></span>
                                                <div class="d-flex"><label class="form-check-label" for="Cy65jqX6Q1FJN1rePAZ4_Buproprion (Zyban)">Buproprion (Zyban)</label></div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="separator"></div>

                                    <!--How long ago was your last cigarette?-->
                                    <div class="form-group radio-group qc-form-group w100 for-smokers">
                                        <div class="d-flex"><label class="form-group-label">How long ago was your last cigarette?</label></div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="nkgg3ZZPoWhDuMqRFuab5" id="nkgg3ZZPoWhDuMqRFuab5_Today" tabindex="-1" value="Today">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="nkgg3ZZPoWhDuMqRFuab5_Today">Today</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="nkgg3ZZPoWhDuMqRFuab5" id="nkgg3ZZPoWhDuMqRFuab5_Within the past week" tabindex="-1" value="Within the past week">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="nkgg3ZZPoWhDuMqRFuab5_Within the past week">Within the past week</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="nkgg3ZZPoWhDuMqRFuab5" id="nkgg3ZZPoWhDuMqRFuab5_Within the past month" tabindex="-1" value="Within the past month">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="nkgg3ZZPoWhDuMqRFuab5_Within the past month">Within the past month</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="nkgg3ZZPoWhDuMqRFuab5" id="nkgg3ZZPoWhDuMqRFuab5_1-6 months ago" tabindex="-1" value="1-6 months ago">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="nkgg3ZZPoWhDuMqRFuab5_1-6 months ago">1-6 months ago</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="nkgg3ZZPoWhDuMqRFuab5" id="nkgg3ZZPoWhDuMqRFuab5_6-12 months ago" tabindex="-1" value="6-12 months ago">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="nkgg3ZZPoWhDuMqRFuab5_6-12 months ago">6-12 months ago</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="nkgg3ZZPoWhDuMqRFuab5" id="nkgg3ZZPoWhDuMqRFuab5_Over one year ago" tabindex="-1" value="Over one year ago">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="nkgg3ZZPoWhDuMqRFuab5_Over one year ago">Over one year ago</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!--Step 3-->
                            <div class="form-step radio-group smokers hidden wrapper-904" data-form-step="">
                                <div class="form-input-list">
                                    <!--Have you ever vaped?-->
                                    <div class="form-group bordered qc-form-group w100 form-request-item">
                                        <div class="d-flex">
                                            <div class="form-heading">Have you ever vaped?</div>
                                        </div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="DWwVhzdpzYV_S6W_Pzf5V" id="DWwVhzdpzYV_S6W_Pzf5V_Yes" tabindex="-1" value="Yes">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="DWwVhzdpzYV_S6W_Pzf5V_Yes">Yes</label></div>


                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="DWwVhzdpzYV_S6W_Pzf5V" id="DWwVhzdpzYV_S6W_Pzf5V_No" tabindex="-1" value="No">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="DWwVhzdpzYV_S6W_Pzf5V_No">No</label></div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <!--Step 4-->
<!--                            <div class="form-step smokers hidden wrapper-904" data-form-step="">-->
                            <div class="form-step vaping-history hidden wrapper-904" data-form-step="">
                                <div class="form-input-list">
                                    <div class="form-heading-block">
                                        <?php if (get_field('vaping_history_title')) :?>
                                            <div class="form-heading"><?php echo get_field('vaping_history_title') ?></div>
                                        <?php endif ?>
                                        <?php if (get_field('vaping_history_description')) :?>
                                            <div class="form-description"><?php echo get_field('vaping_history_description') ?></div>
                                        <?php endif ?>
                                    </div>
                                    <div class="separator"></div>

                                    <!--Which vaping method has worked best for you?-->
                                    <div class="form-group radio-group qc-form-group w100 for-smokers">
                                        <div class="d-flex"><label class="form-group-label">Which vaping method has worked best for you?</label></div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="~VAv~puUguY76Lr9hHok5" id="~VAv~puUguY76Lr9hHok5_Pods" tabindex="-1" value="Pods">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="~VAv~puUguY76Lr9hHok5_Pods">Pods</label></div>

                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="~VAv~puUguY76Lr9hHok5" id="~VAv~puUguY76Lr9hHok5_E-liquid" tabindex="-1" value="E-liquid">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="~VAv~puUguY76Lr9hHok5_E-liquid">E-liquid</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="~VAv~puUguY76Lr9hHok5" id="~VAv~puUguY76Lr9hHok5_Disposable devices" tabindex="-1" value="Disposable devices">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="~VAv~puUguY76Lr9hHok5_Disposable devices">Disposable devices</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="~VAv~puUguY76Lr9hHok5" id="~VAv~puUguY76Lr9hHok5_Other" tabindex="-1" value="Other">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="~VAv~puUguY76Lr9hHok5_Other">Other</label></div>

                                        </div>
                                    </div>

                                    <div class="separator"></div>

                                    <!--What is the minimum strength that has been effective to avoid smoking?-->
                                    <div class="form-group text-group qc-form-group w100 nicotine-vaping">
                                        <div class="d-flex">
                                            <label class="form-group-label">What is the minimum strength that has been effective to avoid smoking?</label>
                                        </div>
                                        <input class="form-control form-input2" name="laot2_3JF6ZVIanoQCxaM" data-testid="input" id="laot2_3JF6ZVIanoQCxaM" type="text" value="" placeholder="Please fill">
                                    </div>

                                    <div class="separator"></div>

                                    <!--How many mL’s of liquid do you estimate that you use per day?-->
                                    <div class="form-group text-group qc-form-group w100 nicotine-vaping">
                                        <div class="d-flex">
                                            <label class="form-group-label">How many mL’s of liquid do you estimate that you use per day?</label>
                                        </div>
                                        <input class="form-control form-input2" name="l7pGmBv8777ub~PaQta0P" data-testid="input" id="l7pGmBv8777ub~PaQta0P" type="text" value="" placeholder="Please fill">
                                    </div>

                                    <div class="separator"></div>

                                    <!--Is there anything else you would like to add about your vaping?-->
                                    <div class="form-group text-group qc-form-group w100 nicotine-vaping">
                                        <div class="d-flex">
                                            <label class="form-group-label">Is there anything else you would like to add about your vaping?</label>
                                        </div>
                                        <textarea class="form-control form-input2" name="~NS42HF~cIVNIW8bohuFE" data-testid="input" id="~NS42HF~cIVNIW8bohuFE" type="text" value="" placeholder="Please fill"></textarea>
                                    </div>

                                </div>
                            </div>

                            <!--Step 5-->
                            <div class="form-step smokers hidden wrapper-904" data-form-step="">
                                <div class="form-input-list">
                                    <div class="form-heading-block">
                                        <?php if (get_field('medical_history_title')) :?>
                                            <div class="form-heading"><?php echo get_field('medical_history_title') ?></div>
                                        <?php endif ?>
                                        <?php if (get_field('medical_history_description')) :?>
                                            <div class="form-description"><?php echo get_field('medical_history_description') ?></div>
                                        <?php endif ?>
                                    </div>
                                    <div class="separator"></div>

                                    <!--Please list below any significant medical illnesses, such as diabetes, cancer, asthma, COPD/emphysema or psychiatric disorders.-->
                                    <div class="form-group text-group qc-form-group w100 nicotine-vaping">
                                        <div class="d-flex">
                                            <label class="form-group-label">Please list below any significant medical illnesses, such as diabetes, cancer, asthma, COPD/emphysema or psychiatric disorders.</label>
                                        </div>
                                        <textarea class="form-control form-input2" name="Qg7XDz8NOIM1oShkyViot" data-testid="input" id="~Qg7XDz8NOIM1oShkyViot" type="text" value="" placeholder="Please fill"></textarea>
                                    </div>

                                    <div class="separator"></div>

                                    <!--Have you had a stroke, heart attack, irregular heartbeat, uncontrolled hypertension or angina in the past month?-->
                                    <div class="form-group radio-group qc-form-group w100 for-smokers">
                                        <div class="d-flex"><label class="form-group-label">Have you had a stroke, heart attack, irregular heartbeat, uncontrolled hypertension or angina in the past month?</label></div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="65oh_cXb82k9FFSQTpnCq" id="65oh_cXb82k9FFSQTpnCq_Yes" tabindex="-1" value="Yes">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="65oh_cXb82k9FFSQTpnCq_Yes">Yes</label></div>

                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="65oh_cXb82k9FFSQTpnCq" id="65oh_cXb82k9FFSQTpnCq_No" tabindex="-1" value="No">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="65oh_cXb82k9FFSQTpnCq_No">No</label></div>
                                        </div>
                                    </div>

                                    <div class="separator"></div>

                                    <!--Are you breastfeeding, pregnant, or planning to become pregnant within the next 12 months?-->
                                    <div class="form-group radio-group qc-form-group w100 for-smokers">
                                        <div class="d-flex"><label class="form-group-label">Are you breastfeeding, pregnant, or planning to become pregnant within the next 12 months?</label></div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="6zudIdCy1XEoCX8Sw0NgK" id="6zudIdCy1XEoCX8Sw0NgK_Yes" tabindex="-1" value="Yes">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="6zudIdCy1XEoCX8Sw0NgK_Yes">Yes</label></div>

                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="6zudIdCy1XEoCX8Sw0NgK" id="6zudIdCy1XEoCX8Sw0NgK_No" tabindex="-1" value="No">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="6zudIdCy1XEoCX8Sw0NgK_No">No</label></div>
                                        </div>
                                    </div>

                                    <div class="separator"></div>

                                    <!--Your documents will be securely emailed to you, and no one else, unless you request otherwise. If you would like us to also forward your prescription to a pharmacy, supplier or friend/carer, please enter their email address.-->
                                    <div class="form-group text-group qc-form-group w100 nicotine-vaping">
                                        <div class="d-flex">
                                            <label class="form-group-label">Your documents will be securely emailed to you, and no one else, unless you request otherwise. If you would like us to also forward your prescription to a pharmacy, supplier or friend/carer, please enter their email address.</label>


                                        </div>
                                        <label class="form-group-label bio">Email</label>
                                        <input class="form-control form-input2" name="edtL2L2EgXHeafjrROWeR" data-testid="input" id="edtL2L2EgXHeafjrROWeR" type="text" value="" placeholder="Please fill">
                                    </div>

                                    <div class="separator"></div>

                                    <!--Is there anything else you would like to mention before proceeding?-->
                                    <div class="form-group text-group qc-form-group w100 nicotine-vaping">
                                        <div class="d-flex">
                                            <label class="form-group-label">Is there anything else you would like to mention before proceeding?</label>
                                        </div>
                                        <input class="form-control form-input2" name="JerSYpGMeTg~Z75luZ72Q" data-testid="input" id="JerSYpGMeTg~Z75luZ72Q" type="text" value="" placeholder="Please fill">
                                    </div>

                                    <div class="separator"></div>

                                    <!--Complete abstinence from-->
                                    <div class="form-group radio-group qc-form-group w100 for-smokers">
                                        <div class="d-flex"><label class="form-group-label">Complete abstinence from smoking and vaping is the safest option for your health. Nicotine is addictive, and the long-term risks of vaping are unknown. Currently no nicotine vaping products have been approved by the TGA, and the safety of these products has not yet been thoroughly assessed. Quit Clinics, or its doctors, cannot guarantee the safety of any vaping product. In order to minimise risk of harms, only short-term use of e-cigarettes is recommended, and dual use (vaping plus smoking) needs to be avoided.</label></div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="t9SgLNeqhCd2TkecatA8s" id="t9SgLNeqhCd2TkecatA8s_I confirm that I have read and understand the above safety information" tabindex="-1" value="I confirm that I have read and understand the above safety information">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="t9SgLNeqhCd2TkecatA8s_I confirm that I have read and understand the above safety information">I confirm that I have read and understand the above safety information</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <!--Treatment selection-->
                            <div class="form-step hidden form-request-item">

                                <?php
                                $products = get_field('products');
                                ?>

                                <div class="qc-form-group w100 text-center">
                                    <?php if (get_field('treatment_selection_title')) :?>
                                        <h4 class="subtitle"><?php echo get_field('treatment_selection_title'); ?></h4>
                                    <?php endif ?>
                                </div>
                                <div class="tiles__list treatment-selection">
                                    <?php if ($products): ?>
                                        <?php foreach ($products as $product) : ?>
                                            <div class="tiles__item treatment-selection__item">
                                                <div class="treatment-selection__img">
                                                    <?php if (get_field('main_treatment_image', $product->ID)) : ?>
                                                        <img src="<?php echo get_field('main_treatment_image', $product->ID)['url']; ?>" alt="<?php echo get_field('main_treatment_image', $product->ID)['title']; ?>" title="<?php echo get_field('main_treatment_image', $product->ID)['title']; ?>">
                                                    <?php endif ?>
                                                </div>
                                                <div class="treatment-selection__content">
                                                    <?php if (get_field('product_name', $product->ID)) : ?>
                                                        <div class="treatment-selection__title title-h6" data-height="threatmentTitle"><?php echo get_field('product_name', $product->ID); ?></div>
                                                    <?php endif ?>
                                                    <?php if (get_field('treatment_short_description', $product->ID)) : ?>
                                                        <?php $treatment_short_description = get_custom_excerpt(get_field('treatment_short_description', $product->ID), 87, false); ?>
                                                        <div class="treatment-selection__desc" data-height="threatmentDesc"><?php echo $treatment_short_description; ?></div>
                                                    <?php endif ?>
                                                </div>

                                                <div class="treatment-selection__btn-group">
                                                    <button class="btn-body btn-blue questionnarie-submit" type="button" data-product-name="<?php echo $product->post_title; ?>" data-product-id="<?php echo $product->ID; ?>">Get started</button>

                                                    <div class="popup_item_wrapper" data-popup="">
                                                        <div href="" class="popup_button treatment-selection_more_info">
                                                            More information
                                                        </div>

                                                        <div class="popup-main-wrapper" id="popup-main-wrapper">
                                                            <div class="item_popup_wrapper">
                                                                <div class="popup_overlay"></div>
                                                                <div class="popup_content_wrapper threatment">
                                                                    <div class="item_popup_content_inner">
                                                                        <div id="popup_close_button"></div>

                                                                        <div class="prescription_image">
                                                                            <?php if (get_field('subscription_modal_image', $product->ID)) : ?>
                                                                                <img src="<?php echo get_field('subscription_modal_image', $product->ID)['url']; ?>" alt="<?php echo get_field('subscription_modal_image', $product->ID)['title']; ?>" title="<?php echo get_field('subscription_modal_image', $product->ID)['title']; ?>">
                                                                            <?php endif ?>
                                                                        </div>

                                                                        <div class="item_popup_body">
                                                                            <div class="item_popup_header">

                                                                                <div class="item_popup__subtitle"><?php echo get_field('subscription_modal_subtitle', $product->ID); ?></div>
                                                                                <div class="item_popup__title"><?php echo get_field('subscription_modal_title', $product->ID); ?></div>
                                                                                <div class="item_popup__desc"><?php echo get_field('subscription_modal_description', $product->ID); ?></div>
                                                                            </div>

                                                                            <div class="item_popup__notes">
                                                                                <?php if (get_field('subscription_notes', $product->ID)) : ?>
                                                                                    <?php foreach (get_field('subscription_notes', $product->ID) as $subscription_notes) : ?>
                                                                                        <div class="item_popup__notes_item">
                                                                                            <div class="item_popup__notes_question"><?php echo $subscription_notes['question']; ?></div>
                                                                                            <div class="item_popup__notes_answer"><?php echo $subscription_notes['answer']; ?></div>
                                                                                        </div>
                                                                                    <?php endforeach; ?>
                                                                                <?php endif ?>
                                                                            </div>
                                                                            <div class="item_popup__accordion-list">
                                                                                <?php if (get_field('how_to_use', $product->ID)) : ?>
                                                                                    <?php foreach (get_field('how_to_use', $product->ID) as $how_to_use) : ?>
                                                                                        <div class="accordion_item">
                                                                                            <div class="accordion__btn">How to use this?</div>
                                                                                            <div class="accordion__panel">
                                                                                                <?php echo $how_to_use['text']; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php endforeach; ?>
                                                                                <?php endif ?>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                        <?php wp_reset_postdata(); ?>
                                    <?php endif ?>
                                </div>

                                <div class="qc-form-group w100 text-center">
                                    <?php if (get_field('what_to_expect_title')) :?>
                                        <h4 class="subtitle"><?php echo get_field('what_to_expect_title'); ?></h4>
                                    <?php endif ?>
                                </div>
                                <div class="tiles__list expect-description what-to-expect-slider">
                                    <?php if ($products): ?>
                                        <?php foreach ($products as $product) : ?>
                                            <div class="tiles__item expect-description__item">
                                                <div class="expect-description__img">
                                                    <?php if (get_field('subscription_small_image', $product->ID)) : ?>
                                                        <img src="<?php echo get_field('subscription_small_image', $product->ID)['url']; ?>" alt="<?php echo get_field('subscription_small_image', $product->ID)['title']; ?>" title="<?php echo get_field('subscription_small_image', $product->ID)['title']; ?>">
                                                    <?php endif ?>
                                                </div>
                                                <div class="treatment-selection__content">
                                                    <div class="treatment-selection__title title-h6 text-center"><?php echo get_field('subscription_duration', $product->ID) ?></div>
                                                    <div class="treatment-selection__desc text-center"><?php echo get_field('subscription_short_description', $product->ID) ?></div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                        <?php wp_reset_postdata(); ?>
                                    <?php endif ?>

                                </div>
                            </div>





                        </div><!-- Form inner-->
                    </form>
        </div>
        <div class="quesionnaire-nav">
            <div class="wrapper-1440 quesionnaire-nav__inner">
                <div class="btn-block">
                    <!--                                <span class="quesionnaire-nav-prev-num"></span>-->
                    <a class="quesionnaire-nav-prev btn-body btn-white bordered disabled" href="#">Back</a>
                    <!--                                <span class="quesionnaire-nav-cur-num"></span>-->
                    <a class="quesionnaire-nav-next btn-body btn-blue" href="#">Next</a>
                    <!--                                <span class="quesionnaire-nav-next-num"></span>-->
                </div>
            </div>
        </div>
        <!--MESSAGE BLOCK-->
        <div id="success" class="success"></div>

        <!--                    <div class="questionnaire-quiz">-->
        <!--                        <div class="questionnaire-step active">STEP1</div>-->
        <!--                        <div class="questionnaire-step">STEP2</div>-->
        <!--                        <div class="questionnaire-step">STEP3 SMOKERS</div>-->
        <!--                        <div class="questionnaire-step">STEP4 SMOKERS</div>-->
        <!--                        <div class="questionnaire-step">STEP5 SMOKERS</div>-->
        <!--                        <div class="questionnaire-step">STEP6 Vapers</div>-->
        <!--                        <div class="questionnaire-step">STEP7 Vapers</div>-->
        <!--                        <div class="questionnaire-step">STEP8 SMOKERS</div>-->
        <!--                        <div class="questionnaire-step">STEP9 SMOKERS</div>-->
        <!--                        <div class="questionnaire-step">STEP11 HOES</div>-->
        <!--                        <div class="questionnaire-step">STEP10 HOES</div>-->
        <!--                        <div class="questionnaire-step">STEP10 SMOKERS</div>-->
        <!--                    </div>-->
        <!--                    <div class="questionnaire-quiz-nav">-->
        <!--                        <span class="questionnaire-nav-prev">Сюда</span>-->
        <!--                        <span class="questionnaire-nav-next">Туда</span>-->
        <!--                    </div>-->
        </div>

        </div>
        </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <?php wp_enqueue_script( 'heydoc-js', get_theme_file_uri( '/assets/js/heydoc-script.js' ), array('jq-351'), '1', true ); ?>

    <?php get_template_part('template-parts/page/layout', 'page-content'); ?>
</main>
<?php //get_sidebar(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>

</script>
<?php get_footer(); ?>

