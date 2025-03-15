<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    use HasFactory;

    protected $table = 'service_providers'; // Table name
    protected $primaryKey = 'providerID'; // Primary key
    protected $fillable = ['name', 'service_type', 'contact_info']; // Fillable fields
}
