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
        Schema::create('evidencia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_victima');

            $table->longText('descripcion');
            $table->string('evidencia_media');
            $table->longText('datos_agresor');

            $table->timestamps();
            $table->foreign('id_victima')->references('id')->on('usuario_victima');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencia');
    }
};
