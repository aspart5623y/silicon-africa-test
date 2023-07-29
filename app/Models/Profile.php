<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Traits\UUID;


class Profile extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UUID;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'email',
        'profileable_id',
        'profileable_type',
        'api_token',
        'password',
        'remember_token',
        'email_verified_at' => 'datetime',
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];



    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'blocked' => 'boolean',
        'email_verified_at' => 'datetime',
    ];


    public function profileable()
    {
        return $this->morphTo();
    }


}
