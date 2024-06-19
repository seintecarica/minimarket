<?php

namespace App\Http\Controllers;

use App\Models\DispatchGuide;
use App\Models\Store;
use App\Models\Brand;
use App\Models\Product;
use App\Models\DispatchDetailGuide;
use App\Models\Inventory;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DispatchGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request){
            $folio = trim($request->folio);
            $bodegas = Store::where('estado', 'VIGENTE')->get();
            $marcas = Brand::where('estado', 'VIGENTE')->get();
            //$facturas = DispatchGuides::all();
            $productos = Product::where('estado', 'VIGENTE')->get();

            $facturas = DB::table('dispatch_guides as d')
            ->join('stores as s', 'd.bodega_id', '=', 's.id')
            ->join('dispatch_detail_guides as dd','d.id','=','dd.guia_despacho_id')
            ->join('brands as b', 'd.marca_id', '=', 'b.id')
            ->join('users as u','d.usuario_id','=','u.id')
            ->select('d.id', 'd.folio', 'b.nombre', 'u.name', 'd.created_at', 'd.estado', DB::raw('sum(dd.cantidad * dd.costo_unit) as total'))
            ->where('d.folio', 'LIKE', '%'.$folio.'%')
            ->groupBy('d.id', 'd.folio', 'b.nombre', 'u.name', 'd.created_at', 'd.estado')
            ->orderBy('d.folio','desc')
            ->paginate(10);

            return view('factura.index', compact('facturas', 'bodegas', 'marcas', 'productos', 'folio'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bodegas = Store::where('estado', 'VIGENTE')->get();
        $marcas = Brand::where('estado', 'VIGENTE')->get();
        //$facturas = DispatchGuides::all();
        $productos = Product::where('estado', 'VIGENTE')->get();
        $categorias = Category::where('estado', 'VIGENTE')->get();
        $unidades = Unit::where('estado', 'VIGENTE')->get();
        $origen = "factura";

        return view('factura.create', compact('bodegas', 'marcas', 'productos', 'categorias', 'unidades', 'origen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $factura = new DispatchGuide();
            $factura->folio = $request->folio;
            $factura->bodega_id = $request->bodega_id;
            $factura->marca_id = $request->marca_id;
            $factura->usuario_id = auth()->user()->id;
            $factura->total_neto = $request->t_neto;
            $factura->total_iva = $request->t_iva;
            $factura->estado = "VIGENTE";
            $factura->save();

            $producto_id = $request->get('producto_id');
            $cantidad = $request->get('cantidad');
            $costo_unit = $request->get('costo_unit');

            $cont = 0;

            while($cont < count($producto_id)){
                $detalle = new DispatchDetailGuide();
                $detalle->guia_despacho_id = $factura->id;
                $detalle->producto_id = $producto_id[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->costo_unit = $costo_unit[$cont];
                $detalle->save();

                //CONSULTAR SI EXISTE EN INVENTARIO COMO CAJA
                $condiciones = [
                    ['bodega_id', '=', $request->bodega_id],
                    ['producto_id', '=', $producto_id[$cont]],
                    ['tratamiento', '=', 1]
                ];

                $prod_inventario = Inventory::where($condiciones)
                                        ->first();
                
                //EL PRODUCTO YA EXISTE EN BODEGA COMO CAJA Y SE SUMARA LA CANTIDAD
                if($prod_inventario){
                    $prod_inventario->cantidad = $prod_inventario->cantidad + $cantidad[$cont];
                    $prod_inventario->update();
                }
                else{ //EL PRODUCTO NO EXISTE EN BODEGA COMO CAJA Y SE INSERTARA
                    $inventario = new Inventory();
                    $inventario->bodega_id = $request->bodega_id;
                    $inventario->producto_id = $producto_id[$cont];
                    $inventario->tratamiento = 1; //UNITARIO
                    $inventario->cantidad = $cantidad[$cont];
                    $inventario->save();
                }

                $cont = $cont + 1;
            }

            DB::commit();
            //return back()->with('status', 'Se ha registrado correctamente.');
            return redirect()->route("factura.index")->with('status', 'Se ha registrado correctamente.');
        }catch(\Exception $e){
            DB::rollback();
            return back()->with('statusError', 'Ha ocurrido un problema con el registro.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $factura = DB::table('dispatch_guides as d')
        ->join('stores as s', 'd.bodega_id', '=', 's.id')
        ->join('dispatch_detail_guides as dd','d.id','=','dd.guia_despacho_id')
        ->join('brands as b', 'd.marca_id', '=', 'b.id')
        ->join('users as u','d.usuario_id','=','u.id')
        ->select('d.id', 'd.folio', 'b.nombre', 'u.name', 'd.created_at', 'd.estado', DB::raw('sum(dd.cantidad * dd.costo_unit) as total'))
        ->where('d.id', '=', $id)
        ->groupBy('d.id', 'd.folio', 'b.nombre', 'u.name', 'd.created_at', 'd.estado')
        ->first();

        $detalle = DB::table('dispatch_detail_guides as dd')
        ->join('products as p', 'dd.producto_id','=','p.id')
        ->select('p.nombre as producto', 'dd.cantidad', 'dd.costo_unit', '(dd.cantidad * dd.costo_unit) as subtotal')
        ->where('dd.guia_despacho_id', $id)
        ->get();

        //Convertir la página en PDF
        return view('pagina', compact('factura', 'detalle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DispatchGuide $dispatchGuide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DispatchGuide $dispatchGuide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DispatchGuide $dispatchGuide)
    {
        //
    }
}
