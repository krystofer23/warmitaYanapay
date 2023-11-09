<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioCreadoComisaria extends Model
{
    use HasFactory;
    protected $table = 'usuario_creado_comisaria';
    protected $fillable = ['id_victima', 'id_comisaria'];
}
