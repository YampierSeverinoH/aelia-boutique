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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->text('descripcion');
            $table->string('ruc')->nullable();
            $table->string('direccion');
            $table->string('telefono');
            $table->string('correo'); // Public email
            $table->string('correo_notificaciones'); // Notification email
            $table->text('ubicacion'); // Google Maps embed/iframe
            $table->string('horario');
            $table->longText('terminos_condiciones')->nullable();
            $table->longText('politicas_privacidad')->nullable();
            $table->string('mensaje_cinta')->nullable();
            $table->string('link_facebook')->nullable();
            $table->string('link_instagram')->nullable();
            $table->string('link_tiktok')->nullable();
            $table->string('link_youtube')->nullable();
            $table->string('link_linkedin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
