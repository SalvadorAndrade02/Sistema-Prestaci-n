<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestamo;
use Exception;
use Illuminate\Support\Facades\DB;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /* public function index()
    {
        $specificTables = ['paileria', 'tabla_ejemplo', 'users'];
        // Obtener todos los registros de la tabla 'tabla_ejemplo'
        $datos = DB::select('SHOW TABLES');

        // Extrae los nombres de las tablas del resultado
        $datosT = array_map(function ($table) {
            return $table->{'Tables_in_' . env('DB_DATABASE')};
        }, $datos);

        $filteredTables = array_intersect($datosT, $specificTables);

        $prestamos = Prestamo::all();
        return view('dashboard', compact('prestamos', 'filteredTables'));
    } */

    public function index(Request $request)
    {
        // List of specific tables to display in the dashboard
        $specificTables = ['almacen', 'ingenieria', 'oficina_administrativa', 'paileria'];

        // Get all table names in the database
        $tablesInDatabase = DB::select('SHOW TABLES');

        // Extract the table names and filter them based on the specific tables list
        $tableNames = array_map(function ($table) {
            return $table->{'Tables_in_' . env('DB_DATABASE')};
        }, $tablesInDatabase);
        $filteredTables = array_intersect($tableNames, $specificTables);

        // Fetch all loan records from the database
        $prestamos = Prestamo::all();

        return view('dashboard', compact('prestamos', 'filteredTables'));
    }

    /* public function fetchTableData(Request $request)
    {
        $tableName = $request->input('table');
        $specificTables = ['paileria', 'tabla_ejemplo', 'users'];

        if (!in_array($tableName, $specificTables)) {
            return response()->json(['error' => 'Invalid table'], 400);
        }

        $data = DB::table($tableName)->get();
        return response()->json($data);
    } */
    public function fetchTableData(Request $request)
    {
        $tableName = $request->input('table');
        $specificTables = ['almacen', 'ingenieria', 'oficina_administrativa', 'paileria'];

        // Check if the table is in the list of specific tables
        if (!in_array($tableName, $specificTables)) {
            return response()->json(['error' => 'Invalid table'], 400);
        }

        // Fetch all data from the specified table
        $data = DB::table($tableName)->get();

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    /* public function create(Request $request)
    {
        $request->validate([
            'table' => 'required|string|max:255',
            'nombreRecibe' => 'required|string|max:255',
            'tool' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'fechaSalida' => 'required|date',
            'fechaRegreso' => 'nullable|date|after_or_equal:fechaSalida',
            'observacion' => 'nullable|string',
            'uso' => 'nullable|string',
        ]);

        $presta = new Prestamo([
            'area' => $request->table,
            'nombreRecibe' => $request->nombreRecibe,
            'articulo' => $request->tool,
            'cantidadPresta' => $request->cantidad,
            'fechaSalida' => $request->fechaSalida,
            'fechaRegreso' => $request->fechaRegreso,
            'observacion' => $request->observacion,
            'uso' => $request->uso
        ]);

        // Verificar si hay suficiente stock
        if ($presta->cantidad < $request->cantidadPresta) {
            return redirect()->back()->with('error', 'No hay suficiente stock para esta operación.');
        }
        $presta->cantidad -= $request->cantidadPresta;

        if ($presta->save()) {
            return back()->with('success', 'Prestación registrada exitosamente.');
        } else {
            return back()->with('insuccess', 'Prestación no registrada.');
        }
    } */

    /**
     * Store a newly created resource in storage.
     */
    public function storeOrUpdate(Request $request, $id = null)
    {
        $request->validate([
            'table' => 'required|string|max:255',
            'nombreRecibe' => 'required|string|max:255',
            'tool' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'fechaSalida' => 'required|date',
            'fechaRegreso' => 'nullable|date|after_or_equal:fechaSalida',
            'observacion' => 'nullable|string',
            'uso' => 'nullable|string',
        ]);

        // Check if it's a create or update operation
        $presta = $id ? Prestamo::findOrFail($id) : new Prestamo;

        $presta->area = $request->input('table');
        $presta->nombreRecibe = $request->input('nombreRecibe');
        $presta->articulo = $request->input('tool');
        $presta->cantidadPresta = $request->input('cantidad');
        $presta->fechaSalida = $request->input('fechaSalida');
        $presta->fechaRegreso = $request->input('fechaRegreso');
        $presta->observacion = $request->input('observacion');
        $presta->uso = $request->input('uso');

        // Check stock before saving
        $stock = DB::table($request->table)->where('nombreherramienta', $request->tool)->value('cantidad');
        if ($stock === null || $stock < $request->cantidad) {
            return back()->with('error', 'No hay suficiente stock para esta operación.');
        }
        if ($stock != 0 ) {
            DB::table($request->table)->where('nombreherramienta', $request->tool)->update(['disponibilidad' => 'Ocupado']);
        } /* else {
            if ($stock == 0) {
                DB::table($request->table)->where('nombre', $request->tool)->update(['disponibilidad' => 'Ocupado']);
            }
        } */

        // If it's a new record, reduce stock
        if (!$id) {
            DB::table($request->table)->where('nombreherramienta', $request->tool)->update(['cantidad' => $stock - $request->cantidad]);
        }

        if ($presta->save()) {
            $message = $id ? 'Prestación actualizada correctamente.' : 'Prestación registrada exitosamente.';
            return back()->with('success', $message);
        } else {
            $message = $id ? 'Error al actualizar la prestación.' : 'Error al registrar la prestación.';
            return back()->with('error', $message);
        }
    }

    public function returnItem(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'table' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'fechaRegreso' => 'required|date',
        ]);

        // Buscar el préstamo
        $presta = Prestamo::findOrFail($id);

        // Obtener el stock actual
        $stock = DB::table($request->table)->where('nombreherramienta', $presta->articulo)->value('cantidad');

        // Aumentar el stock con la cantidad devuelta
        DB::table($request->table)->where('nombreherramienta', $presta->articulo)->update(['cantidad' => $stock + $request->cantidad]);

        // Actualizar la fecha de regreso en el registro de préstamo
        $presta->fechaRegreso = $request->fechaRegreso;
        $presta->save();

        // Cambiar disponibilidad a "Disponible" si la cantidad es mayor a 1
        if ($stock + $request->cantidad > 1) {
            DB::table($request->table)->where('nombreherramienta', $presta->articulo)->update(['disponibilidad' => 'Disponible']);
        }

        return back()->with('success', 'Artículo devuelto exitosamente.');
    }
    public function devolver($id)
    {
        $prestamo = Prestamo::findOrFail($id);

        // Aumentar la cantidad de stock de vuelta
        $toolTable = $prestamo->area;
        $toolName = $prestamo->articulo;

        $stock = DB::table($toolTable)->where('nombreherramienta', $toolName)->value('cantidad');
        DB::table($toolTable)->where('nombreherramienta', $toolName)->update(['cantidad' => $stock + $prestamo->cantidadPresta]);

        // Actualizar la disponibilidad
        DB::table($toolTable)->where('nombreherramienta', $toolName)->update(['disponibilidad' => 'Disponible']);

        return redirect()->route('dashboard')->with('success', 'Artículo devuelto exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /* public function update(Request $request, string $id)
    {
        $request->validate([
            'table' => 'required|string|max:255',
            'nombreRecibe' => 'required|string|max:255',
            'tool' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'fechaSalida' => 'required|date',
            'fechaRegreso' => 'nullable|date|after_or_equal:fechaSalida',
            'observacion' => 'nullable|string',
            'uso' => 'nullable|string',
        ]);

        try {
            $presta = Prestamo::findOrFail($id);
            $presta->area = $request->input('table');
            $presta->nombreRecibe = $request->input('nombreRecibe');
            $presta->articulo = $request->input('tool');
            $presta->cantidadPresta = $request->input('cantidad');
            $presta->fechaSalida = $request->input('fechaSalida');
            $presta->fechaRegreso = $request->input('fechaRegreso');
            $presta->observacion = $request->input('observacion');
            $presta->uso = $request->input('uso');

            $presta->save();
            return back()->with('correcto', 'Prestación actualizada correctamente');
        } catch (\Throwable $th) {
            return back()->with('incorrecto', 'Error al actualizar datos');
        }
    } */

    /**
     * Remove the specified resource from storage.
     */
    /* public function destroy(String $id)
    {
        try {
            $prestamo = Prestamo::findOrFail($id);
            $prestamo->delete();
            return back()->with('correcto', 'Prestación eliminada correctamente');
        } catch (\Exception $e) {
            return back()->with('incorrecto', 'Error al eliminar la prestación');
        }
    } */
    public function destroy(String $id)
    {
        try {
            $prestamo = Prestamo::findOrFail($id);
            $prestamo->delete();
            return back()->with('success', 'Prestación eliminada correctamente');
        } catch (\Exception $e) {
            return back()->with('insuccess', 'Error al eliminar la prestación');
        }
    }
}
