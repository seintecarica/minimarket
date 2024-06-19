<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request){
            $texto = $request->texto;
            $categorias = Category::where('estado', 'VIGENTE')
                                ->where('nombre', 'like', '%'.$texto.'%')
                                ->orderBy('id', 'DESC')
                                ->paginate(10);

            return view('categoria.index', compact('categorias', 'texto'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categoria = new Category();
        if($request){
            $categoria->nombre = strtoupper($request->nombre);
            $categoria->estado = "VIGENTE";
            $categoria->save();

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
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        if($request){
            $categoria = Category::findOrFail($id);
            $categoria->nombre = strtoupper($request->nombre);
            $categoria->estado = $request->estado;
            $categoria->update();

            return back()->with('status', 'Se ha actualizado correctamente.');
        }
        else{
            return back()->with('statusError', 'Error al intentar actualizar.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if($id > 0){
            $categoria = Category::findOrFail($id);
            $categoria->estado = "NO VIGENTE";
            $categoria->update();

            return back()->with('status', 'La categoría fué anulada correctamente.');
        }
        else{
            return back()->with('statusError', 'Error al intentar anular la categoría.');
        }
    }
}
