<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $table = 'movies';

    protected $fillable = [
        'title',
        'description',
        'release_date'
    ];

    public function genries()
    {
        return $this->belongsToMany(Genrie::class, 'movie_genre', 'movie_id','genre_id');
    }

    public function getMovie($id)       
    {
       return $this->where('id', $id)->first();
    }
}
