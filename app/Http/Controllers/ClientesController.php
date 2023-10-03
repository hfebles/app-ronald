<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function index()
    {

        $clientes = Clientes::all();
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
}
