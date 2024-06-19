@extends("layouts.admin")

@section("contenido")
<!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>REGISTRO DE FACTURAS</h5>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Facturas</li>
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
                    <form action="{{ route('factura.store') }}" method="POST">
                        @csrf
                        <div class="card-header">
                            <!--FORMULARIO DE PRODUCTOS -->
                            <div class="row mb-12">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="producto">Producto</label>
                                        <select name="producto_id" id="producto_id" class="form-control selectpicker" data-live-search="true">
                                            @foreach($productos as $prod)
                                            <option value="{{ $prod->id }}_{{ $prod->precio_unid }}_{{ $prod->cantidad }}">{{ $prod->codigo.' - '.$prod->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="accion">Acción</label>
                                        <a href="" data-toggle="modal" data-target="#modalNuevo" class="btn btn-secondary">Crear</a>
                                    </div>
                                </div>
            
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="cantidad">Cant.</label>
                                        <input type="number" class="form-control" id="cant_previa" name="cant_previa" >
                                    </div>
                                </div>
            
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="costo">P. Costo</label>
                                        <input type="number" class="form-control" id="p_costo" name="p_costo">
                                    </div>
                                </div>
            
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="accion">Acción</label>
                                        <button type="button" id="bt_add" class="btn btn-block btn-outline-success">Agregar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-content">
                            <div class="card-body">
                                <!--DETALLE DE VENTA -->
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="detalle" class="table table-hover mb-0">
                                            <thead style="background-color:rgba(207, 212, 218, 0.897)">
                                                <tr>
                                                    <th>OPCIONES</th>
                                                    <th>PRODUCTO</th>
                                                    <th>CANTIDAD</th>
                                                    <th>P. COSTO</th>
                                                    <th>SUBTOTAL</th>
                                                </tr>
                                            </thead>
                
                                            <tfoot>
                                                <tr>
                                                    <th><h6>T. NETO</h6></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th><h6 id="total">$ 0</h6></th>
                                                    <input type="hidden" name="t_neto" id="t_neto">
                                                </tr>
                                                <tr>
                                                    <th><h6>TOTAL + IVA</h6></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th><h6 id="total_iva">$ 0</h6></th>
                                                    <input type="hidden" name="t_iva" id="t_iva">
                                                </tr>                               
                                            </tfoot>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <!--ENCABEZADO DE FORMULARIO -->
                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label>Folio *</label>
                                            <input type="text" name="folio" value="{{ old('folio') }}" class="form-control" placeholder="Ingrese n° factura" required>
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Bodega *</label>
                                            <select name="bodega_id" class="form-control" required>
                                                @foreach ($bodegas as $bod)
                                                <option value="{{ $bod->id }}">{{ $bod->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Marca *</label>
                                            <select name="marca_id" class="form-control" required>
                                                <option value="0"></option>
                                                @foreach ($marcas as $mar)
                                                <option value="{{ $mar->id }}" {{ old('marca_id') == $mar->id ? 'selected' : '' }}>{{ $mar->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-default" onclick="limpiar()">Cancelar</button>
                                <button type="submit" class="btn btn-primary" id="submit">Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Hoverable rows end -->

    <!-- MODAL DE CREACION-->
    <div class="modal fade" id="modalNuevo">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nuevo Producto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('producto.create', $origen) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-12">
                        <div class="form-group col-md-12">
                            <label>Nombre*</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ingrese nombre del producto" value="">
                        </div>
                    </div>
                    <div class="row mb-12">
                        <div class="form-group col-md-8">
                            <label>Codigo*</label>
                            <input type="text" name="codigo" class="form-control" placeholder="Código de barras" value="">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Tipo unidad*</label>
                            <select name="unidad_id" class="form-control" required>
                                @foreach ($unidades as $unid)
                                    <option value="{{ $unid->id }}">{{ $unid->nombre }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-12">
                        <div class="form-group col-md-8">
                            <label>Categoria*</label>
                            <select name="categoria_id" class="form-control" required>
                                @foreach ($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Stock min</label>
                            <input type="text" name="min" class="form-control" value="0" required>
                        </div>
                    </div>

                    <div class="row mb-12">
                        <div class="form-group col-md-8">
                            <label>Marca*</label>
                            <select name="marca_id" class="form-control" required>
                                @foreach ($marcas as $mar)
                                    <option value="{{ $mar->id }}">{{ $mar->nombre }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>P Venta*</label>
                            <input type="text" name="precio_unid" class="form-control" value="" required>
                        </div>
                    </div>

                    <div class="row mb-12">
                        <div class="form-group col-md-4">
                            <label>Estado*</label>
                            <select name="estado" id="" class="form-control" required>
                                <option value="VIGENTE">VIGENTE</option>
                                <option value="NO VIGENTE">NO VIGENTE</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
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
        //$("#cant_previa").val(datosProducto[2]);
        //$("#p_costo").val(datosProducto[1]);
    }

    function agregar(){
        datosProducto = document.getElementById('producto_id').value.split('_');

        producto_id = datosProducto[0];
        producto = $("#producto_id option:selected").text();
        cantidad = $("#cant_previa").val();
        costo_unit = $("#p_costo").val();

        if(producto_id != "" && cantidad != "" && cantidad > 0 && costo_unit != ""){
            subtotal[cont] = (cantidad * costo_unit);
            total = total + subtotal[cont];

            var fila = '<tr class="selected" id="fila'+ cont +
                '"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+
                ');">x</button></td><td><input type="hidden" name="producto_id[]" value="'+producto_id+'">'+producto+
                '</td><td><input type="number" name="cantidad[]" value="' +cantidad+
                '"></td><td><input type="number" name="costo_unit[]" value="'+costo_unit+'"></td><td>' +subtotal[cont]+
                '</td></tr>';
            cont++;
            limpiar();
            $("#total").html("$ "+total);
            $("#total_iva").html("$ "+(total + (total * 0.19)));

            $("#t_neto").val(total);
            $("#t_iva").val((total + (total * 0.19)));

            evaluar();
            $('#detalle').append(fila);

            $("#producto_id").select2();
            $('#producto_id').trigger('click');

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
        $("#costo_unit").val("");

        $("#cant_previa").val("");
        $("#p_costo").val("");
    }

    function eliminar(index){
        total = total - subtotal[index];
        $("#total").html("$ "+total);
        $("#total_iva").html("$ "+(total + (total * 0.19)));

        $("#t_neto").val(total);
        $("#t_iva").val((total + (total * 0.19)));

        $("#fila" + index).remove();
        evaluar();
    }
</script>
@endpush

@endsection

