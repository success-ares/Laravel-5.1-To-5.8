<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Eway
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $transaction_id
 * @property float $amount
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Deal[] $deal
 * @method static \Illuminate\Database\Query\Builder|\App\Eway whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Eway whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Eway whereTransactionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Eway whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Eway whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Eway whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Eway whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Eway extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'eway';

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
}
