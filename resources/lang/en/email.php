<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Email Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during email template for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

	/**
	 * You were added to referral program.
	 * about-product.blade.php
	 */
    'msg_about_product' => ':first_name :last_name has referred :business_name to you.<br>
							Referral program - :product_name<br>
							You can contact them on :business_phone or :business_email.',
	
	/**
	 * Please confirm your email address
	 * activate.blade.php
	 */
    'msg_active' => 'We may need to send you critical information about our service and it is<br>
                    important that we have an accurate email address.',
	
	/**
	 * Name has invited you to join Pyramd
	 * add-friend.blade.php
	 */
    'msg_add_friend' => ':first_name :last_name has invited you to join Pyramd.',
	
	/**
	 * Name has submitted a direct debit authority request
	 * direct-authority.blade.php
	 */
    'msg_direct_debit_authority' => ':business_name has submitted a direct debit authority request',
	
	/**
	 * A new request for accession to the referral program
	 * join-approved.blade.php
	 */
    'msg_join_approved' => 'You joined referral program for :business_name as sales person to the business',
	
	/**
	 * A new request for accession to the referral program
	 * join-declined.blade.php
	 */
    'msg_join_declined' => 'We apologize but your application has been declined. Please try again in a while.',
	
	/**
	 * A new request for accession to the referral program
	 * join-details.blade.php
	 */
    'msg_join_details' => 'Person :first_name :last_name would like to refer you someone.',
	
	/**
	 * Your Password Reset Link
	 * password.blade.php
	 */
    'msg_password_reset' => 'Hello. You, or someone else, has requested a password change on :site_url
							<br><br>
							If you did not make this request, please ignore this email.
							Otherwise, click on the link below to confirm your request and reset your password.',
	
	/**
	 * Added new referral
	 * refer-detail.blade.php
	 */
    'msg_add_referral' => ':user_first_name :user_last_name has referred :referral_first_name :referral_last_name to you.',
	
	/**
	 * Accept Invitation
	 * refer-invite.blade.php
	 */
    'msg_refer_invite' => ':first_name :last_name has referred :business_name to you.<br>
							You can contact them on :business_phone or :business_email.',
	
	/**
	 * Referred company details
	 * to-referral.blade.php
	 */
    'msg_to_referral' => ':first_name :last_name has referred :business_name to you.<br>
							You can contact them on :business_phone or :business_email.',
	
	/**
	 * Confirm withdrawal of funds
	 * withdrawal.blade.php
	 */
    'msg_withdrawal' => ':first_name :last_name would like to withdraw $:amount from their account.',
];
