<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PaymentForm;
use App\Models\SalesGuide;
use App\Models\Store;
use App\Models\Inventory;
use App\Models\PettyCash;
use App\Models\SalesDetailGuide;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SalesGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request){
            $folio = trim($request->folio);
            $fecha = Carbon::today()->format("Y-m-d");

            $bodegas = Store::where('responsable_id', auth()->user()->id)
                            ->where('estado', 'VIGENTE' )
                            ->first();

            $clientes = Customer::where('bodega_id', $bodegas->id)
                            ->where('estado', 'VIGENTE')
                            ->get();

            $pagos = PaymentForm::where('estado', 'VIGENTE')->get();

            $productos = Inventory::select('products.id', 'products.codigo', 'products.nombre', 'products.precio_unid', 'stores.nombre as bodega', 'inventories.cantidad')
                                ->join('products', 'inventories.producto_id', '=', 'products.id')
                                ->join('stores', 'inventories.bodega_id', '=', 'stores.id')
                                ->where('inventories.bodega_id', '=', $bodegas->id)
                                ->where('inventories.cantidad', '>', 0)
                                ->where('inventories.tratamiento', 1)
                                ->get();

            $ventas = SalesGuide::select('sales_guides.id', 'stores.nombre as nombre_bodega', 'payment_forms.nombre as pago', 'users.name as nombre_usuario', 'sales_guides.created_at', 'sales_guides.estado', DB::raw('sum(sales_detail_guides.cantidad * sales_detail_guides.precio) as total'))
                                    ->join('stores', 'sales_guides.bodega_id', '=', 'stores.id')
                                    ->join('sales_detail_guides','sales_guides.id','=','sales_detail_guides.guia_venta_id')
                                    ->join('users','sales_guides.usuario_id','=','users.id')
                                    ->join('payment_forms', 'sales_guides.pago_id', '=', 'payment_forms.id')
                                    ->where('sales_guides.id', 'LIKE', '%'.$folio.'%')
                                    ->groupBy('sales_guides.id', 'stores.nombre', 'payment_forms.nombre', 'users.name', 'sales_guides.created_at', 'sales_guides.estado')
                                    ->orderBy('sales_guides.id','desc')
                                    ->paginate(10);
            
            $caja = PettyCash::where("usuario_id","=",auth()->user()->id)
                                ->where("estado","=","ABIERTA")
                                ->where( DB::raw('DATE(created_at)'), '=', $fecha)
                                ->first();

            $nro_cabierta = ($caja == null) ? 0 : $caja->count();

            return view('venta_mayor.index', compact('ventas', 'bodegas', 'clientes', 'pagos', 'productos', 'folio', 'nro_cabierta'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try{
            DB::beginTransaction();
            $venta = new SalesGuide();
            //$venta->cliente_id = $request->cliente_id;
            $venta->bodega_id = $request->bodega_id;
            $venta->pago_id = $request->pago_id;
            $venta->usuario_id = auth()->user()->id;
            $venta->estado = "VIGENTE";
            $venta->save();

            $producto_id = $request->get('producto_id');
            $cantidad = $request->get('cantidad');
            $precio_unit = $request->get('precio_unit');

            $cont = 0;
            while($cont < count($producto_id)){
                $detalle = new SalesDetailGuide();
                $detalle->guia_venta_id = $venta->id;
                $detalle->producto_id = $producto_id[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio = $precio_unit[$cont];
                $detalle->subtotal = $precio_unit[$cont] * $cantidad[$cont];
                $detalle->save();

                //CONSULTAR SI EXISTE EN INVENTARIO COMO CAJA
                $condiciones_destino = [
                    ['bodega_id', '=', $request->bodega_id],
                    ['producto_id', '=', $producto_id[$cont]],
                    ['tratamiento', '=', 1]
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
            return back()->with('status', 'Se ha registrado correctamente.');
        }catch(\Exception $e){
            //DB::rollback();
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
    public function show(SalesGuide $salesGuide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesGuide $salesGuide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesGuide $salesGuide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesGuide $salesGuide)
    {
        //
    }
}
