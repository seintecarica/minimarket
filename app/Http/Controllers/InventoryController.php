<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = $request->texto;
        $criterio = $request->criterio;
        $categorias = Category::where('estado', 'VIGENTE')
                            ->get();
        if($criterio == "PRODUCTO"){
            $inventario = DB::table('inventories as in')
                        ->join('products as pro', 'in.producto_id', '=', 'pro.id')
                        ->join('stores as bo','in.bodega_id','=','bo.id')
                        ->join('brands as ma','pro.marca_id','=','ma.id')
                        ->join('categories as cat','pro.categoria_id','=','cat.id')
                        ->select('bo.nombre as nombre_bodega', 'cat.nombre as nombre_categoria', 'ma.nombre as nombre_marca', 'pro.nombre as nombre_producto','in.tratamiento','in.cantidad', 'pro.min')
                        ->where('pro.nombre','LIKE','%'.$texto.'%')
                        ->orderBy('bo.nombre','ASC')
                        ->orderBy('pro.nombre', 'ASC')
                        ->paginate(15);
        }
        elseif($criterio == "BODEGA"){
            $inventario = DB::table('inventories as in')
                        ->join('products as pro', 'in.producto_id', '=', 'pro.id')
                        ->join('stores as bo','in.bodega_id','=','bo.id')
                        ->join('brands as ma','pro.marca_id','=','ma.id')
                        ->join('categories as cat','pro.categoria_id','=','cat.id')
                        ->select('bo.nombre as nombre_bodega', 'cat.nombre as nombre_categoria', 'ma.nombre as nombre_marca', 'pro.nombre as nombre_producto','in.tratamiento','in.cantidad', 'pro.min')
                        ->where('bo.nombre','LIKE','%'.$texto.'%')
                        ->orderBy('bo.nombre','ASC')
                        ->orderBy('pro.nombre', 'ASC')
                        ->paginate(15);
        }
        elseif($criterio == "CATEGORIA"){
            $inventario = DB::table('inventories as in')
                        ->join('products as pro', 'in.producto_id', '=', 'pro.id')
                        ->join('stores as bo','in.bodega_id','=','bo.id')
                        ->join('brands as ma','pro.marca_id','=','ma.id')
                        ->join('categories as cat','pro.categoria_id','=','cat.id')
                        ->select('bo.nombre as nombre_bodega', 'cat.nombre as nombre_categoria', 'ma.nombre as nombre_marca', 'pro.nombre as nombre_producto','in.tratamiento','in.cantidad', 'pro.min')
                        ->where('cat.nombre','LIKE','%'.$texto.'%')
                        ->orderBy('bo.nombre','ASC')
                        ->orderBy('pro.nombre', 'ASC')
                        ->paginate(15);
        }
        else{
            $inventario = DB::table('inventories as in')
                        ->join('products as pro', 'in.producto_id', '=', 'pro.id')
                        ->join('stores as bo','in.bodega_id','=','bo.id')
                        ->join('brands as ma','pro.marca_id','=','ma.id')
                        ->join('categories as cat','pro.categoria_id','=','cat.id')
                        ->select('bo.nombre as nombre_bodega', 'cat.nombre as nombre_categoria', 'ma.nombre as nombre_marca', 'pro.nombre as nombre_producto','in.tratamiento','in.cantidad', 'pro.min')
                        ->orderBy('bo.nombre','ASC')
                        ->orderBy('pro.nombre', 'ASC')
                        ->paginate(15);
        }

        return view('inventario.index', compact('inventario', 'texto', 'criterio', 'categorias'));
    }

    public function pdf(Request $request){
        if($request->categoria_id == 0){
            $inventario = Inventory::select('stores.nombre as nombre_bodega', 'categories.nombre as nombre_categoria', 'brands.nombre as nombre_marca', 'products.nombre as nombre_producto', 'inventories.tratamiento', 'inventories.cantidad', 'products.min')
                                ->join('stores', 'inventories.bodega_id', '=','stores.id')
                                ->join('products', 'inventories.producto_id','=','products.id')
                                ->join('brands','products.marca_id','=','brands.id')
                                ->join('categories','products.categoria_id','=','categories.id')
                                ->where('categories.estado', '=', 'VIGENTE')
                                ->orderBy('stores.nombre', 'ASC')
                                ->orderBy('categories.nombre', 'ASC')
                                ->orderBy('brands.nombre', 'ASC')
                                ->orderBy('products.nombre', 'ASC')
                                ->orderBy('tratamiento', 'ASC')
                                ->get();
        }
        else{
            $categoria = Category::find($request->categoria_id);
            $inventario = Inventory::select('stores.nombre as nombre_bodega', 'categories.nombre as nombre_categoria', 'brands.nombre as nombre_marca', 'products.nombre as nombre_producto', 'inventories.tratamiento', 'inventories.cantidad', 'products.min')
                                ->join('stores', 'inventories.bodega_id', '=','stores.id')
                                ->join('products', 'inventories.producto_id','=','products.id')
                                ->join('brands','products.marca_id','=','brands.id')
                                ->join('categories','products.categoria_id','=','categories.id')
                                ->where('categories.nombre', 'LIKE', '%'.$categoria->nombre.'%')
                                ->orderBy('stores.nombre', 'ASC')
                                ->orderBy('categories.nombre', 'ASC')
                                ->orderBy('brands.nombre', 'ASC')
                                ->orderBy('products.nombre', 'ASC')
                                ->orderBy('tratamiento', 'ASC')
                                ->get();
        }
        

        $fecha = date('d / m / Y', strtotime(date('d-m-Y')));

        $pdf = PDF::loadView('inventario.pdf', ['inventario'=>$inventario, 'fecha'=>$fecha]);
        $pdf->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
