<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Llaves extends Model
{
    use HasFactory;
    protected $talbe = 'llaves';
    protected $fillable = ['llave_acceso', 'status'];
}
