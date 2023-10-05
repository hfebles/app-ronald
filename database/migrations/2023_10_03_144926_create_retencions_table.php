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
        Schema::create('retencions', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('client_id');
            $table->string('nro_factura');
            $table->string('nro_control');
            $table->string('nro_comprobante')->nullable();
            $table->date('fecha_factura');
            $table->double('monto', 20, 2);
            $table->tinyInteger('empresa_id');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retencions');
    }
};
