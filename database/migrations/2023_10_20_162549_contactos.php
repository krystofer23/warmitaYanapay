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
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_victima');
            $table->unsignedBigInteger('id_detalle_contacto');

            $table->timestamps();

            $table->foreign('id_victima')->references('id')->on('usuario_victima');
            $table->foreign('id_detalle_contacto')->references('id')->on('detalle_contacto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
