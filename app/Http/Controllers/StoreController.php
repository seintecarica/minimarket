<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request){
            $texto = $request->texto;
            $usuarios = User::all();
            $bodegas = Store::where('estado', 'VIGENTE')
                                ->where('nombre', 'like', '%'.$texto.'%')
                                ->orderBy('nombre', 'ASC')
                                ->paginate(10);

            return view('bodega.index', compact('bodegas', 'usuarios', 'texto'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $bodega = new Store();
        if($request){
            $bodega->nombre = strtoupper($request->nombre);
            $bodega->movil = $request->movil;
            $bodega->responsable_id = $request->usuario_id;
            $bodega->observacion = $request->observacion;
            $bodega->estado = "VIGENTE";
            $bodega->save();

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
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        if($request){
            $bodega = Store::findOrFail($id);
            $bodega->nombre = strtoupper($request->nombre);
            $bodega->movil = $request->movil;
            $bodega->responsable_id = $request->usuario_id;
            $bodega->observacion = $request->observacion;
            $bodega->estado = $request->estado;
            $bodega->update();

            return back()->with('status', 'Se ha actualizado correctamente.');
        }
        else{
            return back()->with('statusError', 'Error al intentar actualizar.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Store $store)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if($id > 0){
            $bodega = Store::findOrFail($id);
            $bodega->estado = "NO VIGENTE";
            $bodega->update();

            return back()->with('status', 'La bodega fué anulada correctamente.');
        }
        else{
            return back()->with('statusError', 'Error al intentar anular la bodega.');
        }
    }
}
