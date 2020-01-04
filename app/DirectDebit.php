<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DirectDebit
 *
 * @property integer $id
 * @property integer $billing_id
 * @property string $account_number
 * @property string $account_name
 * @property string $bank_name
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Deal[] $deal
 * @property-read \App\Billing $billing
 * @method static \Illuminate\Database\Query\Builder|\App\DirectDebit whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectDebit whereBillingId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectDebit whereAccountNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectDebit whereAccountName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectDebit whereBankName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectDebit whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectDebit whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DirectDebit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DirectDebit extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'direct_debits';

    /**
     * @var array
     */
    protected $guarded = ['id'];


    /**
     * Relation to deals table
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function deal()
    {
        return $this->morphMany('App\Deal', 'payment');
    }


    /**
     * Relation to billing table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function billing()
    {
        return $this->belongsTo('App\Billing', 'billing_id', 'id');
    }
}
