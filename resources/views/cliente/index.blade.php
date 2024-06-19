@extends("layouts.admin")

@section('titulo')
    <h5>Gestión de clientes</h5>
@endsection

@section("contenido")
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>LISTADO DE CLIENTES</h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Clientes</li>
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
                        <form action="{{ route('cliente.index') }}" method="get">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" name="texto" placeholder="Buscar nombre cliente" value="{{$texto}}" aria-label="Recipient's username" aria-describedby="button-addon2">
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
                                    <th>RUT</th>
                                    <th>CLIENTE</th>
                                    <th>BODEGA</th>
                                    <th>CONTACTO</th>
                                    <th>TELEFONO</th>
                                    <th>DIRECCION</th>
                                    <th>ESTADO</th>
                                    <th colspan="2">OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientes as $cli)
                                <tr>
                                    
                                    <td>{{ $cli->rut}}</td>
                                    <td>{{ $cli->razon_social}}</td>
                                    <td>{{ $cli->bodega->nombre }}</td>
                                    <td>{{ $cli->contacto}}</td>
                                    <td>{{ $cli->telefono}}</td>
                                    <td>{{ $cli->direccion}}</td>
                                    <td>{{ $cli->estado}}</td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#modalEditar{{ $cli->id }}" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a>
                                        
                                        <!-- MODAL DE EDICION-->
                                        <div class="modal fade" id="modalEditar{{ $cli->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('cliente.edit', $cli->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Modificar Cliente</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row mb-12">
                                                            <div class="form-group col-md-5">
                                                                <label>Rut *</label>
                                                                <input type="text" name="rut" class="form-control" value="{{ $cli->rut }}">
                                                            </div>

                                                            <div class="form-group col-md-7">
                                                                <label>Camión asociado *</label>
                                                                <select name="bodega_id" class="form-control" required>
                                                                    @foreach ($bodegas as $bod)
                                                                        <option value="{{ $bod->id }}" {{ $bod->id == $cli->bodega_id ? 'selected' : ''}}>{{ $bod->nombre }}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                        
                                                        <div class="row mb-12">
                                                            <div class="form-group col-md-12">
                                                                <label>Razón social *</label>
                                                                <input type="text" name="razon" class="form-control" value="{{ $cli->razon_social }}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-12">
                                                            <div class="form-group col-md-6">
                                                                <label>Contacto *</label>
                                                                <input type="text" name="contacto" class="form-control" value="{{ $cli->contacto }}" required>
                                                            </div>
                                        
                                                            <div class="form-group col-md-6">
                                                                <label>Telefono *</label>
                                                                <input type="text" name="telefono" class="form-control" value="{{ $cli->telefono }}" required>
                                                            </div>
                                                        </div>
                                        
                                                        <div class="row mb-12">
                                                            <div class="form-group col-md-12">
                                                                <label>Dirección *</label>
                                                                <input type="text" name="direccion" class="form-control" value="{{ $cli->direccion }}" required>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row mb-12">
                                                            <div class="form-group col-md-6">
                                                                <label>Estado *</label>
                                                                <select name="estado" id="" class="form-control" required>
                                                                    <option value="VIGENTE" {{ $cli->estado == "VIGENTE" ? 'selected' : '' }}>VIGENTE</option>
                                                                    <option value="NO VIGENTE" {{ $cli->estado == "NO VIGENTE" ? 'selected' : '' }}>NO VIGENTE</option>
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
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{ $cli->id }}"><i class="fas fa-trash-alt"></i></button>
                                        
                                        <!-- MODAL ELIMINACION-->
                                        <div class="modal fade" id="modal-delete-{{ $cli->id }}">
                                            <div class="modal-dialog">
                                                <form action="{{ route('cliente.destroy', $cli->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-content bg-danger">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Anular cliente</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Deseas eliminar al cliente {{ $cli->razon_social }}</p>
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
                        {{ $clientes->links("pagination::bootstrap-4") }}
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
                <h4 class="modal-title">Nuevo Cliente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('cliente.create') }}" method="POST">
            @csrf
            <div class="modal-body">
                <!-- AQUI VA EL FORMULARIO-->
                <div class="row mb-12">
                    <div class="form-group col-md-5">
                        <label>Rut *</label>
                        <input type="text" name="rut" class="form-control" required>
                    </div>

                    <div class="form-group col-md-7">
                        <label>Camión asociado *</label>
                        <select name="bodega_id" class="form-control" required>
                            @foreach ($bodegas as $bod)
                                <option value="{{ $bod->id }}">{{ $bod->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-12">
                    <div class="form-group col-md-12">
                        <label>Razón social *</label>
                        <input type="text" name="razon" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-12">
                    <div class="form-group col-md-6">
                        <label>Contacto *</label>
                        <input type="text" name="contacto" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Telefono *</label>
                        <input type="text" name="telefono" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-12">
                    <div class="form-group col-md-12">
                        <label>Dirección *</label>
                        <input type="text" name="direccion" class="form-control" required>
                    </div>
                </div>
                
                <div class="row mb-12">
                    <div class="form-group col-md-6">
                        <label>Estado *</label>
                        <select name="estado" id="" class="form-control" required>
                            <option value="VIGENTE" selected>VIGENTE</option>
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

