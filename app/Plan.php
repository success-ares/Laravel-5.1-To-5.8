<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Plan
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $plan_name
 * @property \Carbon\Carbon $finished_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan wherePlanName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereFinishedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Plan extends Model
{
    protected $table = 'plans';

    protected $guarded = ['id'];

    protected $dates = ['created_at', 'updated_at', 'finished_at'];

    /**
     * relation to table users
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
