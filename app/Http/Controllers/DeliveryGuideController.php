<?php

namespace App\Http\Controllers;

use App\Models\DeliveryGuide;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Store;
use App\Models\DeliveryDetailGuide;
use Illuminate\Support\Facades\DB;

class DeliveryGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $folio = $request->folio;
        $bodegas = Store::where('estado', 'VIGENTE')->get();
        $folio = $request->folio;

        if($request->bodega_origen){
            $productos = Inventory::select('products.id', 'products.nombre', 'stores.nombre as bodega', 'inventories.cantidad')
                    ->join('products', 'inventories.producto_id', '=', 'products.id')
                    ->join('stores', 'inventories.bodega_id', '=', 'stores.id')
                    ->where('inventories.bodega_id', '=', $request->bodega_origen)
                    ->get();
        }
        else{
            $productos = Inventory::select('products.id', 'products.nombre', 'stores.nombre as bodega', 'inventories.cantidad')
                    ->join('products', 'inventories.producto_id', '=', 'products.id')
                    ->join('stores', 'inventories.bodega_id', '=', 'stores.id')
                    ->get();
        }

        
        $cargas = DeliveryGuide::select('delivery_guides.id', 'stores.nombre as bodega_origen', 'st.nombre as bodega_destino', 'users.name', 'delivery_guides.created_at', 'delivery_guides.estado')
                    ->join('stores', 'delivery_guides.bodega_origen', '=', 'stores.id')
                    ->join('stores as st', 'delivery_guides.bodega_destino', '=', 'st.id')
                    ->join('users', 'delivery_guides.usuario_id','=','users.id')
                    ->orderBy('delivery_guides.id', 'DESC')
                    ->paginate(10);

        return view('carga.index', compact('bodegas', 'productos', 'cargas', 'folio'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try{
            DB::beginTransaction();
            $carga = new DeliveryGuide();
            $carga->bodega_origen = $request->bodega_origen;
            $carga->bodega_destino = $request->bodega_destino;
            $carga->usuario_id = auth()->user()->id;
            $carga->estado = "VIGENTE";
            $carga->save();

            $producto_id = $request->get('producto_id');
            $cantidad = $request->get('cantidad');

            $cont = 0;
            while($cont < count($producto_id)){
                $detalle = new DeliveryDetailGuide();
                $detalle->guia_entrega_id = $carga->id;
                $detalle->producto_id = $producto_id[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->save();

                //CONSULTAR SI EXISTE EN INVENTARIO COMO CAJA
                $condiciones_destino = [
                    ['bodega_id', '=', $request->bodega_destino],
                    ['producto_id', '=', $producto_id[$cont]],
                    ['tratamiento', '=', 1]
                ];

                $prod_inventario = Inventory::where($condiciones_destino)
                                        ->first();
                
                //EL PRODYCTO YA EXISTE EN BODEGA COMO CAJA Y SE SUMARA LA CANTIDAD
                if($prod_inventario){
                    $prod_inventario->cantidad = $prod_inventario->cantidad + $cantidad[$cont];
                    $prod_inventario->update();
                }
                else{ //EL PRODUCTO NO EXISTE EN BODEGA COMO CAJA Y SE INSERTARA
                    $inventario = new Inventory();
                    $inventario->bodega_id = $request->bodega_destino;
                    $inventario->producto_id = $producto_id[$cont];
                    $inventario->tratamiento = 1; //CAJA
                    $inventario->cantidad = $cantidad[$cont];
                    $inventario->save();
                }

                //DISMINUIR DE BODEGA ORIGEN -----------------------------------------------------
                $condiciones_origen = [
                    ['bodega_id', '=', $request->bodega_origen],
                    ['producto_id', '=', $producto_id[$cont]],
                    ['tratamiento', '=', 1]
                ];

                $inventario_origen = Inventory::where($condiciones_origen)
                                        ->first();
                if($inventario_origen){
                    $inventario_origen->cantidad = $inventario_origen->cantidad - $cantidad[$cont];
                    $inventario_origen->save();
                }
                //--------------------------------------------------------------------------------
                $cont = $cont + 1;
            }

            DB::commit();
            return back()->with('status', 'Se ha registrado correctamente.');
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
    public function show(DeliveryGuide $deliveryGuide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeliveryGuide $deliveryGuide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeliveryGuide $deliveryGuide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryGuide $deliveryGuide)
    {
        //
    }
}
