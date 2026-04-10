<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookSearchController extends Controller
{
    /**
     * GET /api/books/search?q=opareting
     * Always returns books — exact match or fuzzy matched books
     */
    public function search(Request $request)
    {
        $query = trim($request->query('q', ''));

        if (!$query) {
            return response()->json([
                'status'  => false,
                'message' => 'Search query (q) is required'
            ], 400);
        }

        // ── Step 1: Exact LIKE match ──────────────────────────────────────────
        $books = $this->exactSearch($query);

        if ($books->isNotEmpty()) {
            return response()->json([
                'status'  => true,
                'matched' => 'exact',
                'data'    => $books
            ]);
        }

        // ── Step 2: Fuzzy match → still returns BOOK objects ─────────────────
        $fuzzyBooks = $this->fuzzySearchBooks($query);

        return response()->json([
            'status'  => $fuzzyBooks->isNotEmpty(),
            'matched' => 'fuzzy',
            'message' => $fuzzyBooks->isEmpty() ? 'No books found.' : 'Showing best matched books.',
            'data'    => $fuzzyBooks   // ← always book objects, never strings
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // LIKE-based search
    // ─────────────────────────────────────────────────────────────────────────
    private function exactSearch(string $query)
    {
        return Book::with(['author', 'publisher', 'category', 'subCategory'])
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('title',               'LIKE', "%{$query}%")
                  ->orWhere('isbn',              'LIKE', "%{$query}%")
                  ->orWhere('slug',              'LIKE', "%{$query}%")
                  ->orWhere('short_description', 'LIKE', "%{$query}%")
                  ->orWhereHas('author',      fn($a) => $a->where('name', 'LIKE', "%{$query}%"))
                  ->orWhereHas('publisher',   fn($p) => $p->where('name', 'LIKE', "%{$query}%"))
                  ->orWhereHas('category',    fn($c) => $c->where('name', 'LIKE', "%{$query}%"))
                  ->orWhereHas('subCategory', fn($s) => $s->where('name', 'LIKE', "%{$query}%"));
            })
            ->limit(20)
            ->get();
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Fuzzy search — scores all books, returns top 5 as full book objects
    // ─────────────────────────────────────────────────────────────────────────
    private function fuzzySearchBooks(string $query)
    {
        $queryLower = strtolower($query);
        $queryWords = explode(' ', $queryLower);

        // Load all active books with relationships
        $allBooks = Book::with(['author', 'publisher', 'category', 'subCategory'])
            ->where('is_active', true)
            ->get();

        $scored = [];

        foreach ($allBooks as $book) {
            $titleLower = strtolower($book->title);
            $titleWords = explode(' ', $titleLower);
            $bestScore  = PHP_INT_MAX;

            // ── Word-level Levenshtein ────────────────────────────────────────
            foreach ($queryWords as $qWord) {
                if (strlen($qWord) < 2) continue;
                foreach ($titleWords as $tWord) {
                    $dist = levenshtein($qWord, $tWord);
                    if ($dist < $bestScore) {
                        $bestScore = $dist;
                    }
                }
            }

            // ── Full phrase Levenshtein ───────────────────────────────────────
            $fullDist  = levenshtein($queryLower, $titleLower);
            $bestScore = min($bestScore, $fullDist);

            // ── Also score against author name ────────────────────────────────
            if ($book->author) {
                $authorDist = levenshtein($queryLower, strtolower($book->author->name));
                $bestScore  = min($bestScore, $authorDist);
            }

            $scored[] = [
                'book'  => $book,
                'score' => $bestScore,
            ];
        }

        // Sort by closest score
        usort($scored, fn($a, $b) => $a['score'] <=> $b['score']);

        // Return top 5 as a collection of book objects
        return collect($scored)
            ->take(5)
            ->pluck('book');
    }
}
