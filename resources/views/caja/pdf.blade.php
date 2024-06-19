
<style>
    body {
        font-family: Arial, sans-serif;
    }
    table {
        background-color: white;
        text-align: left;
        border-collapse: collapse;
        width: 100%;
        
    }
    td {
        padding: 3px;
        font-size: 10;
    }
    thead{
        background-color: #808B96;
        border-bottom: solid 0.5px #212F3D;
        color: white;
        font-size: 9;
    }
    tr:nth-child(even){
        background-color: #ddd;
    }
    img.alineadoTextoImagenCentro{
        vertical-align: middle;
    }
    @page {
		margin-top: 0.3cm;
		margin-bottom: 0.2cm;
	}
    </style>

<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->

<body>
<div class="container table-responsive">
    <div class="row">

        <div class="card">
            <div class="card-header">
                <img class="alineadoTextoImagenCentro" src="{{ asset('storage/carrito.jpg')}}" width="130px" height="120px"/>
                <strong style="font-family:courier"><center>CAJA CHICA - MULTIECONOMICO</center></strong>
                <br>
                <label style="font-size: 10;" font-family:courier;><strong>RESPONSABLE&nbsp;: </strong>{{ $usuario }}</label><br>
                <label style="font-size: 10;" font-family:courier;><strong>APERTURA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </strong>{{ \Carbon\Carbon::parse($fechaApertura)->isoFormat('dddd DD [de] MMMM YYYY H:m:s') }}</label><br>
                <label style="font-size: 10;" font-family:courier;><strong>CIERRE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </strong>{{ \Carbon\Carbon::parse($fechaCierre)->isoFormat('dddd DD [de] MMMM YYYY H:m:s') }}</label>
            </div>
            &nbsp;
            &nbsp;
            <div class="card-body">
                <table>
                    <tr style="font-weight: bold; background-color:#ddd; color:#2f4f4f;">
                        <td width="25%">1. CAJA INICIAL</td>
                        <td width="15%">&nbsp;</td>
                        <td width="20%">&nbsp;</td>
                        <td width="20%">&nbsp;</td>
                        <td width="20%" align="right">$ {{ $inicial }}</td>
                    </tr>
                    <tr height="1px" style="background-color:white">
                        <td colspan="5">&nbsp;</td> 
                    </tr>
                </table>
                
                <table>
                    <tr style="font-weight: bold; background-color:#ddd; color:#2f4f4f;">
                        <td width="25%">2. TRANSACCIONES</td>
                        <td width="15%">&nbsp;</td>
                        <td width="20%">&nbsp;</td>
                        <td width="20%">&nbsp;</td>
                        <td width="20%" align="right">$ {{ $transacciones }}</td>
                    </tr>
                </table>
                
                <table>
                    <thead>
                        <tr>
                            <th width="25%">- INGRESOS</th>
                            <th width="15%">&nbsp;</th>
                            <th width="20%">&nbsp;</th>
                            <th width="20%" align="right">$ {{ $t_ingresos }}</th>
                            <th width="20%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <table width="60%">
                                    <tr style="background-color:#ffffff;">
                                        <td align="left" width="50%">Ventas efectivo</td>
                                        <td align="right" width="50%">$ {{ $v_efectivo }}</td>
                                    </tr>
                                    <tr style="background-color:#ddd;">
                                        <td align="left" width="50%">Ventas debito</td>
                                        <td align="right" width="50%">$ {{ $v_debito }}</td>
                                    </tr>
                                    <tr style="background-color:#ffffff;">
                                        <td align="left" width="50%">Ventas transf</td>
                                        <td align="right" width="50%">$ {{ $v_transf }}</td>
                                    </tr>
                                    <tr style="background-color:#ddd;">
                                        <td align="left" width="50%">Ventas gratis</td>
                                        <td align="right" width="50%">$ {{ $v_gratis }}</td>
                                    </tr>
                                    <tr style="background-color:#ffffff;">
                                        <td align="left" width="50%">Aportes</td>
                                        <td align="right" width="50%">$ {{ $aportes }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table">
                    <thead>
                        <tr>
                            <th width="25%">- EGRESOS</th>
                            <th width="15%">&nbsp;</th>
                            <th width="20%">&nbsp;</th>
                            <th width="20%" align="right">$ {{ $t_egresos }}</th>
                            <th width="20%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <table width="60%">
                                    <tr style="background-color:#ffffff;">
                                        <td align="left" width="50%">P. Facturas</td>
                                        <td align="right" width="50%">$ {{ $p_facturas }}</td>
                                    </tr>
                                    <tr style="background-color:#ddd;">
                                        <td align="left" width="50%">P. Boletas</td>
                                        <td align="right" width="50%">$ {{ $p_boletas }}</td>
                                    </tr>
                                    <tr style="background-color:#ffffff;">
                                        <td align="left" width="50%">Otros Gastos</td>
                                        <td align="right" width="50%">$ {{ $p_otros  }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table>
                    <tr height="1px" style="background-color:white">
                        <td>&nbsp;</td>
                    </tr>
                </table>

                <table>
                    <tr style="font-weight: bold; background-color:#ddd; color:#2f4f4f;">
                        <td width="25%">3. EQUIV. EN EFECTIVO</td>
                        <td width="15%">&nbsp;</td>
                        <td width="20%">&nbsp;</td>
                        <td width="20%">&nbsp;</td>
                        <td width="20%" align="right">$ {{ $efect_rendido }}</td>
                    </tr>
                </table>
                <table class="table">
                    <thead>
                        <tr>
                            <th width="25%">- MONEDAS</th>
                            <th width="15%">&nbsp;</th>
                            <th width="20%">&nbsp;</th>
                            <th width="20%">&nbsp;</th>
                            <th width="20%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <table width="60%">
                                    <tr style="background-color:#ffffff;">
                                        <th align="left" width="50%">Denominación</th>
                                        <th align="center" width="50%">Cant</th>
                                        <th align="right" width="50%">Total</th>
                                    </tr>
                                    <tr style="background-color:#ddd;">
                                        <td align="left" width="50%">$ 10</td>
                                        <td align="center" width="50%">{{ $cant_10 }}</td>
                                        <td align="right" width="50%">$ {{ $total_10 }}</td>
                                    </tr>
                                    <tr style="background-color:#ffffff;">
                                        <td align="left" width="50%">$ 50</td>
                                        <td align="center" width="50%">{{ $cant_50 }}</td>
                                        <td align="right" width="50%">$ {{ $total_50 }}</td>
                                    </tr>
                                    <tr style="background-color:#ddd;">
                                        <td align="left" width="50%">$ 100</td>
                                        <td align="center" width="50%">{{ $cant_100 }}</td>
                                        <td align="right" width="50%">$ {{ $total_100 }}</td>
                                    </tr>
                                    <tr style="background-color:#ffffff;">
                                        <td align="left" width="50%">$ 500</td>
                                        <td align="center" width="50%">{{ $cant_500 }}</td>
                                        <td align="right" width="50%">$ {{ $total_500 }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table">
                    <thead>
                        <tr>
                            <th width="25%">- BILLETES</th>
                            <th width="15%">&nbsp;</th>
                            <th width="20%">&nbsp;</th>
                            <th width="20%">&nbsp;</th>
                            <th width="20%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <table width="60%">
                                    <tr style="background-color:#ffffff;">
                                        <th align="left" width="50%">Denominación</th>
                                        <th align="center" width="50%">Cant</th>
                                        <th align="right" width="50%">Total</th>
                                    </tr>
                                    <tr style="background-color:#ddd;">
                                        <td align="left" width="50%">$ 1000</td>
                                        <td align="center" width="50%">{{ $cant_1000 }}</td>
                                        <td align="right" width="50%">$ {{ $total_1000 }}</td>
                                    </tr>
                                    <tr style="background-color:#ffffff;">
                                        <td align="left" width="50%">$ 2000</td>
                                        <td align="center" width="50%">{{ $cant_2000 }}</td>
                                        <td align="right" width="50%">$ {{ $total_2000 }}</td>
                                    </tr>
                                    <tr style="background-color:#ddd;">
                                        <td align="left" width="50%">$ 5000</td>
                                        <td align="center" width="50%">{{ $cant_5000 }}</td>
                                        <td align="right" width="50%">$ {{ $total_5000 }}</td>
                                    </tr>
                                    <tr style="background-color:#ffffff;">
                                        <td align="left" width="50%">$ 10000</td>
                                        <td align="center" width="50%">{{ $cant_10000 }}</td>
                                        <td align="right" width="50%">$ {{ $total_10000 }}</td>
                                    </tr>
                                    <tr style="background-color:#ddd;">
                                        <td align="left" width="50%">$ 20000</td>
                                        <td align="center" width="50%">{{ $cant_20000 }}</td>
                                        <td align="right" width="50%">$ {{ $total_20000 }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr/>
                <table>
                    <tr>
                        <td width="25%">&nbsp;</td>
                        <td width="15%">&nbsp;</td>
                        <td width="20%">&nbsp;</td>
                        <td width="40%" colspan="2">
                            <table style="border-collapse: separate; border-spacing: 2px;">
                                <tr style="background-color:white; font-weight: bold;">
                                    <td align="left" style="background-color:#ddd;">1. CAJA INICIAL</td>
                                    <td align="right">$ {{ $inicial }}</td>
                                </tr>
                                <tr style="background-color:white; font-weight: bold;">
                                    <td align="left" style="background-color:#ddd;">2. T. TRANSAC.</td>
                                    <td align="right">$ {{ $transacciones }}</td>
                                </tr>
                                <tr style="background-color:white; font-weight: bold;">
                                    <td align="left" style="background-color:#ddd; padding-left:18px">TOTAL</td>
                                    <td align="right">$ {{ $inicial + $transacciones }}</td>
                                </tr>
                                <tr style="background-color:white; font-weight: bold;">
                                    <td align="left" style="background-color:#ddd;">3. EFECT. ESPERADO</td>
                                    <td align="right">$ {{ $efect_esperado }}</td>
                                </tr>
                                <tr style="background-color:white; font-weight: bold;">
                                    <td align="left" style="background-color:#ddd;">4. T. EFECTIVO</td>
                                    <td align="right">$ {{ $efect_rendido }}</td>
                                </tr>
                                <tr style="background-color:white; font-weight: bold;">
                                    <td align="left" style="background-color:#ddd; ">SALDO</td>
                                    <td align="right">$ {{ $saldo }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <hr/>
            </div>
        </div>
    </div>
</div>
</body>