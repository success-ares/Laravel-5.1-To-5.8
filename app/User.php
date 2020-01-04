<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
/**
 * App\User
 *
 * @property integer $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $company
 * @property string $address
 * @property string $description
 * @property string $photo
 * @property boolean $business
 * @property string $activation_code
 * @property boolean $status
 * @property string $password
 * @property float $balance
 * @property string $type
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Biz $biz
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $product
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Referral[] $refer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Message[] $message
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $transaction
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $favourite
 * @property-read \App\Billing $billing
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $friends
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCompany($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePhoto($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereBusiness($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereActivationCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereBalance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDeletedAt($value)
 * @mixin \Eloquent
 */
class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, SoftDeletes, Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'balance'];


    /**
     * Relation to biz table
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function biz()
    {
        return $this->hasOne('App\Biz', 'user_id', 'id');
    }


    /**
     * relation to products table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function product()
    {
        return $this->belongsToMany('App\Product', 'referrals', 'user_id', 'product_id')
            ->withPivot('status', 'code', 'value', 'seller')->withTimestamps();
    }

    /**
     * Relation to referrals table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function refer()
    {
        return $this->hasMany('App\Referral', 'user_id', 'id');
    }


    /**
     * Relation to messages table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function message()
    {
        return $this->hasMany('App\Message', 'sender_id', 'id');
    }


    /**
     * Relation to transactions table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaction()
    {
        return $this->hasMany('App\Transaction', 'user_id', 'id');
    }


    /**
     * relation to favourite table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favourite()
    {
        return $this->belongsToMany('App\Product', 'favourites', 'user_id', 'product_id');
    }


    /**
     * Relation to billings table
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function billing()
    {
        return $this->hasOne('App\Billing', 'user_id', 'id');
    }


    /**
     * relation to users table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friends()
    {
        return $this->belongsToMany('App\User', 'friends', 'user_id', 'friend_id')->withPivot('id');
    }


    /**
     * Relation to notifications table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notification()
    {
        return $this->hasMany('App\Notification', 'user_id', 'id');
    }
}
