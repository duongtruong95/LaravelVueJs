<?php

namespace App;
use App\Traits\UnixTimestampSerializable;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use UnixTimestampSerializable;
    protected $table = 'notification_user';
    protected $fillable = [
        'is_readed',
    ];

    public function notification()
    {
        return $this->belongsTo('App\Notification', 'notification_id');
    }
}
