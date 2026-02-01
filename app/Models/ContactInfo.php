<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'whatsapp',
        'email',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'youtube',
        'is_active',
    ];
}
