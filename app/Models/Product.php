<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use Notifiable;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'internal_note',
        'category_id'
    ];
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
