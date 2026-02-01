<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteLogo extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo_path',
        'alt_text',
        'is_active',
    ];
}
