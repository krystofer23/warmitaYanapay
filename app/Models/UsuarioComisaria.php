<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioComisaria extends Model
{
    use HasFactory;
    protected $table = 'usuario_comisaria';
    protected $fillable = ['nombre', 'direccion', 'correo', 'clave', 'status'];
}
