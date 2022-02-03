<?php
/**
 * Template Name: Questionnarie OLD
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
    <main id="content">
        <header class="header header-block">
            <div class="row wrapper-1240">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </div>
        </header>
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
        <section class="quastionnarie-section">
            <div class="wrapper-904">
                <div id="root">
                    <div class="container">

                        <form class="questionnaire-form" action="#some" method="POST">
                            <div class="form-inner">

                                <!--FIRST NAME-->
                                <div class="form-group qc-form-group w100 form-request-item">
                                    <div class="d-flex">
                                        <label class="bio">First name</label>
                                    </div>
                                    <input class="form-control form-input2" data-testid="input" id="first" name="first" autocomplete="given-name" type="text" value="" placeholder="Your First Name">
                                </div>

                                <!--LAST NAME-->
                                <div class="form-group qc-form-group w100 form-request-item">
                                    <div class="d-flex">
                                        <label class="bio">Last name</label>
                                    </div>
                                    <input class="form-control form-input2" data-testid="input" id="last" name="last" autocomplete="family-name" type="text" value="" placeholder="Your Last Name">
                                </div>

                                <!--DOB-->
                                <div class="form-group qc-form-group w100 form-request-item">
                                    <div class="d-flex">
                                        <label class="bio">Date of birth</label>
                                    </div>

                                    <select class="form-control form-input2 form-input-dob" id="dobday"></select>
                                    <select class="form-control form-input2 form-input-dob" id="dobmonth"></select>
                                    <select class="form-control form-input2 form-input-dob" id="dobyear"></select>

                                </div>

                                <!--EMAIL-->
                                <div class="form-group qc-form-group w100 form-request-item">
                                    <div class="d-flex">
                                        <label class="bio">Email</label>
                                    </div>
                                    <input class="form-control form-input2" data-testid="input" id="email" name="email" type="email" autocomplete="email" value="" placeholder="Email">
                                </div>

                                <!--ADRESS-->
                                <div class="form-group qc-form-group w100 form-request-item">
                                    <div class="d-flex"><label class="bio">Address</label></div>
                                    <input class="form-control form-input2" data-testid="input" id="address" name="address" aria-label="street address" placeholder="Street Address" autocomplete="street-address" type="text" value="">
                                </div>

                                <!--CITY-->
                                <div class="form-group qc-form-group w49 form-request-item">
                                    <input class="form-control form-input2" data-testid="input" name="city" id="city" aria-label="city or town" placeholder="City or Town" autocomplete="address-level2" type="text" value="">
                                </div>

                                <!--POSTCODE-->
                                <div class="form-group qc-form-group w49 form-request-item">
                                    <input class="form-control input__medium form-input2" data-testid="input" id="postcode" name="postcode" aria-label="postal code" placeholder="Postcode" autocomplete="postal-code" type="text" value="">
                                </div>

                                <!--COUNTRY-->
                                <div class="form-group qc-form-group w100 form-request-item">
                                    <div class="dropdown form-style form-input2">
                                        <input class="dropdown-toggle" type="text" id="country">
                                        <input type="hidden" id="country_code" />
                                    </div>
                                </div>

                                <!--PHONE NUMBER-->
                                <div class="form-group qc-form-group w100 form-request-item">
                                    <div class="d-flex">
                                        <label class="bio">Mobile number</label>
                                    </div>
                                    <input class="form-control form-input2" data-testid="input" name="phoneNumber" id="phoneNumber" type="tel" autocomplete="tel" value="" placeholder="Phone number">
                                </div>

                                <!--GENDER-->
                                <div class="form-group qc-form-group w100 form-request-item">
                                    <div class="d-flex">
                                        <label class="bio">Gender</label>
                                    </div>
                                    <div class="form-check-inline form-check-group">
                                        <div class="form-check">
                                            <input class="form-radio-input" type="radio" name="gender" id="gender_male" tabindex="-1" value="male">
                                            <span class="custom-radio-input"></span>
                                            <label class="form-check-label" for="gender_male">Male</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-radio-input" type="radio" name="gender" id="gender_female" tabindex="-1" value="female">
                                            <span class="custom-radio-input"></span>
                                            <label class="form-check-label" for="gender_female">Female</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-radio-input" type="radio" name="gender" id="gender_other specific" tabindex="-1" value="other specific">
                                            <span class="custom-radio-input"></span>
                                            <label class="form-check-label" for="gender_other specific">Other</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="qc-form-group w100">
                                    <h4 class="subtitle">Smoking History</h4>
                                </div>

                                <!--Which best describes you?-->
                                <div class="form-group qc-form-group w100 form-request-item">
                                    <div class="d-flex"><label class="">Which best describes you?</label></div>
                                    <div class="form-check-group">
                                        <div class="form-check">
                                            <input class="form-radio-input" type="radio" name="1yrGn~WZFBQ17nwr54W7v" id="1yrGn~WZFBQ17nwr54W7v_I&#39;ve never smoked" tabindex="-1" value="I&#39;ve never smoked">
                                            <span class="custom-radio-input"></span>
                                            <label class="form-check-label" for="1yrGn~WZFBQ17nwr54W7v_I&#39;ve never smoked">I've never smoked</label></div>
                                        <div class="form-check">
                                            <input class="form-radio-input" type="radio" name="1yrGn~WZFBQ17nwr54W7v" id="1yrGn~WZFBQ17nwr54W7v_Current/Ex-smoker" tabindex="-1" value="Current/Ex-smoker">
                                            <span class="custom-radio-input"></span>
                                            <label class="form-check-label" for="1yrGn~WZFBQ17nwr54W7v_Current/Ex-smoker">Current/Ex-smoker</label></div>
                                    </div>
                                </div>

                                <div class="qc-form-group w100 never-smoke hidden">
                                    <h4 class="subtitle">We're Sorry!</h4>
                                </div>
                                <div class="qc-form-group w100 never-smoke hidden">
                                    <p>Quit Clinics is only able to help smokers, or ex-smokers over the age of 18. Thank you for your understanding.&nbsp;</p>
                                </div>

                                <!--  HIDDEN FIELDS-->
                                <div class="form-inner hidden-fields hidden">
                                    <!--How many cigarettes do you smoke on an average day?-->
                                    <div class="form-group qc-form-group w100 for-smokers">
                                        <div class="d-flex"><label class="">How many cigarettes do you smoke on an average day?</label></div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="0iw4CyzoA1R1jxkRdnnk9" id="0iw4CyzoA1R1jxkRdnnk9_Less than 5" tabindex="-1" value="Less than 5">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="0iw4CyzoA1R1jxkRdnnk9_Less than 5">Less than 5</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="0iw4CyzoA1R1jxkRdnnk9" id="0iw4CyzoA1R1jxkRdnnk9_5-10" tabindex="-1" value="5-10">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="0iw4CyzoA1R1jxkRdnnk9_5-10">5-10</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="0iw4CyzoA1R1jxkRdnnk9" id="0iw4CyzoA1R1jxkRdnnk9_11-20" tabindex="-1" value="11-20">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="0iw4CyzoA1R1jxkRdnnk9_11-20">11-20</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="0iw4CyzoA1R1jxkRdnnk9" id="0iw4CyzoA1R1jxkRdnnk9_More than 20" tabindex="-1" value="More than 20">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="0iw4CyzoA1R1jxkRdnnk9_More than 20">More than 20</label></div>
                                        </div>
                                    </div>

                                    <!--How many years have you smoked in total?-->
                                    <div class="form-group qc-form-group w100 for-smokers">
                                        <div class="d-flex"><label class="">How many years have you smoked in total?</label></div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="TB3HclExciO9S0_uRTCLt" id="TB3HclExciO9S0_uRTCLt_Less than 5" tabindex="-1" value="Less than 5">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="TB3HclExciO9S0_uRTCLt_Less than 5">Less than 5</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="TB3HclExciO9S0_uRTCLt" id="TB3HclExciO9S0_uRTCLt_5-10" tabindex="-1" value="5-10">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="TB3HclExciO9S0_uRTCLt_5-10">5-10</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="TB3HclExciO9S0_uRTCLt" id="TB3HclExciO9S0_uRTCLt_11-20" tabindex="-1" value="11-20">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="TB3HclExciO9S0_uRTCLt_11-20">11-20</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="TB3HclExciO9S0_uRTCLt" id="TB3HclExciO9S0_uRTCLt_20-30" tabindex="-1" value="20-30">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="TB3HclExciO9S0_uRTCLt_20-30">20-30</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="TB3HclExciO9S0_uRTCLt" id="TB3HclExciO9S0_uRTCLt_More than 30" tabindex="-1" value="More than 30">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="TB3HclExciO9S0_uRTCLt_More than 30">More than 30</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!--What method(s) have you previously tried to assist you in quitting? (please tick all that apply)-->
                                    <div class="form-group qc-form-group w100 for-smokers">
                                        <div class="d-flex"><label class="">What method(s) have you previously tried to assist you in quitting? (please tick all that apply)</label></div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-check-input" name="emDxFmHm1LidKT_L89icr" type="checkbox" data-testid="checkbox" id="emDxFmHm1LidKT_L89icr_Cold-Turkey6" tabindex="-1" value="Cold-Turkey">
                                                <span class="custom-check-input"></span>
                                                <div class="d-flex"><label class="form-check-label" for="emDxFmHm1LidKT_L89icr_Cold-Turkey6">Cold-Turkey</label></div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="emDxFmHm1LidKT_L89icr" type="checkbox" data-testid="checkbox" id="emDxFmHm1LidKT_L89icr_Nicotine Replacement Gum7" tabindex="-1" value="Nicotine Replacement Gum">
                                                <span class="custom-check-input"></span>
                                                <div class="d-flex"><label class="form-check-label" for="emDxFmHm1LidKT_L89icr_Nicotine Replacement Gum7">Nicotine Replacement Gum</label></div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="emDxFmHm1LidKT_L89icr" type="checkbox" data-testid="checkbox" id="emDxFmHm1LidKT_L89icr_Nicotine Replacement Patches8" tabindex="-1" value="Nicotine Replacement Patches">
                                                <span class="custom-check-input"></span>
                                                <div class="d-flex"><label class="form-check-label" for="emDxFmHm1LidKT_L89icr_Nicotine Replacement Patches8">Nicotine Replacement Patches</label></div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="emDxFmHm1LidKT_L89icr" type="checkbox" data-testid="checkbox" id="emDxFmHm1LidKT_L89icr_Counselling/QuitLine9" tabindex="-1" value="Counselling/QuitLine">
                                                <span class="custom-check-input"></span>
                                                <div class="d-flex"><label class="form-check-label" for="emDxFmHm1LidKT_L89icr_Counselling/QuitLine9">Counselling/QuitLine</label></div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="emDxFmHm1LidKT_L89icr" type="checkbox" data-testid="checkbox" id="emDxFmHm1LidKT_L89icr_Nicotine Vaping10" tabindex="-1" value="Nicotine Vaping">
                                                <span class="custom-check-input"></span>
                                                <div class="d-flex"><label class="form-check-label" for="emDxFmHm1LidKT_L89icr_Nicotine Vaping10">Nicotine Vaping</label></div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="emDxFmHm1LidKT_L89icr" type="checkbox" data-testid="checkbox" id="emDxFmHm1LidKT_L89icr_Nicotine Free Vaping11" tabindex="-1" value="Nicotine Free Vaping">
                                                <span class="custom-check-input"></span>
                                                <div class="d-flex"><label class="form-check-label" for="emDxFmHm1LidKT_L89icr_Nicotine Free Vaping11">Nicotine Free Vaping</label></div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="emDxFmHm1LidKT_L89icr" type="checkbox" data-testid="checkbox" id="emDxFmHm1LidKT_L89icr_Varenicline (Champix)12" tabindex="-1" value="Varenicline (Champix)">
                                                <span class="custom-check-input"></span>
                                                <div class="d-flex"><label class="form-check-label" for="emDxFmHm1LidKT_L89icr_Varenicline (Champix)12">Varenicline (Champix)</label></div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="emDxFmHm1LidKT_L89icr" type="checkbox" data-testid="checkbox" id="emDxFmHm1LidKT_L89icr_Buproprion (Zyban)13" tabindex="-1" value="Buproprion (Zyban)">
                                                <span class="custom-check-input"></span>
                                                <div class="d-flex"><label class="form-check-label" for="emDxFmHm1LidKT_L89icr_Buproprion (Zyban)13">Buproprion (Zyban)</label></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--How many years have you been vaping?-->
                                    <div class="form-group qc-form-group w100 nicotine-vaping hidden">
                                        <div class="d-flex">
                                            <label class="">How many years have you been vaping?</label>
                                        </div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="evn4c1CYWy_IXe_T~a7~N" id="evn4c1CYWy_IXe_T~a7~N_Less than 1 year" tabindex="-1" value="Less than 1 year">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="evn4c1CYWy_IXe_T~a7~N_Less than 1 year">Less than 1 year</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="evn4c1CYWy_IXe_T~a7~N" id="evn4c1CYWy_IXe_T~a7~N_More than 1 year" tabindex="-1" value="More than 1 year">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="evn4c1CYWy_IXe_T~a7~N_More than 1 year">More than 1 year</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!--what vaping product/s have you previously used?-->
                                    <div class="form-group qc-form-group w100 nicotine-vaping hidden">
                                        <div class="d-flex">
                                            <label class="">What vaping product/s have you previously used? (Please include preferred brand, nicotine strength and how much liquid you use per day)</label>
                                        </div>
                                        <input class="form-control form-input2" name="tgwN3r0X7PYP_Y2GAzCki" data-testid="input" id="tgwN3r0X7PYP_Y2GAzCki" type="text" value="" placeholder="Please fill">
                                    </div>

                                    <!--How long ago was your last cigarette?-->
                                    <div class="form-group qc-form-group w100 for-smokers">
                                        <div class="d-flex"><label class="">How long ago was your last cigarette?</label></div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="ZYA6ioeD3WkrWO0PAD7lX" id="ZYA6ioeD3WkrWO0PAD7lX_Today" tabindex="-1" value="Today">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="ZYA6ioeD3WkrWO0PAD7lX_Today">Today</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="ZYA6ioeD3WkrWO0PAD7lX" id="ZYA6ioeD3WkrWO0PAD7lX_Within the past week" tabindex="-1" value="Within the past week">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="ZYA6ioeD3WkrWO0PAD7lX_Within the past week">Within the past week</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="ZYA6ioeD3WkrWO0PAD7lX" id="ZYA6ioeD3WkrWO0PAD7lX_Within the past month" tabindex="-1" value="Within the past month">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="ZYA6ioeD3WkrWO0PAD7lX_Within the past month">Within the past month</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="ZYA6ioeD3WkrWO0PAD7lX" id="ZYA6ioeD3WkrWO0PAD7lX_1-6 months ago" tabindex="-1" value="1-6 months ago">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="ZYA6ioeD3WkrWO0PAD7lX_1-6 months ago">1-6 months ago</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="ZYA6ioeD3WkrWO0PAD7lX" id="ZYA6ioeD3WkrWO0PAD7lX_6-12 months ago" tabindex="-1" value="6-12 months ago">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="ZYA6ioeD3WkrWO0PAD7lX_6-12 months ago">6-12 months ago</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="ZYA6ioeD3WkrWO0PAD7lX" id="ZYA6ioeD3WkrWO0PAD7lX_Over 1 year ago" tabindex="-1" value="Over 1 year ago">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="ZYA6ioeD3WkrWO0PAD7lX_Over 1 year ago">Over 1 year ago</label></div>
                                        </div>
                                    </div>

                                    <div class="qc-form-group w100 for-smokers">
                                        <h4 class="subtitle">Medical History</h4>
                                    </div>

                                    <!--Please list below any significant medical illnesses, such as diabetes, cancer, asthma, COPD/emphysema or psychiatric disorders.-->
                                    <div class="form-group qc-form-group w100 for-smokers">
                                        <div class="d-flex">
                                            <label class="">Please list below any significant medical illnesses, such as diabetes, cancer, asthma, COPD/emphysema or psychiatric disorders.</label>
                                        </div>
                                        <input class="form-control form-input2" data-testid="input" name="Pt2wLbSjQowlAxDhQqXc1" id="Pt2wLbSjQowlAxDhQqXc1" type="text" value="" placeholder="Please fill">
                                    </div>

                                    <!--Have you had a stroke, heart attack, irregular heartbeat, uncontrolled hypertension or angina in the past month?-->
                                    <div class="form-group qc-form-group w100 for-smokers">
                                        <div class="d-flex">
                                            <label class="">Have you had a stroke, heart attack, irregular heartbeat, uncontrolled hypertension or angina in the past month?</label>
                                        </div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="KSW2s9naDT7hcdyY85xoj" id="KSW2s9naDT7hcdyY85xoj_Yes" tabindex="-1" value="Yes">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="KSW2s9naDT7hcdyY85xoj_Yes">Yes</label></div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="KSW2s9naDT7hcdyY85xoj" id="KSW2s9naDT7hcdyY85xoj_No" tabindex="-1" value="No">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="KSW2s9naDT7hcdyY85xoj_No">No</label></div>
                                        </div>
                                    </div>


                                    <!--Are you pregnant-->
                                    <div class="form-group qc-form-group w100 female hidden">
                                        <div class="d-flex">
                                            <label class="">Are you pregnant, or likely to become pregnant in the next 12 months?</label>
                                        </div>

                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="zCQ_zzpbA6CN15X86UA0m" id="zCQ_zzpbA6CN15X86UA0m_Yes" tabindex="-1" value="Yes">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="zCQ_zzpbA6CN15X86UA0m_Yes">Yes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="zCQ_zzpbA6CN15X86UA0m" id="zCQ_zzpbA6CN15X86UA0m_No" tabindex="-1" value="No">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="zCQ_zzpbA6CN15X86UA0m_No">No</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Are you currently breastfeeding?-->
                                    <div class="form-group qc-form-group w100 female hidden">
                                        <div class="d-flex">
                                            <label class="">Are you currently breastfeeding?</label>
                                        </div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="gXRgxbIbZgk~MiqKaDCZA" id="gXRgxbIbZgk~MiqKaDCZA_Yes" tabindex="-1" value="Yes">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="gXRgxbIbZgk~MiqKaDCZA_Yes">Yes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="gXRgxbIbZgk~MiqKaDCZA" id="gXRgxbIbZgk~MiqKaDCZA_No" tabindex="-1" value="No">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="gXRgxbIbZgk~MiqKaDCZA_No">No</label>
                                            </div>
                                        </div>
                                    </div>


                                    <!--Safety Information-->
                                    <div class="qc-form-group w100 for-smokers">
                                        <h4 class="subtitle">Safety Information and Consent</h4>
                                    </div>
                                    <!--Complete abstinence from-->
                                    <div class="form-group qc-form-group w100 for-smokers">
                                        <div class="d-flex"><label class="">Complete abstinence from smoking and vaping is the safest option for your health. Nicotine is addictive, and the long-term risks of vaping are unknown. Currently no nicotine vaping products have been approved by the TGA, and the safety of these products has not yet been thoroughly assessed. To reduce the risk of harm, Quit Clinics has set strict safety standards which can be viewed under the Knowledge tab, however Quit Clinics, or its doctors, cannot guarantee the safety of any vaping product. In order to minimise risk of harms, only short-term use of e-cigarettes is recommended, and dual use (vaping plus smoking) needs to be avoided.</label></div>
                                        <div class="form-check-group">
                                            <div class="form-check">
                                                <input class="form-radio-input" type="radio" name="9rorbO3lgeONaNXt3h4V2" id="9rorbO3lgeONaNXt3h4V2_I confirm that I have read and understand the above safety information" tabindex="-1" value="I confirm that I have read and understand the above safety information">
                                                <span class="custom-radio-input"></span>
                                                <label class="form-check-label" for="9rorbO3lgeONaNXt3h4V2_I confirm that I have read and understand the above safety information">I confirm that I have read and understand the above safety information</label>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--  HIDDEN FIELDS-->


                                <!--BUTTON-->
                                <div class="form-group qc-form-group w100  form-request-item">
                                    <button class="btn btn-body btn-blue questionnarie-submit" type="button">Submit</button>
                                </div>




                            </div><!-- Form inner-->
                        </form>
                    </div>

                    <!--MESSAGE BLOCK-->
                    <div id="success" class="success"></div>
                </div>

            </div>
            </div>
            </div>
        </section>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        <?php wp_enqueue_script( 'heydoc-js', get_theme_file_uri( '/assets/js/heydoc-script-old.js' ), array('jq-351'), '1', true ); ?>

        <?php get_template_part('template-parts/page/layout', 'page-content'); ?>
    </main>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>