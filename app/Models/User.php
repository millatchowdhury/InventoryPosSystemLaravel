<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    public $fillable = ['firstName', 'lastName', 'email', 'mobile', 'password', 'otp'];
    public $attributes = [
        'otp' => '0'
    ];
}
