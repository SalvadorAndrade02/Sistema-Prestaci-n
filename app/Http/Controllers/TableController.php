<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    public function getTools($table)
    {
        // Suponiendo que todas las tablas tienen una columna 'nombre' que quieres obtener
        $tools = DB::table($table)->pluck('nombreherramienta');
        return response()->json($tools);
    }
    public function getQuantity($table, $tool)
    {
        $quantity = DB::table($table)->where('nombreherramienta', $tool)->value('cantidad');
        return response()->json(['quantity' => $quantity]);
    }

    public function updateQuantity(Request $request)
    {
        $table = $request->input('table');
        $tool = $request->input('tool');
        $prestamoCantidad = $request->input('cantidad');

        $currentQuantity = DB::table($table)->where('nnombreherramientaombre', $tool)->value('cantidad');

        if ($currentQuantity >= $prestamoCantidad) {
            $newQuantity = $currentQuantity - $prestamoCantidad;
            DB::table($table)->where('nombreherramienta', $tool)->update(['cantidad' => $newQuantity]);

            return response()->json(['success' => true, 'newQuantity' => $newQuantity]);
        } else {
            return response()->json(['success' => false, 'message' => 'Cantidad insuficiente']);
        }
    }
}
