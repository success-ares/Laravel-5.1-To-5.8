<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Favourite
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $product_id
 * @method static \Illuminate\Database\Query\Builder|\App\Favourite whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Favourite whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Favourite whereProductId($value)
 * @mixin \Eloquent
 */
class Favourite extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'favourites';

    /**
     * Guarded
     * @var array
     */
    protected $guarded = ['id'];
}
