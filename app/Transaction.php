<?php namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Transaction
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $source_id
 * @property string $source_type
 * @property string $type
 * @property float $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $source
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereSourceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereSourceType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
     protected $table = 'transactions';

    /**
     * @var array
     */
    protected $guarded = ['id'];


    /**
     * Relation to deal, withdrawal.. models
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function source()
    {
        return $this->morphTo();
    }
}
