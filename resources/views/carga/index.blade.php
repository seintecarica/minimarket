@extends("layouts.admin")

@section("contenido")
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>LISTADO DE CARGAS</h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Cargas</li>
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
                        <form action="{{ route('carga.index') }}" method="get">
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
                                    <th>FOLIO</th>
                                    <th>ORIGEN</th>
                                    <th>DESTINO</th>
                                    <th>USUARIO</th>
                                    <th>FECHA</th>
                                    <th>ESTADO</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cargas as $ca)
                                <tr>
                                    
                                    <td>{{ $ca->id}}</td>
                                    <td>{{ $ca->bodega_origen}}</td>
                                    <td>{{ $ca->bodega_destino}}</td>
                                    <td>{{ $ca->name}}</td>
                                    <td>{{ date('d - M - Y', strtotime($ca->created_at))}}</td>
                                    <td>{{ $ca->estado}}</td>
                                    <td>
                                        <!-- Button trigger for danger theme modal -->
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{ $ca->id }}"><i class="fas fa-trash-alt"></i></button>
                                        
                                        <!-- MODAL ELIMINACION-->
                                        <div class="modal fade" id="modal-delete-{{ $ca->id }}">
                                            <div class="modal-dialog">
                                                <form action="{{ route('carga.destroy', $ca->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-content bg-danger">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Anular Carga</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Deseas eliminar la carga n° {{ $ca->folio }}</p>
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
                        {{ $cargas->links("pagination::bootstrap-4") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hoverable rows end -->

<!-- MODAL DE CREACION-->
<div class="modal fade" id="modalNuevo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Nuevo Registro de carga</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('carga.create') }}" method="POST">
                @csrf
            <div class="modal-body">
                <!-- AQUI VA EL FORMULARIO-->
                <div class="row mb-16">
                    <div class="form-group col-md-4">
                        <label>Bodega origen</label>
                        <select name="bodega_origen" class="form-control" required>
                            @foreach ($bodegas as $bod)
                                <option value="{{ $bod->id }}">{{ $bod->nombre }}</option>
                                @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Bodega destino</label>
                        <select name="bodega_destino" class="form-control" required>
                            @foreach ($bodegas as $bod)
                                <option value="{{ $bod->id }}">{{ $bod->nombre }}</option>
                                @endforeach
                        </select>
                    </div>
                </div>

                <hr/>

                <div class="row">
                    <div class="col-7">
                        <div class="form-group">
                            <label for="producto">Producto</label>
                            <select name="producto_id" id="producto_id" class="form-control selectpicker" data-live-search="true">
                                @foreach($productos as $prod)
                                <option value="{{ $prod->id }}">{{ $prod->nombre.' ( '.$prod->cantidad.' )  -  BODEGA: '.$prod->bodega }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <label for="cantidad">Cant caja</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" >
                        </div>
                    </div>

                    <div class="col-3">
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
                                </tr>
                            </thead>
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
    var cont = 0;

    $(document).ready(function(){
        $('#bt_add').click(function(){
            agregar();
        })
    })
    
    $("#guardar").hide();
    $("#producto_id").change(mostrarValores);

    function mostrarValores(){
        datosProducto = document.getElementById('producto_id').value.split('_');
        $("#cantidad").val(datosProducto[1]);
    }

    function agregar(){
        datosProducto = document.getElementById('producto_id').value.split('_');

        producto_id = datosProducto[0];
        producto = $("#producto_id option:selected").text();
        cantidad = $("#cantidad").val();

        if(producto_id != "" && cantidad != "" && cantidad > 0){

            var fila = '<tr class="selected" id="fila'+ cont +
                '"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+
                ');">x</button></td><td><input type="hidden" name="producto_id[]" value="'+producto_id+'">'+producto+
                '</td><td><input type="number" name="cantidad[]" value="' +cantidad+
                '"></td></tr>';
            cont++;
            limpiar();

            evaluar();
            $('#detalle').append(fila);
        }else{
            alert("Error al ingresar el detalle de la carga, revise los datos del articulo.");
        }
    }

    function evaluar(){
        //if(total > 0){
            $("#guardar").show();
        //}else{
            //$("#guardar").hide();
        //}
    }

    function limpiar(){
        $("#cantidad").val("");
    }

    function eliminar(index){
        $("#fila" + index).remove();
        evaluar();
    }


</script>
@endpush

@endsection

