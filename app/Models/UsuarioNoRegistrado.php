<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioNoRegistrado extends Model
{
    use HasFactory;
    protected $table = 'usuario_no_registrado';
    protected $fillable = ['id_comisaria', 'dni', 'nombre', 'apellido', 'celular', 'direccion', 'correo'];
}
