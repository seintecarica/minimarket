@extends("layouts.admin")

@section('titulo')
    <h5>Gestión de Sucursales</h5>
@endsection

@section("contenido")
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>LISTADO DE SUCURSALES</h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Sucursales</li>
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
                        <form action="{{ route('bodega.index') }}" method="get">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" name="texto" placeholder="Buscar nombre sucursal" value="{{$texto}}" aria-label="Recipient's username" aria-describedby="button-addon2">
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
                                    <th>NOMBRE</th>
                                    <th>MOVIL</th>
                                    <th>RESPONSABLE</th>
                                    <th>OBSERVACION</th>
                                    <th>ESTADO</th>
                                    <th colspan="2">OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bodegas as $bod)
                                <tr>
                                    
                                    <td>{{ $bod->nombre}}</td>
                                    <td>{{ $bod->movil}}</td>
                                    <td>{{ $bod->user->name}}</td>
                                    <td>{{ $bod->observacion}}</td>
                                    <td>{{ $bod->estado}}</td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#modalEditar{{ $bod->id }}" title="" class="btn btn-outline-warning btn-sm"><i class="fas fa-pen"></i></a>
                                        
                                        <!-- MODAL DE EDICION-->
                                        <div class="modal fade" id="modalEditar{{ $bod->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Modificar Bodega</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <form action="{{ route('bodega.edit', $bod->id) }}" method="POST">
                                                        @csrf
                                                    <div class="modal-body">
                                                        <div class="row mb-12">
                                                            <div class="form-group col-md-8">
                                                                <label>Nombre *</label>
                                                                <input type="text" name="nombre" class="form-control" value="{{ $bod->nombre }}" required>
                                                            </div>
                                        
                                                            <div class="form-group col-md-4">
                                                                <label>Movil *</label>
                                                                <select name="movil" class="form-control" required>
                                                                    <option value="SI" {{ $bod->movil == "SI" ? 'selected' : '' }}>SI</option>
                                                                    <option value="NO" {{ $bod->movil == "NO" ? 'selected' : '' }}>NO</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                        
                                                        <div class="row mb-12"> 
                                                            <div class="form-group col-md-12">
                                                                <label>Responsable *</label>
                                                                <select name="usuario_id" class="form-control" required>
                                                                    @foreach ($usuarios as $usu)
                                                                        <option value="{{ $usu->id }}" {{ $usu->id == $bod->responsable_id ? 'selected' : ''}}>{{ $usu->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                        
                                                        <div class="row mb-12">
                                                            <div class="form-group col-md-12">
                                                                <label>Observación</label>
                                                                <textarea name="observacion" class="form-control" rows="2" placeholder="Observación">{{ $bod->observacion }}</textarea>
                                                            </div>
                                                        </div>
                                        
                                                        <div class="row mb-12">
                                                            <div class="form-group col-md-6">
                                                                <label>Estado *</label>
                                                                <select name="estado" id="" class="form-control" required>
                                                                    <option value="VIGENTE" {{ $bod->estado == "VIGENTE" ? 'selected' : '' }}>VIGENTE</option>
                                                                    <option value="NO VIGENTE" {{ $bod->estado == "NO VIGENTE" ? 'selected' : '' }}>NO VIGENTE</option>
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

                                        <!-- Button trigger for danger theme modal -->
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{ $bod->id }}"><i class="fas fa-trash-alt"></i></button>
                                        
                                        <!-- MODAL ELIMINACION-->
                                        <div class="modal fade" id="modal-delete-{{ $bod->id }}">
                                            <div class="modal-dialog">
                                                <form action="{{ route('bodega.destroy', $bod->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-content bg-danger">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Anular bodega</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Deseas eliminar la bodega {{ $bod->nombre }}</p>
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
                        {{ $bodegas->links("pagination::bootstrap-4") }}
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
                <h4 class="modal-title">Nueva Bodega</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('bodega.create') }}" method="POST">
                @csrf
            <div class="modal-body">
                <div class="row mb-12">
                    <div class="form-group col-md-9">
                        <label>Nombre *</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ingrese nombre de la bodega" required>
                    </div>

                    <div class="form-group col-md-3">
                        <label>Movil *</label>
                        <select name="movil" class="form-control" required>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-12">
                    <div class="form-group col-md-6">
                        <label>Responsable *</label>
                        <select name="usuario_id" class="form-control" required>
                            @foreach ($usuarios as $usu)
                                <option value="{{ $usu->id }}">{{ $usu->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-12">
                    <div class="form-group col-md-12">
                        <label>Observación</label>
                        <textarea name="observacion" class="form-control" rows="2" placeholder="Observación"></textarea>
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

