<!DOCTYPE html>
<html>

<head>
    <title>Informe de Prestacion</title>
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

        th,
        td {
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
        /* Estilo para la línea de firma */
        .signature-line {
            margin-top: 50px;
            border-top: 1px solid black;
            width: 200px;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }
        .signature-text {
            text-align: center;
            margin-top: 5px;
            font-size: 12px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
</head>

<body>
    <header>
        <img src="images/membrete 1.png" style="width: 105%; height:auto">
    </header>
    <br>
    <img src="images/titulo.png" style="width: 100%; height:auto">
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
        <div class="signature-label">Firma del Responsable</div>
        <div class="signature-line" style="text-align: center;"></div>
    </div>
    <br>
    <footer class="footer">
        <img src="images/menbrete pie.png" style="width: 100%; height:auto">
    </footer>
</body>

</html>