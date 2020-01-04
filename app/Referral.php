<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Referral
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $parent_id
 * @property integer $product_id
 * @property string $status
 * @property string $code
 * @property integer $value
 * @property boolean $seller
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Referral[] $children
 * @property-read \App\User $user
 * @property-read \App\Product $product
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Message[] $message
 * @property-read \App\Deal $deal
 * @method static \Illuminate\Database\Query\Builder|\App\Referral whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Referral whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Referral whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Referral whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Referral whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Referral whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Referral whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Referral whereSeller($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Referral whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Referral whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Referral extends Model
{
    protected $table = 'referrals';

    protected $guarded = ['id'];


    /**
     * Referral program parent
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\User', 'parent_id', 'id');
    }


    /**
     * Referral followers
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('App\Referral', 'parent_id', 'user_id');
    }


    /**
     * Relation to users table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }


    /**
     * Relation to products table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }


    /**
     * Relation to messages table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function message()
    {
        return $this->hasMany('App\Message', 'referral_id', 'id');
    }


    /**
     * Relation to deals table
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function deal()
    {
        return $this->hasOne('App\Deal', 'referral_id', 'id');
    }
}
