<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleContacto extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'apellido', 'celular', 'dirrecion'] ;
    protected $table = 'detalle_contacto';
}
