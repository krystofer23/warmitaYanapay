<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    use HasFactory;
    protected $fillable = ['id_victima', 'descripcion', 'evidencia_media', 'datos_agresor'];
    protected $table = 'evidencia';
}
