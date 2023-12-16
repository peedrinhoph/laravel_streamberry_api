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
        return $this->belongsToMany(Genrie::class, 'movie_genre', 'movie_id', 'genre_id');
    }

    public function streamings()
    {
        return $this->belongsToMany(
            Streaming::class,
            'streaming_movies',
            'movie_id',
            'streaming_id'
        );
    }

    // public function vote()
    // {
    //     return $this->belongsToMany(MovieRating::class
    //     , 'streaming_movies'
    //     , 'movie_id'
    //     , 'id'
    //     , ''
    //     , 'streaming_movie_id'
    //     );
    // }

    public function vote()
    {
        return $this->hasMany(MovieRating::class);
    }

    public function getMovie($id)
    {
        return $this->where('id', $id)->first();
    }
}
