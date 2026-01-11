<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'url',
        'icon',
        'order_by',
        'status',
    ];

    public function submenus()
    {
        return $this->hasMany(Submenu::class)
                    ->where('status', 1)
                    ->orderBy('order_by');
    }
}
