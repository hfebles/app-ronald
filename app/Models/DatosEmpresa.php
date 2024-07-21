<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DatosEmpresa extends Model
{
    use HasFactory;

    protected $fillable = ['nro_correlativo'];
    public function retenciones(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    public static function getCorrelativo($empresa_id)
    {
        return self::find($empresa_id)->nro_correlativo;
    }

    public static function updateCorrelativo($empresa_id, $nro_correlativo)
    {
        return self::find($empresa_id)->update(['nro_correlativo' => $nro_correlativo]);
    }
}
