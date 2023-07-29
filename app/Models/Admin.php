<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Admin extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'level',
        'phone'
    ];

    public function profile()
    {
        return $this->morphOne(Profile::class, 'profileable');
    }
}
