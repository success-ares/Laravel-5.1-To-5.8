<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Billing
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $card_id
 * @property string $first_name
 * @property string $last_name
 * @property string $business_name
 * @property string $address
 * @property string $suburb
 * @property string $city
 * @property string $country
 * @property string $phone
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @property-read \App\DirectDebit $directDebit
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereCardId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereBusinessName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereSuburb($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Billing extends Model
{
    // table name
    protected $table = 'billings';

    // guarded fields
    protected $guarded = ['id'];


    /**
     * relation to users table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }


    /**
     * Relation to direct_debits table
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function directDebit()
    {
        return $this->hasOne('App\DirectDebit', 'billing_id', 'id');
    }
}
