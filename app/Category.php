<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Category
 *
 * @property integer $code
 * @property integer $parent_code
 * @property string $category_name
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereParentCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereCategoryName($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    // table name
    protected $table = 'categories';
    
    protected $guarded = [];

    public $timestamps = false;
}
