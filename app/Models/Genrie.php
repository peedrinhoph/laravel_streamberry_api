<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genrie extends Model
{
    use HasFactory;
    protected $table = 'genries';

    protected $fillable = [
        'description'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_genre', 'genre_id', 'movie_id');
    }

    public function getGenre($id)
    {
        return $this->where('id', $id)->first();
    }
}
