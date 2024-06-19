@extends("layouts.admin")

@section('titulo')
    <h5>Gestión de Inventario</h5>
@endsection

@section("contenido")
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>LISTADO DE INVENTARIO</h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Inventario</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Hoverable rows start -->
<section class="section">
    <div class="container-fluid">
        <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-xl-12">
                            <form action="{{ route('inventario.index') }}" method="get">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                        <select name="criterio" id="" class="form-control" required>
                                            <option value="BODEGA" {{ $criterio == 'BODEGA' ? 'selected' : ''}}>BODEGA</option>
                                            <option value="PRODUCTO" {{ $criterio == 'PRODUCTO' ? 'selected' : ''}}>PRODUCTO</option>
                                            <option value="CATEGORIA" {{ $criterio == 'CATEGORIA' ? 'selected' : ''}}>CATEGORIA</option>
                                        </select>
                                        &nbsp;&nbsp;&nbsp;
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" name="texto" placeholder="Buscar" value="{{$texto}}" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Buscar</button>
                                    </div>
                                </div>
                            </div>
                            </form>

                            <br>
                            
                            <form action="{{ route('inventario.pdf') }}" method="get">
                                @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="input-group mb-3">
                                        <select name="categoria_id" id="categoria_id" class="form-control" required>
                                            <option value="0">TODAS</option>
                                        @foreach ($categorias as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="input-group mb-6">
                                        <button class="btn btn-secondary" type="submit" id="button-addon2">GENERAR PDF</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="table-responsive">
                        <table id="example1" class="table table-hover mb-0">
                            <thead class="table-secondary">
                                <tr>
                                    <th>BODEGA</th>
                                    <th>CATEGORIA</th>
                                    <th>MARCA</th>
                                    <th>PRODUCTO</th>
                                    <th>TRATAMIENTO</th>
                                    <th>CANTIDAD</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inventario as $inv)
                                <tr {{ $inv->min >= $inv->cantidad ? 'style=color:#DC143C' : '' }}>
                                    <td>{{ $inv->nombre_bodega }}</td>
                                    <td>{{ $inv->nombre_categoria }}</td>
                                    <td>{{ $inv->nombre_marca }}</td>
                                    <td>{{ $inv->nombre_producto }}</td>
                                    <td>{{ $inv->tratamiento == 1 ? 'UNIDAD' : '' }}</td>
                                    <td>{{ $inv->cantidad }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $inventario->links("pagination::bootstrap-4") }}
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hoverable rows end -->

<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

@endsection

