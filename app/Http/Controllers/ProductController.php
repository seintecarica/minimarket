<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;
use PDF;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request){
            $texto = $request->texto;
            $marcas = Brand::where('estado', 'VIGENTE')
                            ->orderBy('nombre')
                            ->get();
            $categorias = Category::where('estado', 'VIGENTE')
                            ->orderBy('nombre')
                            ->get();
            $unidades = Unit::where('estado', 'VIGENTE')->get();
            $origen = "producto";
            $productos = Product::where('estado', 'VIGENTE')
                                ->where('nombre', 'like', '%'.$texto.'%')
                                ->orderBy('nombre', 'ASC')
                                ->paginate(10);

            return view('producto.index', compact('productos','marcas', 'categorias', 'unidades', 'texto', 'origen'));
        }
    }

    public function pdf(Request $request){
        $categoria_id = $request->categoria_id_sel;
        $marca_id = $request->marca_id_sel;
        if($categoria_id > 0){
            if($marca_id > 0){
                $productos = Product::where('estado', 'VIGENTE')
                        ->where('categoria_id', $categoria_id)
                        ->where('marca_id', $marca_id)
                        ->orderBy('categoria_id')
                        ->orderBy('marca_id')
                        ->orderBy('nombre')
                        ->get();
            }
            else{ //Todas las marcas
                $productos = Product::where('estado', 'VIGENTE')
                        ->where('categoria_id', $categoria_id)
                        ->orderBy('categoria_id')
                        ->orderBy('marca_id')
                        ->orderBy('nombre')
                        ->get();
            }
        }
        else{// Todas las categorias
            if($marca_id > 0){
                $productos = Product::where('estado', 'VIGENTE')
                        ->where('marca_id', $marca_id)
                        ->orderBy('categoria_id')
                        ->orderBy('marca_id')
                        ->orderBy('nombre')
                        ->get();
            }
            else{ //Todas las marcas
                $productos = Product::where('estado', 'VIGENTE')
                        ->orderBy('categoria_id')
                        ->orderBy('marca_id')
                        ->orderBy('nombre')
                        ->get();
            }
        }

        $fecha = date('d-m-Y', strtotime(date('d-m-Y')));
        $pdf = PDF::loadView('producto.pdf', ['productos'=>$productos, 'fecha'=>$fecha]);
        $pdf->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $origen)
    {
        $producto = new Product();
        if($request){
            $producto->nombre = strtoupper($request->nombre);
            $producto->codigo = $request->codigo;
            $producto->marca_id = $request->marca_id;
            $producto->categoria_id = $request->categoria_id;
            $producto->unidad_id = $request->unidad_id;
            //$producto->unid_caja = $request->unid_caja;
            //$producto->precio = $request->precio;
            $producto->precio_unid = $request->precio_unid;
            //$producto->precio_oferta = $request->precio_oferta;
            $producto->min = $request->min;
            $producto->usuario_id = auth()->user()->id;
            $producto->estado = "VIGENTE";
            $producto->save();

            if($origen == 'producto'){
                return back()->with('status', 'Se ha registrado correctamente.');
            }
            elseif($origen == 'factura'){
                return redirect()->route("factura.create")->withInput();
            }
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
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        if($request){
            $producto = Product::findOrFail($id);
            $producto->nombre = $request->nombre;
            $producto->marca_id = $request->marca_id;
            $producto->categoria_id = $request->categoria_id;
            $producto->unidad_id = $request->unidad_id;
            //$producto->unid_caja = $request->unid_caja;
            //$producto->precio = $request->precio;
            $producto->precio_unid = $request->precio_unid;
            //$producto->precio_oferta = $request->precio_oferta;
            $producto->min = $request->min;
            $producto->usuario_id = auth()->user()->id;
            $producto->estado = $request->estado;
            $producto->update();

            return back()->with('status', 'Se ha actualizado correctamente.');
        }
        else{
            return back()->with('statusError', 'Error al intentar actualizar.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if($id > 0){
            $producto = Product::findOrFail($id);
            $producto->estado = "NO VIGENTE";
            $producto->update();

            return back()->with('status', 'El producto fué anulado correctamente.');
        }
        else{
            return back()->with('statusError', 'Error al intentar anular el producto.');
        }
    }
}
