<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    use HasFactory;

    protected $table = 'user_reports'; // Make sure this matches your database table

    protected $primaryKey = 'reportID';

    protected $fillable = [
        'userID', 'description', 'status',
    ];
}
