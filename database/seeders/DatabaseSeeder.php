<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    use WithoutModelEvents;

    public function run(): void
    {
        // \App\Models\User::factory(1)->create();
        // \App\Models\Movie::factory(5)->create();

        \App\Models\User::factory()->create([
            'name' => 'Pedro Henrique Pereira',
            'email' => 'pedro23henrique@hotmail.com',
            'password' => Hash::make('123'),
        ]);

        \App\Models\Movie::factory()->create([
            'title' => 'Velozes & Furiosos 10',
            'description' => 'Dom Toretto e sua família precisam lidar com o adversário mais letal que já enfrentaram.',
            'release_date' => '2023-05-18',
        ]);

        \App\Models\Movie::factory()->create([
            'title' => 'Velozes & Furiosos 9',
            'description' => 'Dominic Toretto e Letty vivem uma vida pacata ao lado do filho. Mas eles logo são ameaçados pelo passado de Dom: seu irmão desaparecido Jakob, que retorna e está trabalhando ao lado de Cipher.',
            'release_date' => '2021-06-24',
        ]);

        \App\Models\Movie::factory()->create([
            'title' => 'Velozes & Furiosos 8',
            'description' => 'Depois da aposentadoria de Brian e Mia, Dom e Letty aproveitam a lua de mel e levam uma vida pacata e normal. Mas a adrenalina do passado volta com tudo quando uma mulher misteriosa obriga Dom a retornar ao mundo do crime e da velocidade.',
            'release_date' => '2017-04-13',
        ]);

        \App\Models\Movie::factory()->create([
            'title' => 'Velozes & Furiosos 7',
            'description' => 'Um agente do governo oferece ajuda para cuidar de Shaw em troca de Dom e o grupo resgatar um "hacker" sequestrado. Dessa vez, não se trata apenas de velocidade: a corrida é pela sobrevivência.',
            'release_date' => '2015-04-02',
        ]);

        \App\Models\Movie::factory()->create([
            'title' => 'Velozes & Furiosos 6',
            'description' => 'Desde que o golpe de Dom e Brian no Rio de Janeiro deixou o grupo com 100 milhões de dólares, a equipe se espalhou pelo mundo.',
            'release_date' => '2013-05-24',
        ]);


        \App\Models\Genrie::factory()->create(['description' => 'Ação']);
        \App\Models\Genrie::factory()->create(['description' => 'Terror']);
        \App\Models\Genrie::factory()->create(['description' => 'Suspense']);
        \App\Models\Genrie::factory()->create(['description' => 'Drama']);
        \App\Models\Genrie::factory()->create(['description' => 'Romantico',]);


        \App\Models\MovieGenre::factory()->create(['movie_id' => '1', 'genre_id' => '1']);
        \App\Models\MovieGenre::factory()->create(['movie_id' => '1', 'genre_id' => '2']);
        \App\Models\MovieGenre::factory()->create(['movie_id' => '1', 'genre_id' => '3']);
        \App\Models\MovieGenre::factory()->create(['movie_id' => '2', 'genre_id' => '1']);
        \App\Models\MovieGenre::factory()->create(['movie_id' => '2', 'genre_id' => '4']);
        \App\Models\MovieGenre::factory()->create(['movie_id' => '2', 'genre_id' => '5']);
        \App\Models\MovieGenre::factory()->create(['movie_id' => '3', 'genre_id' => '1']);
        \App\Models\MovieGenre::factory()->create(['movie_id' => '4', 'genre_id' => '1']);
        \App\Models\MovieGenre::factory()->create(['movie_id' => '5', 'genre_id' => '1']);


        \App\Models\Streaming::factory()->create(['name' => 'Amazon Prime Videos']);
        \App\Models\Streaming::factory()->create(['name' => 'Netflix']);


        \App\Models\StreamingMovie::factory()->create(['movie_id' => '1', 'streaming_id' => '1']);
        \App\Models\StreamingMovie::factory()->create(['movie_id' => '1', 'streaming_id' => '2']);
        \App\Models\StreamingMovie::factory()->create(['movie_id' => '2', 'streaming_id' => '1']);
        \App\Models\StreamingMovie::factory()->create(['movie_id' => '3', 'streaming_id' => '1']);
        \App\Models\StreamingMovie::factory()->create(['movie_id' => '4', 'streaming_id' => '2']);
        \App\Models\StreamingMovie::factory()->create(['movie_id' => '5', 'streaming_id' => '2']);


        \App\Models\MovieRating::factory()->create(['streaming_movie_id' => '1', 'user_id' => '1', 'value' => '5', 'comment' => 'Muito bom']);
        \App\Models\MovieRating::factory()->create(['streaming_movie_id' => '2', 'user_id' => '1', 'value' => '3', 'comment' => 'Bom']);
        \App\Models\MovieRating::factory()->create(['streaming_movie_id' => '4', 'user_id' => '1', 'value' => '5', 'comment' => 'Muito bom']);
        \App\Models\MovieRating::factory()->create(['streaming_movie_id' => '5', 'user_id' => '1', 'value' => '3', 'comment' => 'Bom']);
    }
}
