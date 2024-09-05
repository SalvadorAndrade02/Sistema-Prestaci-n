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
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-bold-rounded/css/uicons-bold-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-straight/css/uicons-regular-straight.css'>
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
                    <div class="columns">
                        <div class="column is-9">
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#ModalAgregar">
                                <i class="fi fi-br-plus"></i> Agregar Prestación
                            </button>
                        </div>
                        <div class="column is-3">
                            <form action="{{ route('reporteGeneral.pdf') }}" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-elegant" style="padding: 12px, 24px;">
                                    <i style="color: black;" class="fi fi-sr-document-signed"></i> Generar Informe
                                </button>
                            </form>
                            <style>
                                .btn-elegant {
                                    background-color: gray;
                                    /* Verde elegante */
                                    border: none;
                                    color: black;
                                    padding: 12px 24px;
                                    text-align: center;
                                    text-decoration: none;
                                    display: inline-block;
                                    font-size: 16px;
                                    margin: 4px 2px;
                                    cursor: pointer;
                                    transition-duration: 0.4s;
                                    border-radius: 12px;
                                }

                                .btn-elegant:hover {
                                    background-color: white;
                                    color: #4CAF50;
                                    border: 2px solid #4CAF50;
                                }

                                .btn-elegant i {
                                    margin-right: 8px;
                                    /* Espacio entre el ícono y el texto */
                                }
                            </style>
                        </div>
                    </div>
                    <!-- Modal de Agregar -->
                    <div class="modal fade" id="ModalAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: black;">Agregar Prestación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="addForm" action="{{ route('prestamos.storeOrUpdate') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="tables" style="color: black">Seleccione un área:</label>
                                            <select class="form-select" aria-label="Default select example" name="table" id="tables">
                                                <option value="">-- Selecciona un área --</option>
                                                @foreach($filteredTables as $table)
                                                <option value="{{ $table }}">{{ $table }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label style="color:black">Nombre de quien recibe</label>
                                            <input type="text" class="form-control" name="nombreRecibe" id="nombreRecibe">
                                        </div>
                                        <div class="mb-3">
                                            <label style="color:black">Artículo a Prestar</label>
                                            <select class="form-select" aria-label="Default select example" name="tool" id="tools">
                                                <option value="">-- Selecciona un artículo --</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label style="color:black">Cantidad a prestar</label>
                                            <input type="number" class="form-control" name="cantidad" id="cantidad">
                                        </div>
                                        <div class="mb-3">
                                            <label class="alert alert-primary" style="color:black">Cantidad disponible del artículo:</label>
                                            <input type="text" class="form-control alert alert-primary" id="cantidadDisponible" readonly>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label style="color:black">Fecha de Salida</label>
                                                <input style="color:black" type="date" class="form-control" name="fechaSalida" id="fechaSalida">
                                            </div>
                                            <div class="col">
                                                <label style="color:black">Fecha de Regreso</label>
                                                <input style="color:black" type="date" class="form-control" name="fechaRegreso" id="fechaRegreso">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label style="color:black" for="exampleFormControlTextarea1" class="form-label">Observación de entrega</label>
                                            <textarea class="form-control" name="observacion" id="observacion" rows="3"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label style="color:black">Uso</label>
                                            <input type="text" class="form-control" name="uso" id="uso">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary" form="addForm">Agregar</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <table class="table table-dark table-borderless">
                        <thead>
                            <tr>
                                <!-- <th scope="col">ID</th> -->
                                <th scope="col">Área</th>
                                <th scope="col">Nombre quien recibe</th>
                                <th scope="col">Artículo a Prestar</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Fecha de Salida</th>
                                <th scope="col">Fecha de Regreso</th>
                                <th scope="col">Observación</th>
                                <th scope="col">Uso</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th scope="col">Reporte</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prestamos as $prestacion)
                            <tr>
                                <!-- <td>{{ $prestacion->id }}</td> -->
                                <td>{{ $prestacion->area }}</td>
                                <td>{{ $prestacion->nombreRecibe }}</td>
                                <td>{{ $prestacion->articulo }}</td>
                                <td>{{ $prestacion->cantidadPresta }}</td>
                                <td>{{ $prestacion->fechaSalida }}</td>
                                <td>{{ $prestacion->fechaRegreso }}</td>
                                <td>{{ $prestacion->observacion }}</td>
                                <td>{{ $prestacion->uso }}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#ModalEditar{{ $prestacion->id }}">
                                        <i class="fi fi-br-pencil"></i>
                                    </button>
                                    <!-- Modal de Editar -->
                                    <div class="modal fade" id="ModalEditar{{ $prestacion->id }}" tabindex="-1" aria-labelledby="ModalEditarLabel{{ $prestacion->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="ModalEditarLabel{{ $prestacion->id }}" style="color: black;">Actualizar Prestación</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('prestamos.storeOrUpdate', $prestacion->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="tables{{$prestacion->id}}" style="color: black">Seleccione un área:</label>
                                                            <select class="form-select" aria-label="Default select example" name="table" id="tables{{$prestacion->id}}">
                                                                <option value=""> </option>
                                                                @foreach($filteredTables as $table)
                                                                <option value="{{ $table }}" {{ $prestacion->area == $table ? 'selected' : '' }}>{{ $table }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="nombreRecibe{{$prestacion->id}}" style="color:black">Nombre de quien recibe</label>
                                                            <input type="text" class="form-control" name="nombreRecibe" id="nombreRecibe{{$prestacion->id}}" value="{{$prestacion->nombreRecibe}}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tools{{$prestacion->id}}" style="color:black">Artículo a Prestar</label>
                                                            <select class="form-select" aria-label="Default select example" name="tool" id="tools{{$prestacion->id}}">
                                                                <option value="{{$prestacion->articulo}}">{{$prestacion->articulo}}</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="cantidad{{$prestacion->id}}" style="color:black">Cantidad a prestar</label>
                                                            <input type="number" class="form-control" name="cantidad" id="cantidad{{$prestacion->id}}" value="{{$prestacion->cantidadPresta}}">
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col">
                                                                <label for="fechaSalida{{$prestacion->id}}" style="color:black">Fecha de Salida</label>
                                                                <input style="color:black" type="date" class="form-control" name="fechaSalida" id="fechaSalida{{$prestacion->id}}" value="{{$prestacion->fechaSalida}}">
                                                            </div>
                                                            <div class="col">
                                                                <label for="fechaRegreso{{$prestacion->id}}" style="color:black">Fecha de Regreso</label>
                                                                <input style="color:black" type="date" class="form-control" name="fechaRegreso" id="fechaRegreso{{$prestacion->id}}" value="{{$prestacion->fechaRegreso}}">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label style="color:black" for="observacion{{$prestacion->id}}" class="form-label">Observación de entrega</label>
                                                            <textarea class="form-control" name="observacion" id="observacion{{$prestacion->id}}" rows="3">{{$prestacion->observacion}}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="uso{{$prestacion->id}}" style="color:black">Uso</label>
                                                            <input type="text" class="form-control" name="uso" id="uso{{$prestacion->id}}" value="{{$prestacion->uso}}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#devolucionModal" data-id="{{ $prestacion->id }}">
                                        <i class="fi fi-rs-restock"></i>
                                    </button>

                                    <!-- Modal de Devolucion -->
                                    <div class="modal fade" id="devolucionModal" tabindex="-1" aria-labelledby="devolucionModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="devolucionModalLabel" style="color: black;">Confirmar Devolución</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="color: black;">
                                                    ¿Estás seguro de que quieres devolver este artículo?
                                                </div>
                                                <div class="modal-footer">
                                                    <form id="devolucionForm" method="POST" action="">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-success">Confirmar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var devolucionModal = document.getElementById('devolucionModal');
                                            devolucionModal.addEventListener('show.bs.modal', function(event) {
                                                var button = event.relatedTarget; // Botón que disparó el modal
                                                var prestamoId = button.getAttribute('data-id'); // Extraer el ID

                                                var form = document.getElementById('devolucionForm');
                                                form.action = '/prestamos/' + prestamoId + '/devolucion'; // Establecer la acción del formulario
                                            });
                                        });
                                    </script>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#ModalDelete{{$prestacion->id}}">
                                        <i class="fi fi-sr-trash"></i>
                                    </button>
                                    <!-- Modal de eliminar -->
                                    <div class="modal fade" id="ModalDelete{{$prestacion->id}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$prestacion->id}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel{{$prestacion->id}}" style="color: black;">Eliminar Prestación</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p style="color: black;">¿Seguro desea eliminar esta prestación?</p>
                                                    <form action="{{ route('prestaciones.destroy', $prestacion->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td> <!-- Botón para generar PDF -->
                                    <form action="{{ route('prestacion.pdf', $prestacion->id) }}" method="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary"><i class="fi fi-ss-document-signed"></i></button>
                                    </form>
                                </td>
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