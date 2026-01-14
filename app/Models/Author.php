<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'nationality',
        'date_of_birth',
        'photo',
        'short_bio',
        'biography',
        'is_active',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: Author has many books
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
