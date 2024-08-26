<!DOCTYPE html>
<html>
<head>
    <title>Informe de Prestacion</title>
    <style>
        .signature-line {
            margin-top: 50px;
            margin-left: 250px;
            border-top: 1px solid black;
            text-align: center;
            width: 200px;
        }

        .signature-label {
            margin-top: 10px;
            font-size: 18px;
            text-align: center;
        }

        .signature-container {
            text-align: center;
            margin-top: 100px;
        }

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
</head>

<body>
    <header>
        <img src="images\membrete 1.png" style="margin-left: -50; margin-top: -20">
    </header>
    <br>
    <img src="images\titulo.png" style="margin-left: -50;">
    <br>
    <h1>Datos de Prestación</h1>
    <br>
    <div class="container">
        <table>
            <tr>
                <th>Área</th>
                <td>{{ $prest->area }}</td>
            </tr>
            <tr>
                <th>Nombre de quien recibe</th>
                <td>{{ $prest->nombreRecibe }}</td>
            </tr>
            <tr>
                <th>Articulo Prestado</th>
                <td>{{ $prest->articulo }}</td>
            </tr>
            <tr>
                <th>Cantidad Prestada</th>
                <td>{{ $prest->cantidadPresta }}</td>
            </tr>
            <tr>
                <th>Fecha de Salida</th>
                <td>{{ $prest->fechaSalida }}</td>
            </tr>
            <tr>
                <th>Fecha de Regreso</th>
                <td>{{ $prest->fechaRegreso }}</td>
            </tr>
            <tr>
                <th>Observaciones</th>
                <td>{{ $prest->observacion }}</td>
            </tr>
            <tr>
                <th>Uso de lo prestado</th>
                <td>{{ $prest->uso }}</td>
            </tr>
        </table>
    </div>
    <br>

    <p style="text-align: center;">
        El(la) C: {{$prest->nombreRecibe}}, se compromete a cuidar y entregar en buen estado la herramienta
        que se le entregue como PRESTADA hasta la fecha establecida (o no definida). <br>
        En caso de darse por perdida la herramienta o entregada en mal estado, se deberá de reponer dicho daño/perdida en plazo dado por el area de administración.
    </p>
    <br>
    <div class="signature-container" style="text-align: center;">
        <div class="signature-line" style="text-align: center;"></div>
        <div class="signature-label">Firma del Responsable</div>
    </div>
    <br>
    <footer class="footer">
        <img src="images\menbrete pie.png" style="margin-left: -50;">
    </footer>
</body>

</html>