<?php

namespace App\Http\Controllers;

use App\Models\GraphicCustomer;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Carbon\Carbon;

class GraphicCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fecha_inicial =  $request->start_date;
        $fecha_final = $request->end_date;
        $bodega_id = $request->bodega_id;
        
        if($fecha_inicial == null){
            $bodegas = Store::where('estado','=', 'VIGENTE')
                                ->get();
            $meses_encode = json_encode([]);
            $datos_encode = json_encode([]);
            return view('grafica.cliente.index', compact('fecha_inicial','fecha_final', 'bodegas', 'bodega_id', 'meses_encode', 'datos_encode'));
        }
        
        //----------------------------------------------------------
        $fecha_ini = Carbon::parse($request->start_date);
        $fecha_fin = Carbon::parse($request->end_date);

        $mesInicial = (int)date("m", strtotime($fecha_inicial)); // 9
        $mesFinal = (int)date("m", strtotime($fecha_final)); // 12

        $anioInicial = (int)date("Y", strtotime($fecha_inicial));
        $anioFinal = (int)date("Y", strtotime($fecha_final));

        if($anioInicial == $anioFinal){
            if($fecha_inicial < $fecha_final){
                $bodegas = Store::where('estado','=', 'VIGENTE')
                                ->get();

                $data = GraphicCustomer::where('bodega_id', '=', $bodega_id)
                                        ->whereBetween('id_mes', [$mesInicial, $mesFinal])
                                        ->whereBetween('anio', [$anioInicial, $anioFinal])
                                        ->orderBy('id_mes', 'ASC')
                                        ->orderBy('anio','ASC')
                                        ->get();

                $puntos = [];
                foreach($data as $dat){
                    $puntos[] = ['name' => $dat['mes'], 'data' => $dat['cantidad']];
                }

                foreach($puntos as $mes){
                    $meses[] = $mes["name"];
                    $datos[] = $mes["data"];
                }
                $meses_encode = json_encode($meses);
                $datos_encode = json_encode($datos);

                return view('grafica.cliente.index', compact('fecha_inicial','fecha_final', 'bodegas', 'bodega_id', 'datos_encode', 'meses_encode'));
            }
            else{
                return back()->with('statusError', 'La fecha final no es superior a la fecha inicial');
            }
        }
        else{
            return back()->with('statusError', 'Las fechas deben corresponder al mismo año.');
        }
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
    public function show(GraphicCustomer $graphicCustomer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GraphicCustomer $graphicCustomer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GraphicCustomer $graphicCustomer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GraphicCustomer $graphicCustomer)
    {
        //
    }
}
