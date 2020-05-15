<?php

namespace App;
use App\Traits\UnixTimestampSerializable;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use UnixTimestampSerializable;
    protected $table = 'notifications';
    protected $fillable = [
        'title',
        'content',
        'created_by',
        'updated_by',
    ];

    public function userCreated()
    {
        return $this->belongsto('App\User', 'created_by');
    }

    public function userUpdated()
    {
        return $this->belongsto('App\User', 'updated_by');
    }

    public function usersReaded()
    {
        return $this->belongsToMany('App\User')->wherePivot('is_readed', 1);
    }

    public function usersUnread()
    {
        return $this->belongsToMany('App\User')->wherePivot('is_readed', 0);
    }

    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('is_readed');
    }
}
