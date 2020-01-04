<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Product
 *
 * @property integer $id
 * @property integer $biz_id
 * @property string $name
 * @property string $description
 * @property boolean $public
 * @property integer $amount
 * @property string $measure
 * @property integer $lead_reward
 * @property boolean $auto_approve
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Biz $biz
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $referrals
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereBizId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product wherePublic($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereMeasure($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereLeadReward($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereAutoApprove($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    // table name
    protected $table = 'products';
    
    protected $guarded = ['id'];


    /**
     * relation to table biz
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function biz()
    {
        return $this->belongsTo('App\Biz', 'biz_id', 'id');
    }

    /**
     * relation to users table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function referrals()
    {
        return $this->belongsToMany('App\User', 'referrals', 'product_id', 'user_id')
            ->withPivot('status', 'code', 'value', 'seller')->withTimestamps();
    }
}
