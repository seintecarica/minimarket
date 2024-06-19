<?php

namespace App\Http\Controllers;

use App\Models\SalesDetail;
use App\Models\Store;
use App\Models\PaymentForm;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SalesDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fecha_ini = '';
        $fecha_fin = '';

        $folio = $request->folio;
        $bodega = Store::where('responsable_id', auth()->user()->id)
                        ->first();

        if(empty($request->start_date)){
            $fecha_ini = date('d-m-Y');
            $fecha_fin = date('d-m-Y');
            
        }
        else{
            $fecha_ini = $request->get('start_date');
            $fecha_fin = $request->get('end_date');
        }

        $ventas = SalesDetail::where('bodega_id', $bodega->id)
                            ->whereBetween('created_at', [$fecha_ini, $fecha_fin])
                            ->orderBy('id','DESC')
                            ->paginate(10);
        
        $pagos = PaymentForm::where('estado', 'VIGENTE')->get();
        $productos = Inventory::select('products.id', 'products.nombre', 'products.precio_unid', 'stores.nombre as bodega', 'inventories.cantidad')
                                ->join('products', 'inventories.producto_id', '=', 'products.id')
                                ->join('stores', 'inventories.bodega_id', '=', 'stores.id')
                                ->where('inventories.bodega_id', '=', $bodega->id)
                                ->where('inventories.cantidad', '>', 0)
                                ->where('inventories.tratamiento', 2)
                                ->get();
        $productos_caja = Inventory::select('inventories.id', 'products.nombre as nombre_producto', 'products.precio_unid', 'units.nombre', 'stores.nombre as bodega', 'inventories.cantidad', 'products.unid_caja')
        ->join('products', 'inventories.producto_id', '=', 'products.id')
        ->join('stores', 'inventories.bodega_id', '=', 'stores.id')
        ->join('units', 'products.unidad_id', '=', 'units.id')
        ->where('inventories.bodega_id', '=', $bodega->id)
        ->where('inventories.cantidad', '>', 0)
        ->where('inventories.tratamiento', 1)
        ->get();

        return view('venta_menor.index', compact('ventas', 'bodega', 'pagos', 'productos', 'folio', 'productos_caja', 'fecha_ini', 'fecha_fin'));
    }

    public function desglose(Request $request){
        if($request){
            $product_inventario = Inventory::find($request->inventario_id);
            $product_inventario->cantidad = $product_inventario->cantidad - 1;

            $prod_unitario = Inventory::where('producto_id', $product_inventario->producto_id)
                                        ->where('bodega_id', $product_inventario->bodega_id)
                                        ->where('tratamiento', 2)
                                        ->get();

            if($prod_unitario->count() == 0){ //Producto no encontrado, insertar
                $producto = Product::find($product_inventario->producto_id);
                $nuevo_prod_unit = new Inventory();
                $nuevo_prod_unit->bodega_id = $product_inventario->bodega_id;
                $nuevo_prod_unit->producto_id = $product_inventario->producto_id;
                $nuevo_prod_unit->tratamiento = 2;
                $nuevo_prod_unit->cantidad = $producto->unid_caja;
                $nuevo_prod_unit->save();
                return back()->with('status', 'El producto se ha desglosado correctamente.');
            }
            elseif($prod_unitario->count() == 1){ //Sumar al producto unitario ya existente cuando se desglosa
                $prod_unitario->cantidad = $prod_unitario->cantidad + $producto->unid_caja;
                $prod_unitario->update();
                return back()->with('status', 'El producto se ha desglosado correctamente.');
            }
            else{
                return back()->with('statusError', 'Ocurrió un problema al intentar desglosar..');
            }
            
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try{
            DB::beginTransaction();
            $producto_id = $request->get('producto_id');
            $cantidad = $request->get('cantidad');
            $precio_unit = $request->get('precio_unit');

            $cont = 0;
            while($cont < count($producto_id)){
                $venta = new SalesDetail();
                $venta->bodega_id = $request->bodega_id;
                $venta->pago_id = $request->pago_id;
                $venta->usuario_id = auth()->user()->id;
                $venta->producto_id = $producto_id[$cont];
                $venta->cantidad = $cantidad[$cont];
                $venta->precio = $precio_unit[$cont];
                $venta->total = ($cantidad[$cont] * $precio_unit[$cont]);
                $venta->save();

                //CONSULTAR SI EXISTE EN INVENTARIO COMO CAJA
                $condiciones_destino = [
                    ['bodega_id', '=', $request->bodega_id],
                    ['producto_id', '=', $producto_id[$cont]],
                    ['tratamiento', '=', 2]
                ];

                $prod_inventario = Inventory::where($condiciones_destino)
                                        ->first();
                
                //EL PRODUCTO YA EXISTE EN BODEGA COMO CAJA Y SE DISMINUIRA LA CANTIDAD
                if($prod_inventario){
                    $prod_inventario->cantidad = $prod_inventario->cantidad - $cantidad[$cont];
                    $prod_inventario->update();
                }
                //--------------------------------------------------------------------------------
                $cont = $cont + 1;
            }

            DB::commit();
            return back()->with('status', 'Se ha registrado correctamente la venta.');
        }catch(\Exception $e){
            DB::rollback();
            return back()->with('statusError', 'Ha ocurrido un problema con el registro.');
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
    public function show(SalesDetail $salesDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesDetail $salesDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesDetail $salesDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesDetail $salesDetail)
    {
        //
    }
}
