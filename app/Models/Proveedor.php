<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    use HasFactory;

    public function retencion(): HasMany
    {
        return $this->hasMany(Retencion::class);
    }

    public static function getProveedor($rif)
    {
        return self::select('id')->where('rif', '=', $rif)->get()[0]->id;
    }

    public function empresa(): HasMany
    {
        return $this->hasMany(DatosEmpresa::class, 'proveedor_id');
    }
}
