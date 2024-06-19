@extends("layouts.admin")

@section("contenido")
<!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>LISTADO DE CAJAS</h5>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Caja</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="section">
        <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('caja.update', $id) }}" method="POST">
                        @csrf
                        <div class="card-header">
                            <div class="row mb-10">
                                <div class="form-group col-md-6">
                                    <label>1. CAJA INICIAL</label>
                                </div>
            
                                <div class="form-group col-md-2">
                                    <input style="text-align: right" type="text" id="inicial" name="inicial" class="form-control" value="{{ $total_inicio }}" disabled>
                                </div>
                            </div>
                            
                            <div class="row mb-12">
                                <div class="form-group col-md-6">
                                    <label>2. TRANSACCIONES</label>
                                </div>
                                <div class="form-group col-md-2">
                                    <input style="text-align: right" type="number" id="transacciones" name="total_transaccion" class="form-control" value="0" disabled>
                                </div>
                                
                                <div class="form-group col-md-6" style="background-color:#F5F5F5; border-radius: 6px;">
                                    <table class="table">
                                        <thead>
                                            <tr height="5px" style="padding: 0px">
                                                <!-- Input para enviar pro POST-->
                                                <input type="hidden" name="f_transac" id="f_transac" value="0">
                                                <input type="hidden" name="f_subtotal" id="f_subtotal" value="0">
                                                <input type="hidden" name="f_esperado" id="f_esperado" value="0">
                                                <input type="hidden" name="f_erendido" id="f_erendido" value="0">
                                                <input type="hidden" name="f_saldo" id="f_saldo" value="0">
                                                <!-- -->
                                                <th>- INGRESOS</th>
                                                <th>&nbsp;</th>
                                                <th width="130">
                                                    <input type="number" id="ingresos" name="ingresos" value="0" class="form-control text-right" style="font-weight:bold;" disabled>
                                                    <input type="hidden" id="t_ingresos" name="t_ingresos">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="text-align: right">Ventas efectivo</td>
                                                <td>&nbsp;</td>
                                                <td width="130">
                                                    <input type="number" id="v_efectivo" name="ventas" class="form-control text-right" value="{{ $venta_efectivo }}" disabled>
                                                    <input type="hidden" id="ingr_v_efectivo" name="ingr_v_efectivo" value="{{ $venta_efectivo }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right">Ventas debito</td>
                                                <td>&nbsp;</td>
                                                <td width="130">
                                                    <input type="number" id="v_debito" name="ventas" class="form-control text-right" value="{{ $venta_debito }}" disabled>
                                                    <input type="hidden" id="ingr_v_debito" name="ingr_v_debito" value="{{ $venta_debito }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right">Ventas transf</td>
                                                <td>&nbsp;</td>
                                                <td width="130">
                                                    <input type="number" id="v_transf" name="ventas" class="form-control text-right" value="{{ $venta_trans }}" disabled>
                                                    <input type="hidden" id="ingr_v_transf" name="ingr_v_transf" value="{{ $venta_trans }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right">Ventas gratis</td>
                                                <td>&nbsp;</td>
                                                <td width="130">
                                                    <input type="number" id="v_gratis" name="ventas" class="form-control text-right" value="{{ $venta_gratis }}" disabled>
                                                    <input type="hidden" id="ingr_v_gratis" name="ingr_v_gratis" value="{{ $venta_gratis }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right">Aportes</td>
                                                <td>&nbsp;</td>
                                                <td width="130">
                                                    <input type="number" id="aporte" name="aportes" value="0" class="form-control text-right" onchange="calculaTransacciones()">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>- EGRESOS</th>
                                                <th>&nbsp;</th>
                                                <th width="130px">
                                                    <input type="number" id="egresos" name="egresos" value="0" class="form-control text-right" style="font-weight:bold;" disabled>
                                                    <input type="hidden" id="t_egresos" name="t_egresos">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="text-align: right">P. Facturas</td>
                                                <td>&nbsp;</td>
                                                <td width="130">
                                                    <input type="number" id="p_factura" name="facturas" class="form-control text-right" value="0" onchange="calculaTransacciones()">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right">P. Boletas</td>
                                                <td>&nbsp;</td>
                                                <td width="130">
                                                    <input type="number" id="p_boleta" name="boletas" class="form-control text-right" value="0" onchange="calculaTransacciones()">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right">Otros Gastos</td>
                                                <td>&nbsp;</td>
                                                <td width="130">
                                                    <input type="number" id="p_otro" name="otros" class="form-control text-right" value="0" onchange="calculaTransacciones()">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row mb-12">
                                <div class="form-group col-md-6">
                                    <label>3. EQUIVALENTE EN EFECTIVO</label>
                                </div>
            
                                <div class="form-group col-md-2">
                                    <input type="number" id="efectivo" name="efectivo" class="form-control text-right" value="0" disabled>
                                </div>
                            </div>
                            <div class="row mb-12">
                                <div class="form-group col-md-12">
                                    <label>- MONEDAS</label>
                                </div>
                            </div>
                            <div class="row mb-12">
                                <div class="form-group col-md-5" style="background-color:#F5F5F5; border-radius: 6px; height: 194px;">
                                    <table class="table-responsive">
                                        <thead>
                                            <tr>
                                                <th width="30%" style="text-align:left;">Denominación</th>
                                                <th width="20%" style="text-align:center;">Cant</th>
                                                <th width="30%" style="text-align:center;">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>$ 10</td>
                                                <td><input type="number" id="cant_10" name="cant_10" class="form-control" value="0" onchange="calculaEfectivo()"></td>
                                                <td>
                                                    <input type="number"id="total_10" name="total_10" class="form-control text-right" value="0" disabled>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>$ 50</td>
                                                <td><input type="number" id="cant_50" name="cant_50" class="form-control" value="0" onchange="calculaEfectivo()"></td>
                                                <td>
                                                    <input type="number" id="total_50" name="total_50" class="form-control text-right" value="0" disabled>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>$ 100</td>
                                                <td><input type="number" id="cant_100" name="cant_100" class="form-control" value="0" onchange="calculaEfectivo()"></td>
                                                <td>
                                                    <input type="number" id="total_100" name="total_100" class="form-control text-right" value="0" disabled>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>$ 500</td>
                                                <td><input type="number" id="cant_500" name="cant_500" class="form-control" value="0" onchange="calculaEfectivo()"></td>
                                                <td>
                                                    <input type="number" id="total_500" name="total_500" class="form-control text-right" value="0" disabled>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                                
                            <div class="row mb-12">
                                <div class="form-group col-md-12">
                                    <label>- BILLETES</label>
                                </div>
                            </div>
                                
                            <div class="row mb-12">
                                <div class="form-group col-md-5" style="background-color:#F5F5F5; border-radius: 6px; height: 234px;">
                                    <table class="table-responsive">
                                        <thead>
                                            <tr style="text-align:center;">
                                                <th width="30%" style="text-align:left;">Denominación</th>
                                                <th width="20%" style="text-align:center;">Cant</th>
                                                <th width="30%" style="text-align:center; background-color:">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>$ 1000</td>
                                                <td width="30px">
                                                    <input type="number" id="cant_1000" name="cant_1000" class="form-control" value="0" onchange="calculaEfectivo()">
                                                </td>
                                                <td width="130px" >
                                                    <input type="number" id="total_1000" name="total_1000" class="form-control text-right" value="0" disabled>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>$ 2000</td>
                                                <td width="30px">
                                                    <input type="number" id="cant_2000" name="cant_2000" class="form-control" value="0" onchange="calculaEfectivo()">
                                                </td>
                                                <td width="130px" style="text-align: right">
                                                    <input type="number" id="total_2000" name="total_2000" class="form-control text-right" value="0" disabled>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>$ 5000</td>
                                                <td width="30px">
                                                    <input type="number" id="cant_5000" name="cant_5000" class="form-control" value="0" onchange="calculaEfectivo()">
                                                </td>
                                                <td width="130px">
                                                    <input type="number" id="total_5000" name="total_5000" class="form-control text-right" value="0" disabled>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>$ 10000</td>
                                                <td width="30px">
                                                    <input type="number" id="cant_10000" name="cant_10000" class="form-control" value="0" onchange="calculaEfectivo()">
                                                </td>
                                                <td>
                                                    <input type="number" id="total_10000" name="total_10000" class="form-control text-right" value="0" disabled>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>$ 20000</td>
                                                <td width="30px">
                                                    <input type="number" id="cant_20000" name="cant_20000" class="form-control" value="0" onchange="calculaEfectivo()">
                                                </td>
                                                <td width="130px">
                                                    <input type="number" id="total_20000" name="total_20000" class="form-control text-right" value="0" disabled>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-group col-md-1">
                                </div>
                                <div class="form-group col-md-1">
                                </div>
            
                                <div class="form-group col-md-4" style="background-color:palegreen; border-radius: 6px; height: 275px;">
                                    <!-- PONER LOS TOTALES-->
                                    <table class="table-responsive" style="font-weight:bold;">
                                        <thead>
                                            <tr height="2px">
                                                <th colspan="2" width="80%">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="40%">1. CAJA INICIAL</td>
                                                <td width="30%">
                                                    <input type="number" id="total_caja_chica" class="form-control text-right" value="{{ $total_inicio }}" disabled>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2. T. TRANSAC.</td>
                                                <td><input type="number" id="total_trans" name="total_trans" class="form-control text-right" value="0" disabled></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right">TOTAL</td>
                                                <td><input type="number" id="total_sub1" class="form-control text-right" value="0" disabled></td>
                                            </tr>
                                            <tr>
                                                <td>3. EFECT. ESPERADO</td>
                                                <td><input type="number" id="efectivo_esperado" name="efectivo_esperado" class="form-control text-right" style="background-color:palegreen;" value="0" disabled></td>
                                            </tr>
                                            <tr>
                                                <td>4. T. EFECTIVO</td>
                                                <td><input type="number" id="total_efectivo" class="form-control text-right" value="0" disabled></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right">SALDO</td>
                                                <td><input type="number" id="total_saldo" class="form-control text-right" value="0" disabled></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                            <button type="submit" class="btn btn-default" >GUARDAR</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section>

@push('scripts')
<script>
    var efectivo_esperado, ingresos, egresos, transacciones, total, efectivo, saldo;

    window.addEventListener('load', function(){
        calculaEfectivoEsperado();
        calculaTransacciones();
    });
    
    function calculaEfectivoEsperado(){
        inicial = parseInt(document.getElementById("inicial").value);
        venta_efect = parseInt(document.getElementById("v_efectivo").value);
        aportes = parseInt(document.getElementById("aporte").value);
        salidas = parseInt(document.getElementById("egresos").value);
        efectivo_esperado =  inicial + venta_efect + aportes - salidas;
        document.getElementById("efectivo_esperado").value = efectivo_esperado;
        document.getElementById("f_esperado").value = efectivo_esperado;
    }
    
    function calculaTransacciones(){
        v_efectivo = parseInt(document.getElementById("v_efectivo").value);
        v_debito = parseInt(document.getElementById("v_debito").value);
        v_transf = parseInt(document.getElementById("v_transf").value);
        v_gratis = parseInt(document.getElementById("v_gratis").value);
        aporte = parseInt(document.getElementById("aporte").value);

        ingresos = v_efectivo + v_debito + v_transf + aporte;
        document.getElementById("ingresos").value = ingresos;
        document.getElementById("t_ingresos").value = ingresos;
        
        p_factura = parseInt(document.getElementById("p_factura").value);
        p_boleta = parseInt(document.getElementById("p_boleta").value);
        p_otro = parseInt(document.getElementById("p_otro").value);

        egresos = p_factura + p_boleta + p_otro;
        document.getElementById("egresos").value = egresos;
        document.getElementById("t_egresos").value = egresos;

        transacciones = ingresos - egresos;

        document.getElementById("transacciones").value = transacciones;
        document.getElementById("total_trans").value = transacciones;
        document.getElementById("f_transac").value = transacciones;

        total = parseInt(document.getElementById("inicial").value) + transacciones;
        document.getElementById("total_sub1").value = total;
        document.getElementById("f_subtotal").value = total;
        calculaEfectivoEsperado();
    }

    function calculaEfectivo(){
        m_10 = parseInt(document.getElementById("cant_10").value) * 10;
        document.getElementById("total_10").value = m_10;
        m_50 = parseInt(document.getElementById("cant_50").value) * 50;
        document.getElementById("total_50").value = m_50;
        m_100 = parseInt(document.getElementById("cant_100").value) * 100;
        document.getElementById("total_100").value = m_100;
        m_500 = parseInt(document.getElementById("cant_500").value) * 500;
        document.getElementById("total_500").value = m_500;

        m_1000 = parseInt(document.getElementById("cant_1000").value) * 1000;
        document.getElementById("total_1000").value = m_1000;
        m_2000 = parseInt(document.getElementById("cant_2000").value) * 2000;
        document.getElementById("total_2000").value = m_2000;
        m_5000 = parseInt(document.getElementById("cant_5000").value) * 5000;
        document.getElementById("total_5000").value = m_5000;
        m_10000 = parseInt(document.getElementById("cant_10000").value) * 10000;
        document.getElementById("total_10000").value = m_10000;
        m_20000 = parseInt(document.getElementById("cant_20000").value) * 20000;
        document.getElementById("total_20000").value = m_20000;

        efectivo = (m_10 + m_50 + m_100 + m_500) + (m_1000 + m_2000 + m_5000 + m_10000 + m_20000);
        document.getElementById("efectivo").value = efectivo;
        document.getElementById("total_efectivo").value = efectivo;
        document.getElementById("f_erendido").value = efectivo;

        calculaEfectivoEsperado();

        efectivo_esperado = parseInt(document.getElementById("efectivo_esperado").value);
        saldo = efectivo_esperado - efectivo;
        document.getElementById("total_saldo").value = saldo;
        document.getElementById("f_saldo").value = saldo;
    }


</script>
@endpush

@endsection