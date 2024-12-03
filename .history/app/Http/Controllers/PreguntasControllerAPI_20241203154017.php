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
            $rutinasDB = Rutinas::all(['nombre', 'imagen', 'descripcion', 'tipo', 'min_puntaje', 'max_puntaje']);
            $rutinaAsignada = null;
            $rutinas = [];
            foreach ($rutinasDB as $rutinaData) {
                $rutinas[] = [
                    'nombre' => $rutinaData->nombre,
                    'imagen' => $rutinaData->imagen,
                    'descripcion' => $rutinaData->descripcion,
                    'tipo' => $rutinaData->tipo,
                    'min_puntaje' => $rutinaData->min_puntaje,
                    'max_puntaje' => $rutinaData->max_puntaje
                ];
            }

            // Seleccionar la rutina adecuada

            // Inicializa la rutina seleccionada como nula
            $rutinaSeleccionada = null;
            Log::info('Puntaje total: ' . $puntajeTotal);

            // Recorre todas las rutinas y verifica si el puntaje total está dentro del rango de puntaje de cada rutina
            foreach ($rutinas as $rutinaData) {
                $minPuntaje = $rutinaData['min_puntaje'];
                $maxPuntaje = $rutinaData['max_puntaje'];
                Log::info("Rango de puntaje de la rutina: Min: $minPuntaje | Max: $maxPuntaje");

                // Verifica si el puntaje total está dentro del rango de la rutina actual
                if ($puntajeTotal >= $minPuntaje && $puntajeTotal <= $maxPuntaje) {
                    Log::info('El puntaje total está dentro del rango de la rutina: ' . $rutinaData['nombre']);

                    // Si el puntaje total está dentro del rango, establece la rutina seleccionada y termina el bucle
                    $rutinaSeleccionada = $rutinaData;
                    break;
                } else {
                    // Log si el puntaje total NO está dentro del rango de la rutina actual
                    Log::info('El puntaje total NO está dentro del rango de la rutina: ' . $rutinaData['nombre']);
                }
            }

            // Verifica si se encontró una rutina adecuada
            if ($rutinaSeleccionada) {
                Log::info('Se encontró una rutina adecuada: ' . $rutinaSeleccionada['nombre']);

                // Aquí se encontró una rutina adecuada, entonces puedes proceder a utilizar $rutinaSeleccionada
                // para realizar cualquier acción necesaria, como guardarla en la base de datos.
                // $rutinaSeleccionada contiene la información de la rutina seleccionada.
                $rutinaNombre = $rutinaSeleccionada['nombre'];
                $rutinaImagen = $rutinaSeleccionada['imagen'];
                $rutinaDescripcion = $rutinaSeleccionada['descripcion'];
                $rutinaTipo = $rutinaSeleccionada['tipo'];

                // Crear la rutina en la base de datos y asociarla con el cliente
                $rutina = new Rutinas();
                $rutina->nombre = $rutinaNombre;
                $rutina->imagen = $rutinaImagen;
                $rutina->descripcion = $rutinaDescripcion;
                $rutina->tipo = $rutinaTipo;
                $rutina->estado = 'personalizada';
                $rutina->save();

                // Asociar la rutina con el cliente
                $cliente->rutinas()->attach($rutina->id);

                // Ahora $rutina contiene la rutina seleccionada y se ha guardado en la base de datos
            } else {
                Log::info('No se encontró ninguna rutina adecuada para el puntaje total dado');
            }



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
