<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Streaming extends Model
{
    use HasFactory;
    protected $table = 'streamings';

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function movies()
    {
        return $this->belongsToMany(
            Movie::class,
            'streaming_movies',
            'streaming_id',
            'movie_id'
        );
    }

    public function getStreaming($id)
    {
        return $this->find($id);
    }
}
