<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioVictima extends Model
{
    use HasFactory;
    protected $table = 'usuario_victima';
    protected $fillable = ['dni', 'nombre', 'apellido', 'celular', 'direccion', 'correo', 'clave'];
}
