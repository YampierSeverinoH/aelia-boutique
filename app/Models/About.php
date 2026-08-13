<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'trayectoria',
        'anios',
        'patentes',
        'paises',
        'imagen_1',
        'imagen_2',
        'imagen_3',
        'imagen_4',
        'mision',
        'vision',
        'valores',
        'imagen_talento',
        'titulo_talento',
        'descripcion_talento',
        'subtitulo_1',
        'subtitulo_1_descripcion',
        'subtitulo_2',
        'subtitulo_2_descripcion',
    ];
}
