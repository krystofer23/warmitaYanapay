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
        Schema::create('denuncia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_comisaria');
            $table->string('id_victima');

            $table->string('lugar');
            $table->longText('descripcion');
            $table->string('prueba_media');

            $table->timestamps();

            $table->foreign('id_comisaria')->references('id')->on('usuario_comisaria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denuncia');
    }
};
