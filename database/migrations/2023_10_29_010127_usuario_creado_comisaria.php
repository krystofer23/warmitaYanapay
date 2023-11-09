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
        Schema::create('usuario_creado_comisaria', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('id_victima');
            $table->unsignedBigInteger('id_comisaria');

            $table->timestamps();

            $table->foreign('id_victima')->references('id')->on('usuario_victima');
            $table->foreign('id_comisaria')->references('id')->on('usuario_comisaria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_creado_comisaria');
    }
};
