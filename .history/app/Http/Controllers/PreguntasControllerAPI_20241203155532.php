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

            // Calcular el puntaje total
            $puntajeTotal = 0;
            foreach ($request->input('respuestas') as $respuesta) {
                $opcion = RespuestaOpcion::find($respuesta['respuestaValor']);
                if ($opcion) {
                    $puntajeTotal += $opcion->valor;
                }
            }

            // Asignar nivel basado en el puntaje total y el género
            $nivel = null;
            $genero = $cliente->sexo; // Asegúrate de que el modelo `Customers` tenga este atributo

            if ($genero === 'Hombre') {
                if ($puntajeTotal >= 50 && $puntajeTotal <= 120) {
                    $nivel = 'Principiante';
                } elseif ($puntajeTotal >= 121 && $puntajeTotal <= 200) {
                    $nivel = 'Intermedio';
                } elseif ($puntajeTotal > 200) {
                    $nivel = 'Avanzado';
                }
            } elseif ($genero === 'Mujer') {
                if ($puntajeTotal >= 550 && $puntajeTotal <= 620) {
                    $nivel = 'Principiante';
                } elseif ($puntajeTotal >= 621 && $puntajeTotal <= 700) {
                    $nivel = 'Intermedio';
                } elseif ($puntajeTotal > 700) {
                    $nivel = 'Avanzado';
                }
            }

            Log::info('Puntaje total: ' . $puntajeTotal);
            Log::info('Nivel asignado: ' . $nivel);

            // Actualizar el nivel del cliente
            $cliente->nivel = $nivel;
            $cliente->save();

            return response()->json([
                'message' => 'Respuestas guardadas exitosamente',
                'puntaje' => $puntajeTotal,
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
