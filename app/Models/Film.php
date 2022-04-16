<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    protected $table = "films";
    protected $fillable = ['title'];

    protected $attributes = [
        'status_id' => 2,
    ];

    public function statuses(){
        return $this->belongsTo(Status::class,'status_id');
    }

    public function user_film(){
        return $this->hasMany(FavRating::class);
    }

    /*public function users(){
        return $this->belongsToMany(Film::class,'user_film','user_id','film_id');
    }*/
}
