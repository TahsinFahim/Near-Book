<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    protected $table = 'publishers';

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'address',
        'website',
        'logo',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Publisher has many books
     */
    public function books()
    {
        return $this->hasMany(Book::class, 'publisher_id');
    }
}
