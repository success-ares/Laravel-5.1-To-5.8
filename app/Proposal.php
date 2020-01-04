<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Proposal
 *
 * @property integer $id
 * @property integer $biz_id
 * @property integer $user_id
 * @property string $code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @property-read \App\Biz $biz
 * @method static \Illuminate\Database\Query\Builder|\App\Proposal whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Proposal whereBizId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Proposal whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Proposal whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Proposal whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Proposal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Proposal extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'proposals';

    /**
     * @var array
     */
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
     * relation to table biz
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function biz()
    {
        return $this->belongsTo('App\Biz', 'biz_id', 'id');
    }
}
