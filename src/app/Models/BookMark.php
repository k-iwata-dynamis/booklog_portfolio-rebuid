<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'author',
        'genre',
        'price',
        'review_average',
        'review_count',
        'image_url',
        'book_url',
        'rakuten_book_id',
        'type',
    ];
         public function user(){
        return $this->belongsTo(User::class);
         }
}
