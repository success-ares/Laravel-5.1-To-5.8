<?php

namespace App\Service;

use Mail;

trait EmailSenderService
{

    /**
     * Send an email to the user activation code
     * @param $user
     */
    protected function sendConfirmEmail($user, $refer = null)
    {
        Mail::queue('emails.activate', compact('user', 'refer'), function ($message) use ($user) {
            $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Please confirm your email address');
        });
    }


    /**
     * Send information about product to referral
     * @param $user
     */
    protected function sendEmailAboutProduct($user, $seller, $product)
    {
        Mail::queue('emails.about-product', compact('seller', 'product'), function ($message) use ($user) {
            $message->to($user->email, $user->first_name)->subject('You were added to referral program.');
        });
    }


    /**
     * Send information to referral
     * @param $user
     */
    protected function sendToReferral($user, $refer)
    {
        Mail::queue('emails.to-referral', compact('refer'), function ($message) use ($user) {
            $message->to($user->email, $user->first_name)->subject('Referred company details');
        });
    }


    /**
     * Send email to biz company
     * @param $user
     * @param $biz
     * @param $referral
     */
    protected function sendReferralDetails($user, $biz, $referral, $refId)
    {
        Mail::queue('emails.refer-detail', compact('user', 'referral', 'refId'), function ($message) use ($biz) {
            $message->to($biz->email, $biz->biz_name)->subject('Added new referral');
        });
    }


    /**
     * Send email to biz company
     * @param $user
     * @param $biz
     * @param $parent
     */
    protected function sendInviteEmail($user, $biz, $parent)
    {
        Mail::queue('emails.refer-invite', compact('user', 'biz', 'parent'), function ($message) use ($user) {
            $message->to($user->email, $user->first_name)->subject('Accept Invitation');
        });
    }


    /**
     * Apply to join referral program
     * @param $business
     * @param $user
     * @param $code
     */
    protected function sendJoinDetails($business, $user, $code)
    {
        Mail::queue('emails.join-details', compact('user', 'code'), function ($message) use ($business) {
            $message->to($business->email, $business->contact_person)->subject('A new request for accession to the referral program');
        });
    }


    /**
     * Approve new seller
     * @param $user
     * @param $bizName
     */
    protected function sendJoinApproved($user, $bizName)
    {
        Mail::queue('emails.join-approved', compact('bizName'), function ($message) use ($user) {
            $message->to($user->email, $user->first_name)->subject('A new request for accession to the referral program');
        });
    }


    /**
     * Decline new seller
     * @param $user
     */
    protected function sendJoinDeclined($user)
    {
        Mail::queue('emails.join-declined', compact('user'), function ($message) use ($user) {
            $message->to($user->email, $user->first_name)->subject('A new request for accession to the referral program');
        });
    }


    /**
     * Withdrawal request
     * @param $admin
     * @param $user
     * @param $amount
     * @param $id
     */
    protected function sendWithdrawalRequest($admin, $user, $amount, $id)
    {
        Mail::queue('emails.withdrawal', compact('user', 'amount', 'id'), function ($message) use ($admin) {
            $message->to($admin->email, $admin->first_name)->subject('Confirm withdrawal of funds');
        });
    }


    /**
     * Authority direct debit
     * @param $admin
     * @param $directDebit
     */
    protected function sendAuthorityRequest($admin, $directDebit, $biz)
    {
        Mail::queue('emails.direct-authority', compact('directDebit', 'biz'), function ($message) use ($admin, $biz) {
            $message->to($admin->email, $admin->first_name)->subject($biz->biz_name . ' has submitted a direct debit authority request');
        });
    }


    /**
     * Send invite to a friend
     * @param $email
     * @param $from
     */
    protected function sendAddFriend($email, $from)
    {
        Mail::queue('emails.add-friend', compact('from'), function ($message) use ($email, $from) {
            $message->to($email)->subject($from->first_name . ' ' . $from->last_name . ' has invited you to join Pyramd');
        });
    }

    /**
     * Send contact
     * @param $email
     * @param $from
     */
    protected function sendContact($admin, $m)
    {
        Mail::queue('emails.contact', compact('m'), function ($message) use ($admin) {
            $message->to($admin->email, $admin->first_name)->subject('[Pyramd] Contact form');
        });
    }
}
