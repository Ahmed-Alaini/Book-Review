<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Static_;

class Review extends Model
{
    use HasFactory;
     
    protected $fillable =['review','rating'];

    public function book(){
        return $this->belongsTo(Book::class);
    }

    protected static function booted(){
        Static:: updated(fn(Review $review)=>cache()->forget('book:'.$review->book_id));
        Static:: deleted(fn(Review $review)=>cache()->forget('book:'.$review->book_id));
        Static:: created(fn(Review $review)=>cache()->forget('book:'.$review->book_id));
    }
}
