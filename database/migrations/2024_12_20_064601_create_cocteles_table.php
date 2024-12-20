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
        Schema::create('cocteles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 191); // Columna para el nombre del cóctel
            $table->text('instrucciones');
            $table->text('url_imagen');
            $table->json('ingredientes');
            $table->integer('idCloud');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cocteles');
    }
};
