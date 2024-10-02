<!DOCTYPE html>
<html>

<head>
    <title>Informe de Usuarios</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Configuración de márgenes y elementos en la página */
        @page {
            margin: 150px 50px 100px 50px;
        }

        header {
            position: fixed;
            top: -120px;
            left: 0;
            right: 0;
            height: 100px;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: -70px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 12px;
        }

        .content {
            margin-top: 20px;
            margin-bottom: 50px;
        }

        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .bg-disponible {
            background-color: #d4edda;
        }

        .bg-ocupado {
            background-color: #f8d7da;
        }
    </style>
</head>

<body>
    <header>
        <img src="images/membrete 1.png" style="width: 105%; height:auto">
    </header>
    <div class="content">
        <img src="images/titulo.png" style="width: 100%; height:auto">
        <h1>Informe Mensual de Prestaciones</h1>
        <table>
            <thead>
                <tr>
                    <th>Área</th>
                    <th>Nombre quien recibe</th>
                    <th>Artículo a Prestar</th>
                    <th>Cantidad</th>
                    <th>Fecha de Salida</th>
                    <th>Fecha de Regreso</th>
                    <th>Observación</th>
                    <th>Uso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reporte as $report)
                <tr>
                    <td>{{ $report->area }}</td>
                    <td>{{ $report->nombreRecibe }}</td>
                    <td>{{ $report->articulo }}</td>
                    <td>{{ $report->cantidadPresta }}</td>
                    <td>{{ $report->fechaSalida }}</td>
                    <td>{{ $report->fechaRegreso }}</td>
                    <td>{{ $report->observacion }}</td>
                    <td>{{ $report->uso }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <footer class="footer">
        <img src="images/menbrete pie.png" style="width: 100%; height:auto">
    </footer>
</body>

</html>