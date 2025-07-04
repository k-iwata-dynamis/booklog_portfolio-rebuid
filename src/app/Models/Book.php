<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable =[
    'user_id',
    'title',
    'author',
    'genre',
    'finished_day',
    'review',
    'rating',
    'thumbnail'
    ];

    public function user(){
        return $this->belongsTo(user::class);

    }
}
