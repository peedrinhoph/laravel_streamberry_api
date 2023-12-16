<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->belongsToMany(
            Genrie::class,
            'movie_genre',
            'movie_id',
            'genre_id'
        );
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

    public function streamingsCoutn()
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
        return $this->where('id', $id)->withCount([
            'vote' => function ($query) {
                $query->select(DB::raw("avg(value)"));
            }
        ])->first();
    }

    public function retornaMovies($filtros)
    {
        $retorno = $this->with(['genries', 'vote'])
            ->withCount([
                'vote' => function ($query) {
                    $query->select(DB::raw("avg(value)"));
                }
            ]);


        if (is_array($filtros)) {

            foreach ($filtros as $campo => $valor) {

                switch ($campo) {
                    case 'title':
                        if ($valor) $retorno->where('movies.title', 'LIKE', "%$valor%");
                        break;

                    case 'release_date_start':
                        if ($valor) $retorno->where('movies.release_date', '>=', Carbon::parse($valor)->format('Y-m-d'));
                        break;

                    case 'release_date_end':
                        if ($valor) $retorno->where('movies.release_date', '<=', Carbon::parse($valor)->format('Y-m-d'));
                        break;

                    case 'vote_average':
                        if ($valor) $retorno->where(
                            function (Builder $query) {
                                $query->selectRaw('movie_rating.avg(value)')->from('movie_rating')->where('movie_rating.movie_id', '=', 'movies.id');
                            }
                        );
                        break;
                }
            }
        }

        if (array_key_exists('order_by_release_date', $filtros)) {

            foreach ($filtros as $order => $dir) {

                switch ($order) {
                    case 'order_by_release_date':
                        $retorno->orderBy("movies.release_date", $dir);
                        break;
                }
            }
        }
        // dd($retorno->get());
        return $retorno;
    }
}
