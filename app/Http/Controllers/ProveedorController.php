<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $clientes = Proveedor::paginate(5);
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('proveedores.create');
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
        return redirect()->away(redirect()->getUrlGenerator()->previous());
    }

    public function eliminar(Request $request)
    {
        $eliminado = Proveedor::where('id', $request->id)->delete();

        if ($eliminado) {
            return response()->json(['message' => 'success', 'status' => 200]);
        }
        return response()->json(['message' => 'error', 'status' => 400]);

        return $eliminado;
    }

    public function consulta_rif(Request $request)
    {
        $consulta = Proveedor::where('rif', '=', $request->rif)->get();

        if (count($consulta) > 0) {
            return response()->json(['message' => 'error', 'status' => 400, 'data' => $consulta[0]]);
        }
        return response()->json(['message' => 'success', 'status' => 200]);
    }

    public function edit($id)
    {
        $cliente = Proveedor::find($id);
        return response()->json(['message' => 'success', 'status' => 200, 'rif' => $cliente->rif]);
    }

    public function update(Request $request, $id)
    {
        $cliente = Proveedor::find($id);
        $cliente->name = strtoupper($request->name);
        $cliente->rif = strtoupper($request->rif);
        $cliente->address = strtoupper($request->address);
        $cliente->phone = $request->phone;
        $cliente->email = $request->email;
        $cliente->save();

        return redirect()->route('proveedor.index');
    }
}
