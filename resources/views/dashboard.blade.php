<x-app-layout>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tables').on('change', function() {
                var tableName = $(this).val();
                if (tableName) {
                    // Obtener columnas
                    $.ajax({
                        url: '/fetch-columns',
                        method: 'GET',
                        data: {
                            table: tableName
                        },
                        success: function(columns) {
                            var columnHtml = '<label for="column">Selecciona una columna:</label><select name="column" id="column">';
                            $.each(columns, function(index, column) {
                                columnHtml += '<option value="' + column + '">' + column + '</option>';
                            });
                            columnHtml += '</select>';
                            $('#column-selection').html(columnHtml);
                        },
                        error: function() {
                            $('#column-selection').html('<p>Error loading columns.</p>');
                        }
                    });

                    // Obtener datos
                    $.ajax({
                        url: '/fetch-table-data',
                        method: 'GET',
                        data: {
                            table: tableName
                        },
                        success: function(data) {
                            var dataHtml = '<label for="data">Selecciona un dato:</label><select name="data" id="data">';
                            $.each(data, function(index, row) {
                                dataHtml += '<option value="' + row.id + '">' + JSON.stringify(row) + '</option>';
                            });
                            dataHtml += '</select>';
                            $('#data-selection').html(dataHtml);
                        },
                        error: function() {
                            $('#data-selection').html('<p>Error loading data.</p>');
                        }
                    });
                } else {
                    $('#column-selection').html('');
                    $('#data-selection').html('');
                }
            });

            $('#column, #data').on('change', function() {
                var tableName = $('#tables').val();
                var column = $('#column').val();
                var value = $('#data').val();

                if (tableName && column && value) {
                    $.ajax({
                        url: '/fetch-data-by-column',
                        method: 'GET',
                        data: {
                            table: tableName,
                            column: column,
                            value: value
                        },
                        success: function(data) {
                            var dataHtml = '<h3>Campo '
                            cantidad, ' filtrado:</h3><ul>';
                            $.each(data, function(index, amount) {
                                dataHtml += '<li>' + amount + '</li>';
                            });
                            dataHtml += '</ul>';
                            $('#filtered-data').html(dataHtml);
                        },
                        error: function() {
                            $('#filtered-data').html('<p>Error loading filtered data.</p>');
                        }
                    });
                } else {
                    $('#filtered-data').html('');
                }
            });
        });
    </script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <section class="hero" style="background-color: #1F2937;">
        <div class="hero-body">
            <p class="title">Prestación de herramienta</p>
        </div>
    </section>
    <br>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="" style="background-color:#1F2937">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- {{ __("You're logged in!") }} -->

                    <h1>Prestaciones Realizadas</h1>
                    <br>
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <!-- Botón añadido aquí -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalAgregar">
                        <i class="fi fi-rr-square-plus"></i> Agregar Prestación
                    </button>
                    <br><br>
                    <!-- Modal -->
                    <div class="modal fade" id="ModalAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: black;">Agregar Prestación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <label for="tables" style="color: black">Seleccione un área:</label>
                                        <select class="form-select" aria-label="Default select example" name="tables" id="tables">
                                            <option value="">-- Selecciona un área --</option>
                                            @foreach($filteredTables as $table)
                                            <option value="{{ $table }}">{{ $table }}</option>
                                            @endforeach
                                        </select>
                                        <label style="color:black">Nombre de quien recibe</label>
                                        <input type="text" class="form-control" name="nombreRecibe" id="nombreRecibe">
                                        <label style="color:black">Artículo a Prestar</label>
                                        <select class="form-select" aria-label="Default select example" name="tools" id="tools">
                                            <option value="">-- Selecciona un artículo --</option>
                                        </select>
                                        <br>
                                        <label style="color:black">Cantidad a prestar</label>
                                        <input type="number" class="form-control" name="cantidad" id="cantidad">
                                        <br>
                                        <label class="alert alert-primary" style="color:black">Cantidad disponible del artículo:</label>
                                        <input type="text" class="form-control alert alert-primary" id="cantidadDisponible" readonly>

                                        <div class="columns">
                                            <div class="column">
                                                <label style="color:black">Fecha de Salida</label>
                                                <br>
                                                <input style="color:black" type="date" name="fechaSalida" id="fechaSalida">
                                            </div>
                                            <div class="column">
                                                <label style="color:black">Fecha de Regreso</label>
                                                <br>
                                                <input style="color:black" type="date" name="fechaRegreso" id="fechaRegreso">
                                            </div>
                                        </div>
                                        <label style="color:black" for="exampleFormControlTextarea1" class="form-label">Observación de entrega</label>
                                        <textarea class="form-control" id="observacion" rows="3"></textarea>

                                        <label style="color:black">Uso</label>
                                        <input type="text" class="form-control" name="uso" id="uso">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-dark table-hover">
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
                            @foreach($prestamos as $dato)
                            <tr>
                                <td>{{ $dato->id }}</td>
                                <td>{{ $dato->tables }}</td>
                                <td>{{ $dato->nombreRecibe }}</td>
                                <td>{{ $dato->tools }}</td>
                                <td>{{ $dato->cantidad }}</td>
                                <td>{{ $dato->fechaSalida }}</td>
                                <td>{{ $dato->fechaRegreso }}</td>
                                <td>{{ $dato->observacion }}</td>
                                <td>{{ $dato->uso }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Incluye jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tables').change(function() {
                var table = $(this).val();
                if (table) {
                    // Solicitud AJAX para obtener los artículos
                    $.ajax({
                        url: '/get-tools/' + table,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#tools').empty();
                            $('#tools').append('<option value="">-- Selecciona un artículo --</option>');
                            $.each(data, function(key, value) {
                                $('#tools').append('<option value="' + value + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('#tools').empty();
                    $('#tools').append('<option value="">-- Selecciona un artículo --</option>');
                }
            });

            $('#tools').change(function() {
                var table = $('#tables').val();
                var tool = $(this).val();
                if (table && tool) {
                    // Solicitud AJAX para obtener la cantidad del artículo seleccionado
                    $.ajax({
                        url: '/get-quantity/' + table + '/' + tool,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#cantidadDisponible').val(data.quantity);
                        }
                    });
                } else {
                    $('#cantidadDisponible').val('');
                }
            });

            $('#prestarBtn').click(function() {
                var table = $('#tables').val();
                var tool = $('#tools').val();
                var cantidad = $('#cantidad').val();
                var nombreRecibe = $('#nombreRecibe').val();
                var fechaPrestamo = $('#fechaPrestamo').val();

                if (table && tool && cantidad && nombreRecibe && fechaPrestamo) {
                    $.ajax({
                        url: '/update-quantity',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            table: table,
                            tool: tool,
                            cantidad: cantidad,
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data.success) {
                                $('#cantidadDisponible').val(data.newQuantity);
                                alert('Préstamo realizado correctamente');
                            } else {
                                alert(data.message);
                            }
                        }
                    });
                } else {
                    alert('Por favor complete todos los campos');
                }
            });
        });
    </script>
</x-app-layout>