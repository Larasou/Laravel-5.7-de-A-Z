<?php

namespace App;

use App\Mail\RegisterMail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected static function boot()
    {
        parent::boot();

        if (app()->isLocal()) {
            self::created(function ($model) {
                static::first()->update([
                    'name' => 'Soulouf',
                    'email' => 'contact@larasou.com',
                ]);
            });;

        }


      self::deleting(function ($model) {
          $model->projects->each->delete();
      });

    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at', 'token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($password) 
    {
        $this->attributes['password'] = \Hash::make($password);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
