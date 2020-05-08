<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = 'user_notification';
    protected $fillable = [
        'is_readed',
    ];

    public function notification()
    {
        return $this->belongsTo('App\Notification', 'notification_id');
    }
}
