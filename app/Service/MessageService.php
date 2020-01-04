<?php namespace App\Service;

use App\Message;

trait MessageService
{

    /**
     * Show all messages for selected referral
     * @param $refer
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getMessages($refer)
    {
        return Message::where('referral_id', $refer)->with('sender')->orderBy('created_at', 'desc')->get();
    }


    /**
     * Seller Dashboard
     * @param $sellerId
     * @param array $referralsId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getMessagesSeller($sellerId, array $referralsId)
    {
        return Message::whereIn('referral_id', $referralsId)->where('sender_id', '<>', $sellerId)
            ->with('sender')->orderBy('created_at', 'desc')->get();
    }


}