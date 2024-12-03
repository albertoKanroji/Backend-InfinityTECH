<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\RespuestaOpcion;
use App\Models\Rutinas;
use Illuminate\Http\Request;
use App\Models\Pregunta;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Respuesta;

class PreguntasControllerAPI extends Controller
{
    //
    public function index()
    {
        try {
            // Traer todas las preguntas con sus opciones de respuesta
            $preguntas = Pregunta::with('respuestasOpciones')->get();

            // Retornar la respuesta en formato JSON
            return response()->json($preguntas, 200);
        } catch (Exception $e) {
            // Registrar el error en el log de la aplicación
            Log::error('Error al obtener las preguntas: ' . $e->getMessage());

            // Retornar una respuesta de error en formato JSON
            return response()->json([
                'error' => 'Error al obtener las preguntas',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function guardarRespuestas(Request $request)
    {
        try {
            $userId = $request->input('userId');
            $respuestasData = $request->input('respuestas');
            $puntaje = $request->input('puntaje');
            // Buscar el cliente por su ID
            $cliente = Customers::find($userId);

            if (!$cliente) {
                return response()->json(['message' => 'Cliente no encontrado'], 404);
            }

            // Guardar las respuestas
            foreach ($respuestasData as $respuestaData) {
                $respuesta = new Respuesta();
                $respuesta->preguntas_id = $respuestaData['preguntaId'];
                $respuesta->respuestas_opciones_id = $respuestaData['respuestaValor'];
                $respuesta->customers_id = $userId;
                $respuesta->save();
            }
            $cliente->rutina = 'personalizada';
            $cliente->save();



            // Asignar nivel basado en el puntaje total y el género
            $nivel = null;
            $genero = $cliente->sexo; // Asegúrate de que el modelo `Customers` tenga este atributo

            if ($genero === 'Hombre') {
                if ($puntaje >= 50 && $puntaje <= 120) {
                    $nivel = 'Principiante';
                } elseif ($puntaje >= 121 && $puntaje <= 200) {
                    $nivel = 'Intermedio';
                } elseif ($puntaje > 200) {
                    $nivel = 'Avanzado';
                }
            } elseif ($genero === 'Mujer') {
                if ($puntaje >= 550 && $puntaje <= 620) {
                    $nivel = 'Principiante';
                } elseif ($puntaje >= 621 && $puntaje <= 700) {
                    $nivel = 'Intermedio';
                } elseif ($puntaje > 700) {
                    $nivel = 'Avanzado';
                }
            }

            Log::info('Puntaje total: ' . $puntaje);
            Log::info('Nivel asignado: ' . $nivel);

            // Actualizar el nivel del cliente
            $cliente->nivel = $nivel;
            $cliente->save();

            return response()->json([
                'message' => 'Respuestas guardadas exitosamente',
                'puntaje' => $puntaje,
                'nivel_asignado' => $nivel
            ], 200);
        } catch (Exception $e) {
            // Registrar el error en el log de la aplicación
            Log::error('Error al guardar las respuestas: ' . $e->getMessage());

            // Retornar una respuesta de error en formato JSON
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
