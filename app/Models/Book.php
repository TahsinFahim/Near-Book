<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

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
        'publisher_id',
        'is_active',
        'meta_title',
        'meta_description',
        'category_id',
        'sub_category_id',
        'discount_parcentage',
        'pdf_price',
    ];

    protected $casts = [
        'price'            => 'decimal:2',
        'pdf_price'        => 'decimal:2',
        'stock'            => 'integer',
        'is_active'        => 'boolean',
        'publication_date' => 'date',
    ];

    // ── Relationships ────────────────────────────────────────────────────────

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    // ── Scopes ───────────────────────────────────────────────────────────────

    /**
     * Only return active books
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Search across title, isbn, slug, short_description
     */
    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title',              'LIKE', "%{$term}%")
              ->orWhere('isbn',             'LIKE', "%{$term}%")
              ->orWhere('slug',             'LIKE', "%{$term}%")
              ->orWhere('short_description','LIKE', "%{$term}%");
        });
    }
}
