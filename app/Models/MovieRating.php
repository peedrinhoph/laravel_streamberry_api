<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieRating extends Model
{

    use HasFactory;
    protected $table = 'movie_rating';

    protected $fillable = [
        'value',
        'comment',
        'user_id',
        'movie_id',
        'streaming_movie_id',
    ];


    public function post()
    {
        return $this->belongsTo(StreamingMovie::class, 'streaming_movie_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vote_average($id)
    {
       return $this::where('movie_id', $id)->avg('value');
    }
}
