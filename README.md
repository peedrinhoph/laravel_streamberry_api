# API Descrição

Esta API foi construída usando Laravel 10 e fornece várias rotas para gerenciar gêneros, filmes, avaliações e streaming de um acervo de filmes.

# API Docs

Documentação completa REST API: https://documenter.getpostman.com/view/7533608/2s9Ykoc1FD

# Requisitos

```
PHP = ^8.2.x
Composer
Banco de dados MYSQL
```

# Configurações
- Clone o repositório

```
git clone https://github.com/peedrinhoph/laravel_streamberry_api.git ./
```

- Configure o banco de dados no arquivo .env renomeando .env.example para .env e atribua suas credencias de acesso a base de dados
```
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
## No diretório do projeto 
- Execute o comando `composer install` para instalar as dependências do projeto
- Execute o comando `php artisan key:generate` para configurar a chave do sistema
- Execute o comando `php artisan migrate` para fazer criação das tabelas no banco de dados
- Execute o comando `php artisan db:seed` para inicializar alguns registros para o sistema funcionar, incluindo o usuário e senha para autenticação da API (dados que constam na documentação)

## Inicializando o sistema com artisan

```
php artisan serve
```

## Testes implementados no Endpoint de Movie

- Necessário fazer o login para usar o `plainTextToken` no header das requisições de teste.

![Alt text](/imgGit/test.png "Optional title")