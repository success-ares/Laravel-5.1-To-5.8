<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Deal
 *
 * @property integer $id
 * @property integer $referral_id
 * @property integer $payment_id
 * @property string $payment_type
 * @property float $amount
 * @property string $paid_status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Referral $referral
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $transaction
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $payment
 * @method static \Illuminate\Database\Query\Builder|\App\Deal whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Deal whereReferralId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Deal wherePaymentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Deal wherePaymentType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Deal whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Deal wherePaidStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Deal whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Deal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Deal extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'deals';

    /**
     * @var array
     */
    protected $guarded = ['id'];


    /**
     * Relation to referrals table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referral()
    {
        return $this->belongsTo('App\Referral', 'referral_id', 'id');
    }


    /**
     * Relation to transactions table
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function transaction()
    {
        return $this->morphMany('App\Transaction', 'source');
    }


    /**
     * Relation to pay-pal and direct debits tables
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function payment()
    {
        return $this->morphTo();
    }
}
