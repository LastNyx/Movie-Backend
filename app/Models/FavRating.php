<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavRating extends Model
{
    use HasFactory;
    protected $table = "user_film";
    protected $fillable = ['user_id','film_id','rating','favorite'];

    protected $attributes = [
        'rating' => 0,
        'favorite' => 0,
    ];

    public function films(){
        return $this->belongsTo(Film::class, 'film_id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
