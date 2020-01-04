<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Message
 *
 * @property integer $id
 * @property integer $referral_id
 * @property integer $sender_id
 * @property string $message
 * @property string $file_name
 * @property string $attachment
 * @property boolean $read
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $sender
 * @property-read \App\Referral $refer
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereReferralId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereSenderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereAttachment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereRead($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Message extends Model
{
    // table name
    protected $table = 'messages';

    protected $guarded = ['id'];


    /**
     * Relation to users table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id', 'id');
    }


    /**
     * Relation to referrals table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function refer()
    {
        return $this->belongsTo('App\Referral', 'referral_id', 'id');
    }
}
