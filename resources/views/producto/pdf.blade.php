
<style>
    body {
        font-family: Arial, sans-serif;
    }
    table {
        background-color: white;
        text-align: left;
        border-collapse: collapse;
        width: 100%;
        
    }
    td {
        padding: 5px;
        font-size: 9;
    }
    thead{
        background-color: #808B96;
        border-bottom: solid 1px #212F3D;
        color: white;
        font-size: 9;
    }
    tr:nth-child(even){
        background-color: #ddd;
    }
    img.alineadoTextoImagenCentro{
        vertical-align: middle;
        /* Ojo vertical-align: text-middle no existe*/
    }
    @page {
		margin-top: 0.3cm;
		margin-bottom: 0.2cm;
	}
    </style>

<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->

<body>
<div class="container table-responsive">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <img class="alineadoTextoImagenCentro" src="{{ asset('storage/carrito.jpg')}}" width="100px" height="90px"/>
                    <strong><center>INFORME DE PRODUCTOS REGISTRADOS</center></strong>
                    <br>
                    <label style="font-size: 10;" font-family:courier;><center><strong>Fecha emisión: {{ 'ARICA, '.$fecha }}</strong></center></label>
                </div>

                &nbsp;
                &nbsp;
                <div class="card-body">
                    <table class="table table-dark table-striped-columns">
                        <thead>
                            <tr>
                                <th>CATEGORIA</th>
                                <th>MARCA</th>
                                <th>PRODUCTO</th>
                                <th>UNIDAD</th>
                                <th>PRECIO</th>
                                <th>MIN</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($productos as $pro)
                            <tr>
                                <td>{{ $pro->categoria->nombre }}</td>
                                <td>{{ $pro->marca->nombre }}</td>
                                <td>{{ $pro->nombre }}</td>
                                <td style="text-align: center">{{ $pro->unidad->nombre }}</td>
                                <td style="text-align: right">{{ '$ '.$pro->precio_unid }}</td>
                                <td style="text-align: center">{{ $pro->min }}</td>
                            </tr>                            
                        @endforeach
                        </tbody>
                    </table>
                    <p>
                        <hr style="size=2px; color=black;" />
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>