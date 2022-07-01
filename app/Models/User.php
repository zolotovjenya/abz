<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'photo', 'position_id', 'created_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['photo_url'];

    public function getPhotoUrlAttribute()
    {
        return '/public/photos/'.$this->attributes['photo_id'].'.jpg';
    }

    /**
     * Get the position for the user.
     */
    public function position()
    {
        return $this->hasOne('App\Models\Positions', 'id', 'position_id');
    }
}
