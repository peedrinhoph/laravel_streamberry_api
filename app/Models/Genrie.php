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
}
