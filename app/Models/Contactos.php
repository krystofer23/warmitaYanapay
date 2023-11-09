<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactos extends Model
{
    use HasFactory;
    protected $fillable = ['id_victima', 'id_detalle_contacto'] ;
    protected $table = 'contactos';
}
