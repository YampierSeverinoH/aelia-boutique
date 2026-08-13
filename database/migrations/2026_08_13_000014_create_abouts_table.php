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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->text('trayectoria');
            $table->string('anios');
            $table->string('patentes');
            $table->string('paises');
            $table->string('imagen_1')->nullable();
            $table->string('imagen_2')->nullable();
            $table->string('imagen_3')->nullable();
            $table->string('imagen_4')->nullable();
            $table->text('mision');
            $table->text('vision');
            $table->text('valores');
            $table->string('imagen_talento')->nullable();
            $table->string('titulo_talento');
            $table->text('descripcion_talento');
            $table->string('subtitulo_1');
            $table->text('subtitulo_1_descripcion');
            $table->string('subtitulo_2');
            $table->text('subtitulo_2_descripcion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
