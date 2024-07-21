<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DatosEmpresa;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function consulta_rif(Request $request)
    {
        $consulta = Proveedor::where('rif', '=', $request->rif)->get();

        if (count($consulta) > 0) {
            return response()->json(['message' => 'error', 'status' => 1, 'data' => $consulta[0]], 200);
        }
        return response()->json(['message' => 'success', 'status' => 0], 200);
    }

    public function store(Request $request)
    {
        $proveedor = new Proveedor();
        $proveedor->name = strtoupper($request->name);
        $proveedor->rif = strtoupper($request->rif);
        $proveedor->address = strtoupper($request->address);
        $proveedor->ag = ($request->ag ?? 0);
        $proveedor->percent = ($request->percent ?? 0);
        $proveedor->phone = $request->phone;
        $proveedor->email = $request->email;
        $proveedor->save();

        return response()->json(['status' => 1, 'message' => 'Proveedor registrado con exito'], 200);
    }

    public function retencion_proveedor($id)
    {
        $prove = Proveedor::find($id)->retencion;

        return response()->json($prove, 200);
    }

    public function getEmpresaDatos()
    {
        $empresas = DatosEmpresa::all();

        return response()->json($empresas, 200);
    }

    public function listar()
    {
        $empresas = Proveedor::all();

        return response()->json($empresas, 200);
    }
}
