<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Notification
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $notification_header
 * @property string $notification_text
 * @property boolean $notification_status
 * @property string $notification_link
 * @property string $notification_icon
 * @property string $notification_icon_style
 * @property string $notification_image
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereNotificationHeader($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereNotificationText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereNotificationStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereNotificationLink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereNotificationIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereNotificationIconStyle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereNotificationImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Notification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Notification extends Model
{
    // table name
    protected $table = 'notifications';

    protected $guarded = ['id'];


    /**
     * relation to users table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
