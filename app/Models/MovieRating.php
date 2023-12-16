<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Streaming;

class MovieRating extends Model
{

    use HasFactory;
    protected $table = 'movie_rating';

    protected $fillable = [
        'value',
        'comment',
        'user_name',
        'user_email',
        'movie_id',
        'streaming_id',
    ];

    public function streaming() {
        return $this->belongsTo(Streaming::class, 'streaming_id');
    }

    public function getRating($id)
    {
        return $this->find($id);
    }

    public function vote_average($id)
    {
        return $this::where('movie_id', $id)->avg('value');
    }
}
