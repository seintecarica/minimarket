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
                        <div class="row">
                            <form class="my-4 my-lg-0" method="get">
                                @csrf
                                <div class="row mb-4" style="font-size: 13px; font-family:courier;">
                                    <div class="col-md-4">
                                        <label>BODEGA</label>
                                        <select name="bodega_id" class="form-control" required>
                                            @foreach ($bodegas as $bod)
                                                <option value="{{ $bod->id }}" {{ $bod->id == $bodega_id ? 'selected' : '' }}>{{ $bod->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>DESDE</label>
                                        <input type="date" name="start_date" class="form-control start_date" value="{{ $fecha_inicial }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>HASTA</label>
                                        <input type="date" name="end_date" class="form-control end_date" value="{{ $fecha_final }}">
                                    </div>
                                    <div class="col-md-4 mt-4">
                                        <label> </label>
                                        <button type="submit" class="btn btn-secondary" style="font-size: 15px">Filtrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('statusError'))
                        <div class="alert alert-danger" role="alert" style="opacity: 0.5">
                            {{ session('statusError') }}
                        </div>
                    @endif
                    <div id="container"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    // Data retrieved https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature
Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Gráfica de clientes por camión'
    },
    subtitle: {
        //text: 'Source: ' +
        //    '<a href="https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature" ' +
        //    'target="_blank">Wikipedia.com</a>'
        text: ''
    },
    xAxis: {
        categories: <?= $meses_encode ?>
    },
    yAxis: {
        title: {
            text: 'N° de clientes'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Meses seleccionados',
        data: <?= $datos_encode ?>
    }]
});

</script>

@endsection


