<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstablishmentDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'est_name',
        'est_address',
        'est_contact_number',
        'est_tin_number'
    ];
}
