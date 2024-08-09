<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestamo;
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
