<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'title',
        'slug',
        'author_id',
        'isbn',
        'price',
        'stock',
        'cover_image',
        'short_description',
        'description',
        'publication_date',
        'publisher',
        'is_active',
        'meta_title',
        'meta_description',
        'category_id',
        'sub_category_id',
    ];

    // Casts for proper data types
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'publication_date' => 'date',
      
    ];

    /**
     * Relationship: Book belongs to an Author
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
