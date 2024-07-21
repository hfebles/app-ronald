<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Retencion extends Model
{
    use HasFactory;

    protected $fillable = ['nro_comprobante'];

    public function datos_empresa(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public static function getRetencion($id)
    {
        return self::select(
            'retencions.nro_factura',
            'retencions.nro_control',
            'retencions.nro_comprobante',
            'retencions.fecha_factura',
            'retencions.monto',
            'retencions.created_at',
            'proveedors.name',
            'proveedors.rif',
            'proveedors.address',
            'datos_empresas.name_empresa',
            'datos_empresas.rif_empresa',
            'datos_empresas.address_empresa'
        )
            ->where('retencions.id', '=', $id)
            ->join('proveedors', 'proveedors.id', '=', 'retencions.proveedor_id')
            ->join('datos_empresas', 'datos_empresas.id', '=', 'retencions.empresa_id')
            ->get()[0];
    }
}
