<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function reviews(){

        return $this->hasMany(Review::class);
    }
    
    public function scopeTitle(Builder $query, string $title) : Builder
    { 
        return $query->where('title','LIKE','%'.$title.'%');
    }
    
    public function scopePopular(Builder $query, $from=null, $to =null ) : Builder
    {
       return $query->withCount([
        'reviews'=>fn( Builder$q)=> $this->dataRangeFilter($q,$from,$to)
        ])
               ->orderBy('reviews_count','desc');
    }

    public function scopeHighesRated(Builder $query,$from=null,$to=null) : Builder
    {
        return $query->withAvg([
            'reviews'=>fn(Builder $q)=> $this->dataRangeFilter($q,$from,$to)
        ],'rating')
                ->orderBy('reviews_avg_rating','desc'); 
    }
    
    public function scopeNinReviews(Builder $query, int $minReviews){
        return $query->havin('reciews_count','>=',$minReviews);
    }
    
    private function dataRangeFilter(Builder $query, $from=null, $to =null){
        if($from && !$to){
            $query->where('created_at','>=','$from');
         }
         elseif(!$from && $to){
             $query->where('created_at','<=','$to');
         }
         elseif($from && $to){
             $query->whereBetween('created_at',['$from','$to']);
         }
    }
}
