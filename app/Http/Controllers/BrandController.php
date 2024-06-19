<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request){
            $texto = $request->texto;
            $marcas = Brand::where('estado', 'VIGENTE')
                                ->where('nombre', 'like', '%'.$texto.'%')
                                ->orderBy('id', 'DESC')
                                ->paginate(10);

            return view('marca.index', compact('marcas', 'texto'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $marca = new Brand();
        if($request){
            $marca->nombre = strtoupper($request->nombre);
            $marca->estado = "VIGENTE";
            $marca->save();

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
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        if($request){
            $marca = Brand::findOrFail($id);
            $marca->nombre = strtoupper($request->nombre);
            $marca->estado = $request->estado;
            $marca->update();

            return back()->with('status', 'Se ha actualizado correctamente.');
        }
        else{
            return back()->with('statusError', 'Error al intentar actualizar.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if($id > 0){
            $marca = Brand::findOrFail($id);
            $marca->estado = "NO VIGENTE";
            $marca->update();

            return back()->with('status', 'La marca fué anulada correctamente.');
        }
        else{
            return back()->with('statusError', 'Error al intentar anular la marca.');
        }
    }
}
