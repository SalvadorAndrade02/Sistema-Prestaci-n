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
    public function index()
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
    }

    public function fetchTableData(Request $request)
    {
        $tableName = $request->input('table');
        $specificTables = ['paileria', 'tabla_ejemplo', 'users'];

        if (!in_array($tableName, $specificTables)) {
            return response()->json(['error' => 'Invalid table'], 400);
        }

        $data = DB::table($tableName)->get();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
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

        if ($presta->save()) {
            return back()->with('success', 'Prestación registrada exitosamente.');
        } else {
            return back()->with('insuccess', 'Prestación no registrada.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

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
    public function update(Request $request, string $id)
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
            $presta-> area = $request->input('table');
            $presta-> nombreRecibe = $request->input('nombreRecibe');
            $presta-> articulo = $request->input('tool');
            $presta-> cantidadPresta = $request->input('cantidad');
            $presta-> fechaSalida = $request->input('fechaSalida');
            $presta-> fechaRegreso = $request->input('fechaRegreso');
            $presta->observacion = $request->input('observacion');
            $presta-> uso = $request->input('uso');

            $presta->save();
            return back()->with('correcto', 'Prestación actualizada correctamente');

        } catch (\Throwable $th) {
            return back()->with('incorrecto', 'Error al actualizar datos');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        try {
            $prestamo = Prestamo::findOrFail($id);
            $prestamo->delete();
            return back()->with('correcto', 'Prestación eliminada correctamente');
        } catch (\Exception $e) {
            return back()->with('incorrecto', 'Error al eliminar la prestación');
        }
    }
}
