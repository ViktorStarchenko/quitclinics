<?php

// Add is_verified field
function user_medical_profile_fileds( $user ) {
    ?>
    <h2>Medical History</h2>
    <table class="form-table" style="background: #60c6ed;">
        <tr>
            <th>Last Medical History Update:</th>
            <td>
                <p><label for="">
                        <input id="last_history_update" name="last_history_update" type="text" value="<?php echo get_user_meta($user->ID, 'last_history_update', true) ?>" disabled/>
                    </label></p>
            </td>
        </tr>
        <tr>
            <th>First Name:</th>
            <td>
                <p><label for="">
                        <input id="first" name="first" type="text" value="<?php echo get_user_meta($user->ID, 'first', true) ?>" disabled/>
                    </label></p>
            </td>
        </tr>
        <tr>
            <th>Last Name:</th>
            <td>
                <p><label for="">
                        <input id="last" name="last" type="text" value="<?php echo get_user_meta($user->ID, 'last', true) ?>" disabled/>
                    </label></p>

            </td>
        </tr>
        <tr>
            <th>Questionnaire Email:</th>
            <td>
                <p><label for="">
                        <input id="questionnaire_email" name="questionnaire_email" type="text" value="<?php echo get_user_meta($user->ID, 'questionnaire_email', true) ?>" disabled/>
                    </label></p>

            </td>
        </tr>
        <tr>
            <th>Day of Birth</th>

            <td>
                <p><input id="additional_dob" name="additional_dob" type="text" value="<?php  echo get_user_meta($user->ID, 'additional_dob', true); ?>" disabled/></p>
            </td>
        </tr>

        <tr>
            <th>How long ago was your last cigarette?</th>
            <td>
                <p><label for="last_cigarette_Today">
                        <input
                            id="last_cigarette_Today"
                            name="last_cigarette"
                            type="checkbox"
                            value="Today"
                            <?php  echo (get_user_meta($user->ID, 'last_cigarette', true) == 'Today' ? 'checked' : ''); ?> disabled/>
                        Today</label></p>
                <p><label for="last_cigarette_Within the past week">
                        <input
                            id="last_cigarette_Within the past week"
                            name="last_cigarette"
                            type="checkbox"
                            value="Within the past week"
                            <?php  echo (get_user_meta($user->ID, 'last_cigarette', true) == 'Within the past week' ? 'checked' : ''); ?> disabled/>
                        Within the past week</label></p>
                <p><label for="last_cigarette_Within the past month">
                        <input
                            id="last_cigarette_Within the past month"
                            name="last_cigarette"
                            type="checkbox"
                            value="Within the past week"
                            <?php  echo (get_user_meta($user->ID, 'last_cigarette', true) == 'Within the past month' ? 'checked' : ''); ?> disabled/>
                        Within the past month</label></p>
                <p><label for="last_cigarette_1-6 months ago">
                        <input
                            id="last_cigarette_1-6 months ago"
                            name="last_cigarette"
                            type="checkbox"
                            value="1-6 months ago"
                            <?php  echo (get_user_meta($user->ID, 'last_cigarette', true) == '1-6 months ago' ? 'checked' : ''); ?> disabled/>
                        1-6 months ago</label></p>
                <p><label for="last_cigarette_Over 1 year ago">
                        <input
                            id="last_cigarette_Over 1 year ago"
                            name="last_cigarette"
                            type="checkbox"
                            value="Over 1 year ago"
                            <?php  echo (get_user_meta($user->ID, 'last_cigarette', true) == 'Over 1 year ago' ? 'checked' : ''); ?> disabled/>
                        Over 1 year ago</label></p>

            </td>
        </tr>

        <tr>
            <th>What vaping product/s are you currently using? (Please include brand, nicotine strength and how many mLs/pods used per day)
            </th>

            <td>
                <p><input id="vaping_product" name="vaping_product" type="text" value="<?php  echo get_user_meta($user->ID, 'vaping_product', true); ?>" disabled/></p>
            </td>
        </tr>

        <tr>
            <th>Have you had a stroke, heart attack, irregular heartbeat, uncontrolled hypertension or angina in the past month?
            </th>
            <td>
                <p><label for="heart_attack_Yes">
                        <input
                            id="heart_attack_Yes"
                            name="heart_attack"
                            type="checkbox"
                            value="Today"
                            <?php  echo (get_user_meta($user->ID, 'heart_attack', true) == 'Yes' ? 'checked' : ''); ?> disabled/>
                        Yes</label></p>
                <p><label for="heart_attack_No">
                        <input
                            id="heart_attack_No"
                            name="heart_attack"
                            type="checkbox"
                            value="Within the past week"
                            <?php  echo (get_user_meta($user->ID, 'heart_attack', true) == 'No' ? 'checked' : ''); ?> disabled/>
                        No</label></p>


            </td>
        </tr>
        <tr>
            <th>Are you pregnant, or do you plan to become pregnant in the next 12 months?
            </th>
            <td>
                <p><label for="are_you_pregnant_Yes">
                        <input
                            id="are_you_pregnant_Yes"
                            name="are_you_pregnant"
                            type="checkbox"
                            value="Today"
                            <?php  echo (get_user_meta($user->ID, 'are_you_pregnant', true) == 'Yes' ? 'checked' : ''); ?> disabled/>
                        Yes</label></p>
                <p><label for="are_you_pregnant_No">
                        <input
                            id="are_you_pregnant_No"
                            name="are_you_pregnant"
                            type="checkbox"
                            value="Within the past week"
                            <?php  echo (get_user_meta($user->ID, 'are_you_pregnant', true) == 'No' ? 'checked' : ''); ?> disabled/>
                        No</label></p>


            </td>
        </tr>

        <tr>
            <th>Do you have any special requirements or requests? Is there anything else you would like your doctor to know?
            </th>
            <td>
                <p><label for="special_requirements">
                        <input id="special_requirements" name="special_requirements" type="text" value="<?php echo get_user_meta($user->ID, 'special_requirements', true) ?>" disabled/>
                    </label></p>
            </td>
        </tr>

        <tr>
            <th>Your documents will be securely emailed to you, and no one else, unless you request otherwise. If you would like us to also forward your prescription to a pharmacy, supplier or friend/carer, please enter their email address.

            </th>
            <td>
                <p><label for="emaile_documents">
                        <input id="emaile_documents" name="emaile_documents" type="text" value="<?php echo get_user_meta($user->ID, 'emaile_documents', true) ?>" disabled/>
                    </label></p>
            </td>
        </tr>

        <tr>
            <th>Complete abstinence from smoking and vaping is the safest option for your health. Nicotine is addictive, and the long-term risks of vaping are unknown. Currently no nicotine vaping products have been approved by the TGA, and the safety of these products has not yet been thoroughly assessed. In order to minimise risk of harm, only short-term use of e-cigarettes is recommended, and dual use (vaping plus smoking) needs to be avoided.
            </th>
            <td>
                <p><label for="gbHG9mDZV7bRmXggwJyYI_I confirm that I have read and understand the above safety information">
                        <input
                            id="gbHG9mDZV7bRmXggwJyYI_I confirm that I have read and understand the above safety information"
                            name="confirm_safety_information"
                            type="checkbox"
                            value="I confirm that I have read and understand the above safety information"
                            <?php  echo (get_user_meta($user->ID, 'confirm_safety_information', true) == 'I confirm that I have read and understand the above safety information' ? 'checked' : ''); ?> disabled/>
                        I confirm that I have read and understand the above safety information</label></p>

            </td>
        </tr>


    </table>
    <?php
}// Add is_agreed field
add_action( 'show_user_profile', 'user_medical_profile_fileds' );
add_action( 'edit_user_profile', 'user_medical_profile_fileds' );

