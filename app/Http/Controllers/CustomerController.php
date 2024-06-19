<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Store;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request){
            $texto = $request->texto;
            $bodegas = Store::where('estado', 'VIGENTE')
                            ->orderBy('nombre', 'ASC')->get();

            $clientes = Customer::where('estado', 'VIGENTE')
                                ->where('razon_social', 'like', '%'.$texto.'%')
                                ->orderBy('razon_social', 'ASC')
                                ->paginate(10);

            return view('cliente.index', compact('clientes', 'bodegas', 'texto'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $cliente = new Customer();
        if($request){
            $cliente->rut = $request->rut;
            $cliente->bodega_id = $request->bodega_id;
            $cliente->razon_social = $request->razon;
            $cliente->contacto = $request->contacto;
            $cliente->telefono = $request->telefono;
            $cliente->direccion = $request->direccion;
            $cliente->estado = "VIGENTE";
            $cliente->save();

            return back()->with('status', 'Se ha registrado correctamente.');
        }
        else{
            return back()->with('statusError', 'Error al intentar registrar.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        if($request){
            $cliente = Customer::findOrFail($id);
            $cliente->rut = $request->rut;
            $cliente->bodega_id = $request->bodega_id;
            $cliente->razon_social = $request->razon;
            $cliente->contacto = $request->contacto;
            $cliente->telefono = $request->telefono;
            $cliente->direccion = $request->direccion;
            $cliente->estado = $request->estado;
            $cliente->update();

            return back()->with('status', 'Se ha actualizado correctamente.');
        }
        else{
            return back()->with('statusError', 'Error al intentar actualizar.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if($id > 0){
            $cliente = Customer::findOrFail($id);
            $cliente->estado = "NO VIGENTE";
            $cliente->update();

            return back()->with('status', 'El cliente fué anulado correctamente.');
        }
        else{
            return back()->with('statusError', 'Error al intentar anular al cliente.');
        }
    }
}
