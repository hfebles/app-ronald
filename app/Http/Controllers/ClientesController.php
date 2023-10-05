<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;

use function Laravel\Prompts\table;

class ClientesController extends Controller
{
    public function index()
    {

        $clientes = Clientes::paginate(
            5
        );
        return view('clientes.index', compact('clientes'));
    }


    public function create()
    {

        return view('clientes.create');
    }

    public function store(Request $request)
    {

        $cliente = new Clientes();
        $cliente->name = strtoupper($request->name);
        $cliente->rif = strtoupper($request->rif);
        $cliente->address = strtoupper($request->address);
        $cliente->ag = (isset($request->ag) ? $request->ag : 0);
        $cliente->percent = (isset($request->percent) ? $request->percent : 0);
        $cliente->phone = $request->phone;
        $cliente->mail = $request->mail;
        $cliente->save();

        return redirect()->route('clientes.index');
    }

    public function eliminar(Request $request)
    {
        $eliminado = Clientes::where('id', $request->id)->delete();

        if ($eliminado) {
            return response()->json(['message' => 'success', 'status' => 200]);
        } else {
            return response()->json(['message' => 'error', 'status' => 400]);
        }

        return $eliminado;
    }


    public function consulta_rif(Request $request)
    {

        // return $request;

        $consulta = Clientes::where('rif', '=', $request->rif)->get();

        // return $consulta;


        if (count($consulta) > 0) {
            return response()->json(['message' => 'error', 'status' => 400, 'data' => $consulta[0]]);
        } else {
            return response()->json(['message' => 'success', 'status' => 200]);
        }
    }

    public function edit($id)
    {
        $cliente = Clientes::find($id);
        return response()->json(['message' => 'success', 'status' => 200, 'rif' => $cliente->rif]);
    }


    public function update(Request $request, $id)
    {

        $cliente = Clientes::find($id);
        $cliente->name = strtoupper($request->name);
        $cliente->rif = strtoupper($request->rif);
        $cliente->address = strtoupper($request->address);
        $cliente->phone = $request->phone;
        $cliente->mail = $request->mail;
        $cliente->save();

        return redirect()->route('clientes.index');
    }
}
