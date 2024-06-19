<?php

namespace App\Http\Controllers;

use App\Models\PettyCash;
use App\Models\SalesGuide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class PettyCashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $nro = $request->texto;
        $cajas = PettyCash::where('id', 'LIKE', '%'.$nro.'%')
                ->orderBy('id', 'DESC')
                ->paginate(10);

        return view('caja.index', compact('cajas', 'nro'));
    }

    public function form($id){
        //$fecha = date('Y-m-d', strtotime(date('d-m-Y')));
        $fecha = Carbon::today()->format("Y-m-d");

        $caja = PettyCash::find($id);

        $ventas_efectivo = SalesGuide::select(DB::raw('sum(sales_detail_guides.cantidad * sales_detail_guides.precio) as total'))
                            ->join('sales_detail_guides', 'sales_guides.id', '=','sales_detail_guides.guia_venta_id')
                            ->where('sales_guides.usuario_id', auth()->user()->id)
                            ->where( DB::raw('DATE(sales_guides.created_at)'), '=', $fecha)
                            ->where('sales_guides.pago_id', '=', 1)
                            ->get();
        $t_efectivo = $ventas_efectivo[0]->total;

        $ventas_debito = SalesGuide::select(DB::raw('sum(sales_detail_guides.cantidad * sales_detail_guides.precio) as total'))
                            ->join('sales_detail_guides', 'sales_guides.id', '=','sales_detail_guides.guia_venta_id')
                            ->where('sales_guides.usuario_id', auth()->user()->id)
                            ->where( DB::raw('DATE(sales_guides.created_at)'), '=', $fecha)
                            ->where('sales_guides.pago_id', '=', 2)
                            ->get();
        $t_debito = $ventas_debito[0]->total;

        $ventas_transf = SalesGuide::select(DB::raw('sum(sales_detail_guides.cantidad * sales_detail_guides.precio) as total'))
                            ->join('sales_detail_guides', 'sales_guides.id', '=','sales_detail_guides.guia_venta_id')
                            ->where('sales_guides.usuario_id', auth()->user()->id)
                            ->where( DB::raw('DATE(sales_guides.created_at)'), '=', $fecha)
                            ->where('sales_guides.pago_id', '=', 3)
                            ->get();
        $t_transf = $ventas_transf[0]->total;

        $ventas_gratis = SalesGuide::select(DB::raw('sum(sales_detail_guides.cantidad * sales_detail_guides.precio) as total'))
                            ->join('sales_detail_guides', 'sales_guides.id', '=','sales_detail_guides.guia_venta_id')
                            ->where('sales_guides.usuario_id', auth()->user()->id)
                            ->where( DB::raw('DATE(sales_guides.created_at)'), '=', $fecha)
                            ->where('sales_guides.pago_id', '=', 4)
                            ->get();
        $t_gratis = $ventas_gratis[0]->total;

        return view('caja.form')->with(['id'=>$caja->id, 'total_inicio'=>$caja->total_inicio, 'venta_efectivo'=>$t_efectivo, 'venta_debito'=>$t_debito, 'venta_trans'=>$t_transf, 'venta_gratis'=>$t_gratis]);
        //return();
    }

    public function pdf($id){
        //$fecha = Carbon::now()->isoFormat('dddd DD [de] MMMM YYYY H:m:s');
        $caja = PettyCash::find($id);

        $pdf = PDF::loadView('caja.pdf', [
            'usuario'=>$caja->usuario->name,
            'inicial'=>$caja->total_inicio,
            'transacciones'=>$caja->total_transac,

            't_ingresos'=>$caja->ingr_total,
            'v_efectivo'=>$caja->ingr_v_efect,
            'v_debito'=>$caja->ingr_v_deb,
            'v_transf'=>$caja->ingr_v_transf,
            'v_gratis'=>$caja->ingr_v_gratis,
            'aportes'=>$caja->ingr_aportes,
            't_egresos'=>$caja->egre_total,
            'p_facturas'=>$caja->egre_p_fact,
            'p_boletas'=>$caja->egre_p_bol,
            'p_otros'=>$caja->egre_p_otros,
            
            'cant_10'=>$caja->cant_10,
            'total_10'=>$caja->total_10,
            'cant_50'=>$caja->cant_50,
            'total_50'=>$caja->total_50,
            'cant_100'=>$caja->cant_100,
            'total_100'=>$caja->total_100,
            'cant_500'=>$caja->cant_500,
            'total_500'=>$caja->total_500,

            'cant_1000'=>$caja->cant_1000,
            'total_1000'=>$caja->total_1000,
            'cant_2000'=>$caja->cant_2000,
            'total_2000'=>$caja->total_2000,
            'cant_5000'=>$caja->cant_5000,
            'total_5000'=>$caja->total_5000,
            'cant_10000'=>$caja->cant_10000,
            'total_10000'=>$caja->total_10000,
            'cant_20000'=>$caja->cant_20000,
            'total_20000'=>$caja->total_20000,

            'efect_esperado'=>$caja->total_efect_esperado,
            'efect_rendido'=>$caja->total_efect_rendido,
            'saldo'=>$caja->saldo,

            'fechaApertura'=>$caja->created_at,
            'fechaCierre'=>$caja->closed_at

            ]);
        $pdf->set_option('isRemoteEnabled', true);
        return $pdf->stream();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $caja_inicial = $request->caja;
        $caja = new PettyCash();
        $caja->usuario_id = auth()->user()->id;
        $caja->total_inicio = $caja_inicial;
        $caja->estado = 'ABIERTA';
        if($caja->save())
            return redirect()->route("venta.index")->with('status', 'La apertura de caja se ha registrado correctamente.');
        else
            return redirect()->route("venta.index")->with('statusError', 'Ha ocurrido un problema al intentar registrar la apertura.');
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $caja = PettyCash::find($id);
        //dump($request->all());
        $caja->ingr_v_efect = $request->ingr_v_efectivo;
        $caja->ingr_v_deb = $request->ingr_v_debito;
        $caja->ingr_v_transf = $request->ingr_v_transf;
        $caja->ingr_v_gratis = $request->ingr_v_gratis;
        $caja->ingr_aportes = $request->aportes;
        $caja->ingr_total = $request->t_ingresos;

        $caja->egre_p_fact = $request->facturas;
        $caja->egre_p_bol = $request->boletas;
        $caja->egre_p_otros = $request->otros;
        $caja->egre_total = $request->t_egresos;
        $caja->total_transac = $request->f_transac;
        $caja->total_rendido = $request->f_erendido;
        $caja->cant_10 = $request->cant_10;
        $caja->total_10 = $caja->cant_10 * 10;
        $caja->cant_50 = $request->cant_50;
        $caja->total_50 = $caja->cant_50 * 50;
        $caja->cant_100 = $request->cant_100;
        $caja->total_100 = $caja->cant_100 * 100;
        $caja->cant_500 = $request->cant_500;
        $caja->total_500 = $caja->cant_500 * 500;
        $caja->cant_1000 = $request->cant_1000;
        $caja->total_1000 = $caja->cant_1000 * 1000;
        $caja->cant_2000 = $request->cant_2000;
        $caja->total_2000 = $caja->cant_2000 * 2000;
        $caja->cant_5000 = $request->cant_5000;
        $caja->total_5000 = $caja->cant_5000 * 5000;
        $caja->cant_10000 = $request->cant_10000;
        $caja->total_10000 = $caja->cant_10000 * 10000;
        $caja->cant_20000 = $request->cant_20000;
        $caja->total_20000 = $caja->cant_20000 * 20000;
        $caja->total_efect_esperado = $request->f_esperado;
        $caja->total_efect_rendido = $request->f_erendido;
        $caja->saldo = $request->f_saldo;
        $caja->closed_at = Carbon::now();
        $caja->estado = 'CERRADA';
        $caja->update();

        return redirect()->route("caja.index")->with('status', 'Se ha registrado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
