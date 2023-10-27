<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    use HasFactory;
    protected $table = 'denuncia';
    protected $fillable = ['id_comisaria', 'id_victima', 'lugar', 'descripcion', 'prueba_media'];
}
