# API Laravel

Esta API foi construída usando Laravel e fornece várias rotas para gerenciar gêneros, filmes, avaliações e streaming.

## Rotas da API

Aqui estão alguns exemplos de como usar as rotas da API:

### Autenticação
- Login: `POST api/v1/login`
```bash
curl -X POST -H "Content-Type: application/json" -d '{"username":"example", "password":"password"}' http://localhost/api/v1/login
```

- Logout: `POST api/v1/login`
```bash
curl -X POST -H "Authorization: Bearer {token}" http://localhost/api/v1/logout
```

### Gêneros

- Listar gêneros: `GET|HEAD api/v1/genre/list`
- Listar filmes de um gênero: `GET|HEAD api/v1/genre/movies/list`
- Criar um gênero: `POST api/v1/genre/store`
- Atualizar um gênero: `PUT api/v1/genre/{genre_id}/update`
- Deletar um gênero: `DELETE api/v1/genre/{genre_id}/delete`
- Encontrar um gênero: `GET|HEAD api/v1/genre/{genre_id}/find`
- Encontrar um filme de um gênero: `GET|HEAD api/v1/genre/{genre_id}/movie/find`

## Filmes

- Listar filmes: `GET|HEAD api/v1/movie/list`
- Criar um filme: `POST api/v1/movie/store`
- Deletar um filme: `DELETE api/v1/movie/{movie_id}/delete`
- Encontrar um filme: `GET|HEAD api/v1/movie/{movie_id}/find`
- Avaliar um filme: `POST api/v1/movie/{movie_id}/rating`
- Atualizar um filme: `PUT api/v1/movie/{movie_id}/update`
- Listar filmes avaliados: `GET|HEAD api/v1/movies/rated/list`
- Encontrar um filme avaliado: `GET|HEAD api/v1/movie/rated/{movie_id}/find`

## Avaliações

- Listar avaliações: `GET|HEAD api/v1/rating/list`
- Deletar uma avaliação: `DELETE api/v1/rating/{rate_id}/delete`
- Encontrar uma avaliação: `GET|HEAD api/v1/rating/{rate_id}/find`
- Atualizar uma avaliação: `PUT api/v1/rating/{rate_id}/update`

## Streaming

- Listar streaming: `GET|HEAD api/v1/streaming/list`
- Vincular um filme ao streaming: `POST api/v1/streaming/movie/vincule`
- Criar um streaming: `POST api/v1/streaming/store`
- Deletar um streaming: `DELETE api/v1/streaming/{streaming_id}/delete`

Gere uma documentação de API para estas rotas do laravel

colocar as rotas

Você pode me mostrar um exemplo de uso dessas rotas?