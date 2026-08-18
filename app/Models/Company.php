<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'imagen_bio',
        'descripcion',
        'ruc',
        'direccion',
        'telefono',
        'correo',
        'correo_notificaciones',
        'ubicacion',
        'horario',
        'terminos_condiciones',
        'politicas_privacidad',
        'mensaje_cinta',
        'link_facebook',
        'link_instagram',
        'link_tiktok',
        'link_youtube',
        'link_linkedin',
    ];
}
