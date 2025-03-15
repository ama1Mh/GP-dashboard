<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $primaryKey = 'requestID';

    protected $fillable = [
        'userID',
        'providerID',
        'status',
        'requestType',
        'priority',
        'description',
        'created_at',
        'updated_at',
    ];
}
