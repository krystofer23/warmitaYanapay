<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteAlertas extends Model
{
    use HasFactory;
    protected $table = 'reporte_alertas';
    protected $fillable = ['id_alerta', 'id_victima', 'status'];
}
