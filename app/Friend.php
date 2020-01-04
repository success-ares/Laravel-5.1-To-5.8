<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Friend
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $friend_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @property-read \App\User $friend
 * @method static \Illuminate\Database\Query\Builder|\App\Friend whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Friend whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Friend whereFriendId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Friend whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Friend whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Friend extends Model
{
    // table name
    protected $table = 'friends';

    protected $guarded = ['id'];


    /**
     * relation to table users
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }


    /**
     * relation to table users
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function friend()
    {
        return $this->belongsTo('App\User', 'friend_id', 'id');
    }
}
