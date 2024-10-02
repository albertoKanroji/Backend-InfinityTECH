<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use App\Models\Rutinas;
use Illuminate\Support\Facades\Log;

class RutinasControllerAPI extends Controller
{
    //
    public function index()
    {
        // Obtener todas las rutinas
        $rutinas = Rutinas::where('estado', 'publica')->get();

        // Retornar las rutinas como respuesta JSON
        return response()->json([
            'success' => true,
            'data' => $rutinas
        ]);
    }
    public function show($id)
    {
        // Buscar la rutina por su ID
        $rutina = Rutinas::find($id);

        // Verificar si la rutina existe
        if (!$rutina) {
            return response()->json([
                'success' => false,
                'message' => 'Rutina no encontrada'
            ], 404); // Código de respuesta 404: Not Found
        }

        // Retornar la rutina como respuesta JSON
        return response()->json([
            'success' => true,
            'data' => $rutina
        ]);
    }
    public function showEjercicios($id)
    {
        // Buscar la rutina por su ID
        $rutina = Rutinas::find($id);

        // Verificar si la rutina existe
        if (!$rutina) {
            return response()->json([
                'success' => false,
                'message' => 'Rutina no encontrada'
            ], 404); // Código de respuesta 404: Not Found
        }

        // Obtener todos los ejercicios asociados a la rutina
        $ejercicios = $rutina->videos;

        // Retornar los ejercicios como respuesta JSON
        return response()->json([
            'success' => true,
            'data' => $ejercicios
        ]);
    }
    public function obtenerRutinasPersonalizadas($clienteId)
    {
        try {
            // Buscar al cliente por su ID
            $cliente = Customers::find($clienteId);

            if (!$cliente) {
                return response()->json(['message' => 'Cliente no encontrado'], 404);
            }

            // Obtener las rutinas personalizadas del cliente
            $rutinasPersonalizadas = $cliente->rutinas()->get();

            return response()->json([
                'message' => 'Rutinas personalizadas obtenidas correctamente',
                'data' => $rutinasPersonalizadas
            ], 200);
        } catch (\Exception $e) {
            // Registrar el error en el log de la aplicación
            Log::error('Error al obtener las rutinas personalizadas: ' . $e->getMessage());

            // Retornar una respuesta de error en formato JSON
            return response()->json(['message' => 'Error al obtener las rutinas personalizadas'], 500);
        }
    }
}