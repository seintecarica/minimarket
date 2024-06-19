@extends("layouts.admin")

@section('titulo')
    <h5>Gestión de categorias</h5>
@endsection

@section("contenido")
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>LISTADO DE CATEGORIAS</h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Categorias</li>
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
                        <form action="{{ route('categoria.index') }}" method="get">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" name="texto" placeholder="Buscar categorías" value="{{$texto}}" aria-label="Recipient's username" aria-describedby="button-addon2">
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
                                    <th>ESTADO</th>
                                    <th colspan="2">OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categorias as $cat)
                                <tr>
                                    
                                    <td>{{ $cat->nombre}}</td>
                                    <td>{{ $cat->estado}}</td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#modalEditar{{ $cat->id }}" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a>
                                        
                                        <!-- MODAL DE EDICION-->
                                        <div class="modal fade" id="modalEditar{{ $cat->id }}">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Modificar Categor&iacute;a</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('categoria.edit', $cat->id) }}" method="POST">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label>Nombre categor&iacute;a *</label>
                                                                <input type="text" name="nombre" class="form-control" value="{{ $cat->nombre }}" required>
                                                            </div>
                                        
                                                            <div class="form-group">
                                                                <label>Estado *</label>
                                                                <select name="estado" id="" class="form-control" required>
                                                                    <option value="VIGENTE" {{ $cat->estado == "VIGENTE" ? 'selected' : '' }}>VIGENTE</option>
                                                                    <option value="NO VIGENTE" {{ $cat->estado == "NO VIGENTE" ? 'selected' : '' }}>NO VIGENTE</option>
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- FIN MODAL DE CREACION-->

                                        <!-- Button trigger for danger theme modal -->
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{ $cat->id }}"><i class="fas fa-trash-alt"></i></button>
                                        
                                        <!-- MODAL ELIMINACION-->
                                        <div class="modal fade" id="modal-delete-{{ $cat->id }}">
                                            <div class="modal-dialog">
                                                <form action="{{ route('categoria.destroy', $cat->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-content bg-danger">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Anular categor&iacute;a</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Deseas eliminar la categor&iacute;a {{ $cat->nombre }}</p>
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
                        {{ $categorias->links("pagination::bootstrap-4") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hoverable rows end -->

<!-- MODAL DE CREACION-->
<div class="modal fade" id="modalNuevo">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Nueva Categor&iacute;a</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- AQUI VA EL FORMULARIO-->
                <form action="{{ route('categoria.create') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nombre categor&iacute;a *</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Estado *</label>
                        <select name="estado" id="" class="form-control" required>
                            <option value="VIGENTE" selected>VIGENTE</option>
                            <option value="NO VIGENTE">NO VIGENTE</option>
                        </select>
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- FIN MODAL DE CREACION-->

@endsection

