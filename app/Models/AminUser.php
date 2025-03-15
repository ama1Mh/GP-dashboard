<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AminUser extends Model
{
    use HasFactory;

    protected $table = 'aminusers';

    protected $primaryKey = 'userID'; 
    protected $fillable = [
        'name', 'email', 'password',
    ];
}
