<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request){
            $texto = $request->texto;
            $unidades = Unit::where('estado', 'VIGENTE')
                                ->where('nombre', 'like', '%'.$texto.'%')
                                ->orderBy('id', 'DESC')
                                ->paginate(10);

            return view('unidad.index', compact('unidades', 'texto'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $unidad = new Unit();
        if($request){
            $unidad->nombre = strtoupper($request->nombre);
            $unidad->estado = "VIGENTE";
            $unidad->save();

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
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        if($request){
            $unidad = Unit::findOrFail($id);
            $unidad->nombre = strtoupper($request->nombre);
            $unidad->estado = $request->estado;
            $unidad->update();

            return back()->with('status', 'Se ha actualizado correctamente.');
        }
        else{
            return back()->with('statusError', 'Error al intentar actualizar.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if($id > 0){
            $unidad = Unit::findOrFail($id);
            $unidad->estado = "NO VIGENTE";
            $unidad->update();

            return back()->with('status', 'La unidad fué anulada correctamente.');
        }
        else{
            return back()->with('statusError', 'Error al intentar anular la unidad.');
        }
    }
}
