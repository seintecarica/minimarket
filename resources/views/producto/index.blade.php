@extends("layouts.admin")

@section('titulo')
    <h5>Gestión de productos</h5>
@endsection

@section("contenido")
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>LISTADO DE PRODUCTOS</h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Productos</li>
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
                        <form action="{{ route('producto.index') }}" method="get">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" name="texto" placeholder="Buscar por nombre" value="{{$texto}}" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Buscar</button>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-plus-circle-fill"></i></span>
                                        <a href="" data-toggle="modal" data-target="#modalNuevo" class="btn btn-success">Nuevo</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br>
                        <form action="{{ route('producto.pdf') }}" method="get">
                            @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <label>CATEGORIA</label>
                                <select name="categoria_id_sel" class="form-control" required>
                                    <option value="0">TODAS</option>
                                    @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>MARCA</label>
                                <select name="marca_id_sel" class="form-control" required>
                                    <option value="0">TODAS</option>
                                    @foreach($marcas as $ma)
                                    <option value="{{ $ma->id }}">{{ $ma->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="input-group mb-6">
                                    <button class="btn btn-sm btn-secondary" type="submit" id="button-addon2">GENERAR PDF</button>
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
                                    <th>CATEGORIA</th>
                                    <th>PRODUCTO</th>
                                    <th>MARCA</th>
                                    <th>UNIDAD</th>
                                    <th>P. UNIT</th>
                                    <th>MIN.</th>
                                    <th colspan="2">OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $prod)
                                <tr>
                                    <td>{{ $prod->categoria->nombre}}</td>
                                    <td>{{ $prod->nombre}}</td>
                                    <td>{{ $prod->marca->nombre}}</td>
                                    <td>{{ $prod->unidad->nombre}}</td>
                                    <td>{{ $prod->precio_unid}}</td>
                                    <td>{{ $prod->min}}</td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#modalEditar{{ $prod->id }}" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a>
                                        
                                        <!-- MODAL DE EDICION-->
                                        <div class="modal fade" id="modalEditar{{ $prod->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('producto.edit', $prod->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Modificar Producto</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row mb-12">
                                                            <div class="form-group col-md-12">
                                                                <label>Nombre *</label>
                                                                <input type="text" name="nombre" class="form-control" value="{{ $prod->nombre }}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-12">
                                                            <div class="form-group col-md-8">
                                                                <label>Codigo</label>
                                                                <input type="text" name="codigo" class="form-control" placeholder="Código de barras" value="">
                                                            </div>

                                                            <div class="form-group col-md-4">
                                                                <label>Tipo unidad *</label>
                                                                <select name="unidad_id" class="form-control" required>
                                                                    @foreach ($unidades as $unid)
                                                                        <option value="{{ $unid->id }}" {{ $unid->id == $prod->unidad_id ? 'selected' : ''}}>{{ $unid->nombre }}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-12">
                                                            <div class="form-group col-md-8">
                                                                <label>Categoria*</label>
                                                                <select name="categoria_id" class="form-control" required>
                                                                    @foreach ($categorias as $cat)
                                                                        <option value="{{ $cat->id }}" {{ $cat->id == $prod->categoria_id ? 'selected' : ''}}>{{ $cat->nombre }}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-4">
                                                                <label>Stock mín *</label>
                                                                <input type="text" name="min" class="form-control" value="{{ $prod->min }}" required>
                                                            </div>
                                                        </div>
                                        
                                                        <div class="row mb-12">
                                                            <div class="form-group col-md-8">
                                                                <label>Marca *</label>
                                                                <select name="marca_id" class="form-control" required>
                                                                    @foreach ($marcas as $mar)
                                                                        <option value="{{ $mar->id }}" {{ $mar->id == $prod->marca_id ? 'selected' : ''}}>{{ $mar->nombre }}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-4">
                                                                <label>P. Unit*</label>
                                                                <input type="text" name="precio_unid" class="form-control" value="{{ $prod->precio_unid }}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-12">
                                                            <div class="form-group col-md-4">
                                                                <label>Estado *</label>
                                                                <select name="estado" id="" class="form-control" required>
                                                                    <option value="VIGENTE" {{ $prod->estado == "VIGENTE" ? 'selected' : '' }}>VIGENTE</option>
                                                                    <option value="NO VIGENTE" {{ $prod->estado == "NO VIGENTE" ? 'selected' : '' }}>NO VIGENTE</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                    </div>
                                                </div>
                                                </form>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- FIN MODAL DE CREACION-->

                                        <!-- Button trigger for danger theme modal -->
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{ $prod->id }}"><i class="fas fa-trash-alt"></i></button>
                                        
                                        <!-- MODAL ELIMINACION-->
                                        <div class="modal fade" id="modal-delete-{{ $prod->id }}">
                                            <div class="modal-dialog">
                                                <form action="{{ route('producto.destroy', $prod->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-content bg-danger">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Anular producto</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Deseas eliminar el producto {{ $prod->nombre }}</p>
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
                        {{ $productos->links("pagination::bootstrap-4") }}
                    </div>
                </div>
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

@endsection

