@extends("layouts.admin")

@section('titulo')
    <h5>Gestión de Cajas</h5>
@endsection

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
                    <div class="card-header">
                        <div class="col-xl-12">
                            <form action="{{ route('caja.index') }}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="input-group mb-6">
                                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                            <input type="text" class="form-control" name="texto" placeholder="Buscar nombre sucursal" value="{{$nro}}" aria-label="Recipient's username" aria-describedby="button-addon2">
                                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Buscar</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="input-group mb-6">
                                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-plus-circle-fill"></i></span>
                                            <a href="" data-toggle="modal" data-target="#modalNuevo" class="btn btn-success">Nueva</a>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert" style="opacity: 0.5">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @if (session('statusError'))
                                <div class="alert alert-danger" role="alert" style="opacity: 0.5">
                                    {{ session('statusError') }}
                                </div>
                            @endif
                        </div>
                        <!-- table hover -->
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="text-align:center">N°</th>
                                        <th style="text-align:center">APERTURA</th>
                                        <th style="text-align:center">USUARIO</th>
                                        <th style="text-align:center">CIERRE</th>
                                        <th style="text-align:center">INICIAL</th>
                                        <th style="text-align:center">SALDO</th>
                                        <th style="text-align:center" style="display:none;">ESTADO</th>
                                        <th style="text-align:center" colspan="2">OPCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cajas as $ca)
                                    <tr {{ $ca->saldo > 0 ? 'style=color:#dc143c' : '' }}>
                                        <td style="text-align:center">{{ $ca->id}}</td>
                                        <td style="text-align:center">{{ \Carbon\Carbon::parse($ca->created_at)->isoFormat('dddd DD [de] MMMM YYYY H:m:s') }}</td>
                                        <td style="text-align:center">{{ $ca->usuario->name}}</td>
                                        <td style="text-align:center">{{ ($ca->closed_at == null) ? '---' : \Carbon\Carbon::parse($ca->closed_at)->isoFormat('dddd DD [de] MMMM YYYY H:m:s') }}</td>
                                        <td style="text-align:right">{{ '$ '.$ca->total_inicio}}</td>
                                        <td style="text-align:right">{{ '$ '.$ca->saldo}}</td>
                                        <td style="text-align:center">{{ $ca->estado}}</td>
                                        <td style="text-align:center">
                                        @if($ca->estado == 'ABIERTA')
                                            <!--<button type="button" href="" class="btn btn-outline-warning btn-sm" title="Cerrar caja"><i class="fas fa-pen"></i></button>-->
                                            <a href="{{ route('caja.form', $ca->id) }}" class="btn btn-outline-warning btn-sm" title="Cerrar caja"><i class="fas fa-pen"></i></a>
                                        @else
                                        <a href="{{ route('caja.pdf', $ca->id) }}" class="btn btn-outline-info btn-sm" title="Ver PDF"><i class="fas fa-eye"></i></a>
                                            <!--<button type="button" class="btn btn-outline-info btn-sm btnAbrirModal" title="Ver caja"><i class="fas fa-eye"></i></button>-->
                                        @endif
                                            <button type="button" id="btnEliminarCaja" class="btn btn-outline-danger btn-sm" title="Anular caja"><i class="fas fa-trash-alt"></i></button>
                                            
                                            <!-- MODAL ELIMINACION-->
                                            <div class="modal fade" id="modal-delete-{{ $ca->id }}">
                                                <div class="modal-dialog">
                                                    <form action="{{ route('bodega.destroy', $ca->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-content bg-danger">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Anular Caja</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Deseas eliminar la caja N° {{ $ca->id }}</p>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-outline-light">Anular</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- MODAL ELIMINACION-->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $cajas->links("pagination::bootstrap-4") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="cajaEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">CIERRE DE CAJA</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
        
                    <form id="formEditCaja">
                        @csrf
                    <div class="modal-body">
                        <div class="row mb-12">
                            <div class="form-group col-md-10">
                                <label>1. CAJA INICIAL</label>
                            </div>
        
                            <div class="form-group col-md-2">
                                <input style="text-align: right" type="number" id="inicial" name="inicial" class="form-control" disabled>
                            </div>
                        </div>
        
                        <div class="row mb-12">
                            <div class="form-group col-md-10">
                                <label>2. TRANSACCIONES</label>
                            </div>
                            <div class="form-group col-md-2">
                                <input style="text-align: right" type="number" name="total_transaccion" class="form-control" value="0" disabled>
                            </div>
                            
                            <div class="form-group col-md-6" style="background-color:#F5F5F5; border-radius: 6px;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>- INGRESOS</th>
                                            <th>&nbsp;</th>
                                            <th style="text-align: right" width="130"><input type="number" name="ingresos" value="0" class="form-control text-right" disabled></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: right">Ventas efectivo</td>
                                            <td>&nbsp;</td>
                                            <td style="text-align: right" width="130"><input type="number" id="v_efectivo" name="ventas" class="form-control text-right" disabled></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right">Ventas debito</td>
                                            <td>&nbsp;</td>
                                            <td style="text-align: right" width="130"><input type="number" id="v_debito" name="ventas" class="form-control text-right" disabled></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right">Ventas transf</td>
                                            <td>&nbsp;</td>
                                            <td style="text-align: right" width="130"><input type="number" id="v_transf" name="ventas" class="form-control text-right" disabled></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right">Ventas gratis</td>
                                            <td>&nbsp;</td>
                                            <td style="text-align: right" width="130"><input type="number" id="v_gratis" name="ventas" class="form-control text-right" disabled></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right">Aportes</td>
                                            <td>&nbsp;</td>
                                            <td style="text-align: right" width="130"><input type="number" name="aportes" value="0" class="form-control text-right"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>- EGRESOS</th>
                                            <th>&nbsp;</th>
                                            <th style="text-align: right" width="130px"><input type="number" name="egresos" value="0" class="form-control text-right" disabled></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: right">P. Facturas</td>
                                            <td>&nbsp;</td>
                                            <td style="text-align: right" width="130"><input type="number" name="facturas" class="form-control text-right" value="0"></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right">P. Boletas</td>
                                            <td>&nbsp;</td>
                                            <td style="text-align: right" width="130"><input type="number" name="boletas" class="form-control text-right" value="0"></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right">Otros Gastos</td>
                                            <td>&nbsp;</td>
                                            <td style="text-align: right" width="130"><input type="number" name="otros" class="form-control text-right" value="0"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="row mb-12">
                            <div class="form-group col-md-10">
                                <label>3. EQUIVALENTE EN EFECTIVO</label>
                            </div>
        
                            <div class="form-group col-md-2">
                                <input style="text-align: right" type="number" name="efectivo" class="form-control" value="0" disabled>
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
                                            <td><input type="number" name="cant_10" class="form-control"></td>
                                            <td style="text-align: right"><input type="number" name="total_10" class="form-control" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>$ 50</td>
                                            <td><input type="number" name="cant_50" class="form-control"></td>
                                            <td style="text-align: right"><input type="number" name="total_50" class="form-control" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>$ 100</td>
                                            <td><input type="number" name="cant_100" class="form-control"></td>
                                            <td style="text-align: right"><input type="number" name="total_100" class="form-control" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>$ 500</td>
                                            <td><input type="number" name="cant_500" class="form-control"></td>
                                            <td style="text-align: right"><input type="number" name="total_500" class="form-control" disabled></td>
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
                                            <td width="30px"><input type="number" name="cant_1000" class="form-control"></td>
                                            <td width="130px" style="text-align: right"><input type="number" name="total_1000" class="form-control" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>$ 2000</td>
                                            <td width="30px"><input type="number" name="cant_2000" class="form-control"></td>
                                            <td width="130px" style="text-align: right"><input type="number" name="total_2000" class="form-control" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>$ 5000</td>
                                            <td width="30px"><input type="number" name="cant_5000" class="form-control"></td>
                                            <td width="130px" style="text-align: right"><input type="number" name="total_5000" class="form-control" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>$ 10000</td>
                                            <td width="30px"><input type="number" name="cant_10000" class="form-control"></td>
                                            <td><input type="number" name="total_10000" class="form-control" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>$ 20000</td>
                                            <td width="30px"><input type="number" name="cant_20000" class="form-control"></td>
                                            <td width="130px" style="text-align: right"><input type="number" name="total_20000" class="form-control" disabled></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group col-md-1">
                            </div>
        
                            <div class="form-group col-md-6" style="background-color:palegreen; border-radius: 6px; height: 248px;">
                                <!-- PONER LOS TOTALES-->
                                <table class="table-responsive" style="font-weight:bold;">
                                    <thead>
                                        <tr height="2px">
                                            <th colspan="2" width="80%">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="30%">1. CAJA INICIAL</td>
                                            <td width="40%"><input type="number" name="total_caja_chica" class="form-control text-right" value="0" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>2. T. TRANSAC.</td>
                                            <td><input type="number" name="total_trans" class="form-control text-right" value="0" disabled></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right">TOTAL</td>
                                            <td><input type="number" name="total_sub1" class="form-control text-right" value="0" disabled></td>
                                        </tr>
                                        <tr>
                                            <td>3. T. EFECTIVO</td>
                                            <td><input type="number" name="total_efectivo" class="form-control text-right" value="0" disabled></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right">SALDO</td>
                                            <td><input type="number" name="total_saldo" class="form-control text-right" value="0" disabled></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                        
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-primary">CERRAR CAJA</button>
                    </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section>

<!-- jQuery -->
<script src="/heladeria/public/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/heladeria/public/plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
    $(document).ready(function(){
        $('.btnAbrirModal').on('click', function(){
            $('#cajaEditModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function(){
                return $(this).text();
            }).get();

            console.log(data);
        });
    });
</script>
@endsection



