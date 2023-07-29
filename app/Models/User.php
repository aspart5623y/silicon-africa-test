<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\UUID;

class User extends Model
{
    use HasFactory, UUID;


    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'can_post',
        'phone'
    ];

    protected $casts = [
        "can_post" => 'boolean'
    ];

    public function profile()
    {
        return $this->morphOne(Profile::class, 'profileable');
    }

    /**
     * Get all of the posts for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(\App\Models\Post::class, 'user_id', 'id');
    }


    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(\App\Models\Comment::class, 'user_id', 'id');
    }
}
