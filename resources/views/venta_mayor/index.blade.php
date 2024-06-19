@extends("layouts.admin")

@section("contenido")
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>LISTADO DE VENTAS</h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Ventas</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Hoverable rows start -->
<section class="section">
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-xl-12">
                        <form action="{{ route('venta_mayor.index') }}" method="get">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" name="folio" placeholder="Buscar por n° de factura" value="{{$folio}}" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Buscar</button>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <span class="input-group-text " id="basic-addon1"><i class="bi bi-plus-circle-fill"></i></span>
                                        <a href="" data-toggle="modal" {{ ($nro_cabierta > 0) ? "data-target=#modNuevaVenta" : 'data-target=#modNuevaCaja' }} class="btn btn-success">Nueva</a>
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
                    <!-- table hover -->
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-secondary">
                                <tr>
                                    <th>FOLIO</th>
                                    <th>BODEGA</th>
                                    <th>F. REGISTRO</th>
                                    <th>F. PAGO</th>
                                    <th>TOTAL</th>
                                    <th>ESTADO</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ventas as $ve)
                                <tr>
                                    
                                    <td>{{ $ve->id}}</td>
                                    <td>{{ $ve->nombre_bodega}}</td>
                                    <td>{{ date('d-m-Y', strtotime($ve->created_at)) }}</td>
                                    <td>{{ $ve->pago}}</td>
                                    <td style="text-align: right" >{{ "$ ".$ve->total}}</td>
                                    <td>{{ $ve->estado}}</td>
                                    <td>
                                        <!-- Button trigger for danger theme modal -->
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{ $ve->id }}"><i class="fas fa-trash-alt"></i></button>
                                        
                                        <!-- MODAL ELIMINACION-->
                                        <div class="modal fade" id="modal-delete-{{ $ve->id }}">
                                            <div class="modal-dialog">
                                                <form action="{{ route('venta_mayor.destroy', $ve->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-content bg-danger">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Anular Factura</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Deseas eliminar la factura n° {{ $ve->id }}</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
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
                        {{ $ventas->links("pagination::bootstrap-4") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MODAL DE CAJA-->
<div class="modal fade" id="modNuevaCaja">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">CAJA CHICA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Se necesita realizar una nueva apertura de caja.</p>
            </div>
            <div class="modal-body">
                <!-- AQUI VA EL FORMULARIO-->
                <form action="{{ route('caja.create') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Valor caja inicial *</label>
                        <input type="text" id="caja" name="caja" class="form-control" required>
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- FIN MODAL DE CAJA-->

<!-- MODAL DE CREACION-->
<div class="modal fade" id="modNuevaVenta">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Venta de productos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('venta_mayor.create') }}" method="POST">
                @csrf
            <div class="modal-body">
                <!-- AQUI VA EL FORMULARIO-->
                <div class="row mb-16">
                    <div class="form-group col-md-3">
                        <label>Bodega *</label>
                        <select name="bodega_id" class="form-control" required>
                            <option value="{{ $bodegas->id }}">{{ $bodegas->nombre }}</option>
                        </select>
                    </div>
                
                    <div class="form-group col-md-3">
                        <label>Forma pago *</label>
                        <select name="pago_id" class="form-control" required>
                            @foreach ($pagos as $pago)
                                <option value="{{ $pago->id }}">{{ $pago->nombre }}</option>
                            @endforeach
                        </select>
                    </div>  
                </div>

                <hr/>

                <div class="row mb-12">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="producto">Producto</label>
                            <select name="producto_id" id="producto_id" class="form-control selectpicker" data-live-search="true">
                                @foreach($productos as $prod)
                                <option value="{{ $prod->id }}_{{ $prod->precio_unid }}_{{ $prod->cantidad }}">{{ $prod->codigo.' - '.$prod->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="cantidad">Cant</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" >
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="cantidad">Stock</label>
                            <input type="number" class="form-control" disabled id="stock" name="stock" >
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="costo">P. Venta</label>
                            <input type="number" class="form-control" disabled id="p_venta" name="p_venta">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="accion">Acción</label>
                            <button type="button" id="bt_add" class="btn btn-block btn-outline-success">Agregar</button>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="table-responsive">
                        <table id="detalle" class="table table-hover mb-0">
                            <thead style="background-color:#ABD0F5">
                                <tr>
                                    <th>OPCIONES</th>
                                    <th>PRODUCTO</th>
                                    <th>CANTIDAD</th>
                                    <th>P. VENTA</th>
                                    <th>SUBTOTAL</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th><h6>TOTAL</h6></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h6 id="total">$ 0</h6></th>
                                    <input type="hidden" name="total_venta" id="total_venta">
                                </tr>                                    
                            </tfoot>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- FIN MODAL DE CREACION-->

@push('scripts')
<script>
    total = 0;
    var cont = 0;
    subtotal = [];

    $(document).ready(function(){
        $('#bt_add').click(function(){
            agregar();
        })
    })
    
    $("#guardar").hide();
    $("#producto_id").change(mostrarValores);

    function mostrarValores(){
        datosProducto = document.getElementById('producto_id').value.split('_');
        $("#p_venta").val(datosProducto[1]);
        $("#stock").val(datosProducto[2]);
        $("#cantidad").focus();
    }

    function agregar(){
        datosProducto = document.getElementById('producto_id').value.split('_');

        producto_id = datosProducto[0];
        producto = $("#producto_id option:selected").text();
        cantidad = parseInt($("#cantidad").val());
        precio = $("#p_venta").val();
        stock = parseInt($("#stock").val());

        if(producto_id != "" && cantidad != "" && cantidad > 0 && precio != ""){
            if(cantidad <= stock){
                subtotal[cont] = (cantidad * precio);
                total = total + subtotal[cont];

                var fila = '<tr class="selected" id="fila'+ cont +
                '"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+
                ');">x</button></td><td><input type="hidden" name="producto_id[]" value="'+producto_id+'">'+producto+
                '</td><td><input type="number" name="cantidad[]" value="' +cantidad+
                '"></td><td><input type="number" name="precio_unit[]" value="'+precio+'"></td><td>' +subtotal[cont]+
                '</td></tr>';

                cont++;
                limpiar();
                $("#total").html("$ "+total);
                $("#total_venta").val(total);
                evaluar();
                $('#detalle').append(fila);
            }
            else{
                alert("La cantidad a vender supera el stock.");
            }
        }else{
            alert("Error al ingresar el detalle de la factura, revise los datos del ar´ticulo.");
        }
    }

    function evaluar(){
        if(total > 0){
            $("#guardar").show();
        }else{
            $("#guardar").hide();
        }
    }

    function limpiar(){
        $("#cantidad").val("");
        $("#p_venta").val("");
        $("#stock").val("");
    }

    function eliminar(index){
        total = total - subtotal[index];
        $("#total").html("$ "+total);
        $("#total_venta").val(total);
        $("#fila" + index).remove();
        evaluar();
    }


</script>
@endpush

@endsection

