<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablaEjemplo extends Model
{
    use HasFactory;

    protected $table = 'tabla_ejemplo';

    protected $fillable = [
        'nombre',
        'numero',
    ];
}
