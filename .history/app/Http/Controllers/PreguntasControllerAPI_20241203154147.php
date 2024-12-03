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
            // if ($cliente->profileIsComplete == 'no') {
            //     return response()->json(['message' => 'Primero complete su perfil'], 400);
            // }
            foreach ($respuestasData as $respuestaData) {
                $respuesta = new Respuesta();
                $respuesta->preguntas_id = $respuestaData['preguntaId'];
                $respuesta->respuestas_opciones_id = $respuestaData['respuestaValor'];
                $respuesta->customers_id = $userId;
                $respuesta->save();
            }
            $cliente->rutina = 'personalizada';
            $cliente->save();
            $puntajeTotal = 0;
            foreach ($request->input('respuestas') as $respuesta) {
                $opcion = RespuestaOpcion::find($respuesta['respuestaValor']);
                if ($opcion) {
                    $puntajeTotal += $opcion->valor;
                }
            }


            // Seleccionar la rutina adecuada

            // Inicializa la rutina seleccionada como nula
            $rutinaSeleccionada = null;
            Log::info('Puntaje total: ' . $puntajeTotal);

            // Recorre todas las rutinas y verifica si el puntaje total está dentro del rango de puntaje de cada rutina





            return response()->json([
                'message' => 'Respuestas guardadas exitosamente',
                'puntaje'=>$puntajeTotal,
                'rutina_asignada' => $rutinaSeleccionada // Devolver la rutina asignada al cliente
            ], 200);
        } catch (Exception $e) {
            // Registrar el error en el log de la aplicación
            Log::error('Error al guardar las respuestas: ' . $e->getMessage());

            // Retornar una respuesta de error en formato JSON
            return response()->json([
                // 'error' => 'Error al guardar las respuestas',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
