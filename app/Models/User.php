<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['username', 'email', 'password', 'address'];  // Include address here

}
