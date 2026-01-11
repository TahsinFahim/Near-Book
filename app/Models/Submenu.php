<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    protected $fillable = [
        'menu_id',
        'name',
        'url',
        'order_by',
        'status',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
