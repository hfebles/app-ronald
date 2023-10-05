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
        Schema::create('datos_empresas', function (Blueprint $table) {
            $table->id();
            $table->string('name_empresa');
            $table->string('rif_empresa');
            $table->string('address_empresa');
            $table->string('telefono')->nullable();
            $table->string('mail')->nullable();
            $table->string('nro_correlativo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_empresas');
    }
};
