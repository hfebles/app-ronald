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
            $table->foreignId('proveedor_id')->constrained('proveedors');
            $table->foreignId('empresa_id')->constrained('datos_empresas');
            $table->tinyInteger('report_id');
            $table->integer('nro_factura')->unique();
            $table->string('nro_control');
            $table->string('nro_comprobante');
            $table->date('fecha_factura');
            $table->double('monto', 20, 2);
            $table->string('ruta')->nullable();
            $table->text('b64')->nullable();
            $table->boolean('status')->default(1); // [0 => inactivo/anulado, 1 => activo]
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
