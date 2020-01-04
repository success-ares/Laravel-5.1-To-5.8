<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Withdrawal
 *
 * @property integer $id
 * @property integer $user_id
 * @property float $amount
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $transaction
 * @method static \Illuminate\Database\Query\Builder|\App\Withdrawal whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Withdrawal whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Withdrawal whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Withdrawal whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Withdrawal whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Withdrawal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Withdrawal extends Model
{
    // table name
    protected $table = 'withdrawals';

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
     * Relation to transactions table
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function transaction()
    {
        return $this->morphMany('App\Transaction', 'source');
    }
}
