<?php

namespace App\Http\Controllers;

use App\Models\TablaEjemplo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TablaEjemploController extends Controller
{
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

        // Pasar los datos a la vista 'dashboard'
        return view('dashboard', compact('filteredTables'));
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
    } */
}
