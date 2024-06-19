<?php

namespace App\Http\Controllers;

use App\Models\PaymentForm;
use Illuminate\Http\Request;

class PaymentFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request){
            $texto = $request->texto;
            $forma_pagos = PaymentForm::where('estado', 'VIGENTE')
                                ->where('nombre', 'like', '%'.$texto.'%')
                                ->orderBy('nombre', 'ASC')
                                ->paginate(10);

            return view('forma_pago.index', compact('forma_pagos', 'texto'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $forma_pago = new PaymentForm();
        if($request){
            $forma_pago->nombre = strtoupper($request->nombre);
            $forma_pago->estado = "VIGENTE";
            $forma_pago->save();

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
    public function show(PaymentForm $paymentForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        if($request){
            $forma_pago = PaymentForm::findOrFail($id);
            $forma_pago->nombre = strtoupper($request->nombre);
            $forma_pago->estado = $request->estado;
            $forma_pago->update();

            return back()->with('status', 'Se ha actualizado correctamente.');
        }
        else{
            return back()->with('statusError', 'Error al intentar actualizar.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentForm $paymentForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if($id > 0){
            $forma_pago = PaymentForm::findOrFail($id);
            $forma_pago->estado = "NO VIGENTE";
            $forma_pago->update();

            return back()->with('status', 'La forma de pago fué anulada correctamente.');
        }
        else{
            return back()->with('statusError', 'Error al intentar anular la forma de pago.');
        }
    }
}
