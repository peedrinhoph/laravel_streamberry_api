<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PhpParser\Node\Stmt\Break_;

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
        $retorno = $this->with(['genries', 'vote', 'streamings'])
            // ->addSelect([
            //     'vote_average' => MovieRating::select(DB::raw('round(AVG(value),0) as vote_average'))
            //         ->whereColumn('movie_id', '=', 'movies.id')
            //         ->groupBy('movie_id')
            // ])
        ;

        if (is_array($filtros)) {

            foreach ($filtros as $campo => $valor) {

                switch ($campo) {
                    case 'title':
                        if ($valor)
                            $retorno->where('movies.title', 'LIKE', "%$valor%");
                            // $retorno->when($valor->filled(), function (Builder $q, $valor) {
                            //     return $q->where(function (Builder $q, $valor) {
                            //         return $q->where('movies.title', 'LIKE', "%$valor%")
                            //             ->orWhere('movies.description', 'LIKE', "%$valor%");
                            //     });
                            // });
                        break;

                    case 'release_date_start':
                        if ($valor) $retorno->where('movies.release_date', '>=', Carbon::parse($valor)->format('Y-m-d'));
                        break;

                    case 'release_date_end':
                        if ($valor) $retorno->where('movies.release_date', '<=', Carbon::parse($valor)->format('Y-m-d'));
                        break;

                    case 'release_date_between':
                        $between = explode(",", $valor);
                        if ($between) $retorno->whereBetween('movies.release_date', [$between]);
                        break;

                    case 'movies_per_year':
                        if ($valor) $retorno->where(DB::raw("date_format(movies.release_date, '%Y')"), '=', Carbon::parse($valor)->format('Y'));
                        break;

                    case 'vote_average':
                        if ($valor) $retorno->whereRaw('(select avg(value) from movie_rating where movie_rating.movie_id = movies.id group by movie_id) >= ' . $valor);
                        break;
                }
            }
        }

        if (array_key_exists('order_by_release_date', $filtros)) {

            foreach ($filtros as $order => $dir) {

                switch ($order) {
                    case 'order_by_release_date':
                        $retorno->orderBy("movies.release_date", $dir ?: 'asc');
                        break;
                }
            }
        }

        return $retorno;
    }
}
