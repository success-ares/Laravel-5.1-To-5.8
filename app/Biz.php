<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Biz
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $category_code
 * @property string $biz_name
 * @property string $name_alias
 * @property string $phone
 * @property string $email
 * @property string $contact_person
 * @property string $description
 * @property string $logo
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @property-read \App\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $product
 * @method static \Illuminate\Database\Query\Builder|\App\Biz whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Biz whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Biz whereCategoryCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Biz whereBizName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Biz whereNameAlias($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Biz wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Biz whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Biz whereContactPerson($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Biz whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Biz whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Biz whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Biz whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Biz extends Model
{
    // table name
    protected $table = 'biz';

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
     * relation to categories table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_code', 'code');
    }


    /**
     * relation to product table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product()
    {
        return $this->hasMany('App\Product', 'biz_id', 'id');
    }
}
