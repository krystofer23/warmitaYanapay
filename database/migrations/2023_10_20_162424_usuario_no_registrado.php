<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuario_no_registrado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_comisaria');

            $table->string('dni');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('celular');
            $table->string('direccion');
            $table->string('correo')->unique();

            $table->timestamps();

            $table->foreign('id_comisaria')->references('id')->on('usuario_comisaria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_no_registrado');
    }
};