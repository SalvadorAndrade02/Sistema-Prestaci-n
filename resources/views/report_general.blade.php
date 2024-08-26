<!-- resources/views/report.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>Informe de Usuarios</title>
    <style>
        /* Puedes añadir estilos aquí para el PDF */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Informe de Usuarios</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
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
                <td>{{ $report->id }}</td>
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
</body>

</html>