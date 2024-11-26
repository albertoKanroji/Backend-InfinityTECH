<?php

namespace App\Http\Controllers;

use App\Models\Ejercicios;
use App\Models\RespuestaOpcion;
use App\Models\Rutinas;
use App\Models\SeguimientoClientesImagenes;
use Illuminate\Http\Request;
use App\Models\Customers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'apellido2' => 'required|string',
            'correo' => 'required|email|unique:customers',
            'password' => 'required|string|min:6',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'Error de validación',
                'data' => $validator->errors()
            ], 422);
        }

        try {
            $usuarioData = $request->all();
            $usuarioData['password'] = Hash::make($request->password);
            $usuario = Customers::create($usuarioData);
            return response()->json([
                'success' => true,
                'status' => 201,
                'message' => 'Usuario creado correctamente',
                'data' => $usuario
            ], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            // Error de la base de datos
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Error en la base de datos al crear usuario: ' . $e->getMessage(),
                'data' => null
            ]);
        } catch (\Exception $e) {
            // Otro tipo de error
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Error al crear usuario: ' . $e->getMessage(),
                'data' => null
            ]);
        }
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'Error de validación',
                'data' => $validator->errors()
            ], 422);
        }
        //122344 =dkjfhjghkdhfghdgeruihg == dkjfhjghkdhfghdgeruihg
        try {
            // Buscar al cliente por su correo electrónico
            $cliente = Customers::where('correo', $request->correo)->first();

            // Verificar si el cliente existe y la contraseña es correcta
            if (!$cliente || !Hash::check($request->password, $cliente->password)) {
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'message' => 'Credenciales inválidas',
                    'data' => $cliente
                ], 401);
            }

            // regSi las credenciales son válidas, generar un token para el cliente
            $token = $this->generateToken($cliente);

            // Devolver la respuesta con el token y los datos del cliente
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Inicio de sesión exitoso',
                'data' => [
                    'token' => $token,
                    'cliente' => $cliente
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Error al iniciar sesión: ' . $e->getMessage(),
                'data' => null
            ]);
        }
    }

    private function generateToken($cliente)
    {
        // Aquí puedes generar un token único para el cliente
        // Por ejemplo, puedes utilizar una combinación de su ID y una cadena aleatoria
        return md5($cliente->id . '_' . uniqid());
    }
    public function getData(Request $request)
    {
        try {
            // Obtener el ID del cliente desde la solicitud
            $clienteId = $request->input('clienteId');

            // Buscar al cliente por su ID
            $cliente = Customers::find($clienteId);

            // Verificar si se encontró al cliente
            if (!$cliente) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'Cliente no encontrado',
                    'data' => null
                ], 404);
            }

            // Devolver la información del cliente
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Información del cliente obtenida correctamente',
                'data' => $cliente
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Error al obtener la información del cliente: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'apellido2' => 'required|string',
            'correo' => 'required|email|unique:customers,correo,' . $id,
            'peso' => 'nullable|numeric',
            'altura' => 'nullable|numeric',
            'rutina' => 'nullable|string',
            'profileIsComplete' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'Error de validación',
                'data' => $validator->errors()
            ], 422);
        }

        try {
            $cliente = Customers::find($id);

            if (!$cliente) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'Cliente no encontrado',
                    'data' => null
                ], 404);
            }

            $cliente->nombre = $request->input('nombre');
            $cliente->apellido = $request->input('apellido');
            $cliente->apellido2 = $request->input('apellido2');
            $cliente->correo = $request->input('correo');
            $cliente->rutina = $request->input('rutina');
            $cliente->profileIsComplete = $request->input('profileIsComplete');
            $cliente->peso = $request->input('peso');
            $cliente->altura = $request->input('altura');

            if ($request->input('peso') && $request->input('altura')) {
                $peso = $request->input('peso');
                $altura = $request->input('altura') / 100; // Convertimos la altura a metros
                $cliente->IMC = round($peso / ($altura * $altura), 2);
            }
            $cliente->profileIsComplete = 'si';

            $cliente->save();


            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Cliente actualizado correctamente',
                'data' => $cliente
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Error al actualizar el cliente: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function storeImages(Request $request)
    {
        // Validación del request
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id', // Verifica que el customer_id exista
            'images' => 'required|array',                   // Asegura que 'images' sea un array
            'images.*.image' => 'required|string',          // Cada imagen debe ser una cadena en Base64
            'images.*.peso' => 'nullable|numeric',           // El peso es opcional y debe ser una cadena
            'images.*.comentarios' => 'nullable|string'     // Los comentarios son opcionales y deben ser una cadena
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'Error de validación',
                'data' => $validator->errors()
            ], 422);
        }

        try {
            $customerId = $request->input('customer_id');
            $images = $request->input('images');

            // Guardar cada imagen en la tabla seguimiento_clientes_imagenes
            foreach ($images as $imageData) {
                $decodedImage = base64_decode($imageData['image'], true);
                if ($decodedImage === false) {
                    //throw new \Exception('La imagen no es válida en formato Base64');
                    return response()->json([
                        'success' => false,
                        'status' => 500,
                        'message' => 'La imagen no es válida en formato Base64',
                        'data' => null
                    ], 500);
                }
                $imagen = new SeguimientoClientesImagenes();
                $imagen->customers_id = $customerId;
                $imagen->image = base64_decode($imageData['image']); // Decodificar Base64 a binario

                // Guardar los campos opcionales
                $imagen->peso = $imageData['peso'] ?? null;
                $imagen->comentarios = $imageData['comentarios'] ?? null;
                $imagen->save();
            }

            // Excluir datos binarios de la respuesta
            return response()->json([
                'success' => true,
                'status' => 201,
                'message' => 'Imágenes guardadas correctamente',
                'data' => null // Asegurarse de que no se incluyen datos binarios en la respuesta
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Error al guardar imágenes: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function listImages($customerId)
    {
        try {
            // Verificar si el cliente existe
            $cliente = Customers::find($customerId);
            if (!$cliente) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'Cliente no encontrado',
                    'data' => null
                ], 404);
            }

            // Obtener las imágenes asociadas al cliente
            $imagenes = SeguimientoClientesImagenes::where('customers_id', $customerId)->get();

            // Convertir las imágenes a formato Base64 e incluir peso y comentarios
            $imagenesBase64 = $imagenes->map(function ($imagen) {
                return [
                    'id' => $imagen->id,
                    'image' => base64_encode($imagen->image), // Codificar la imagen en Base64
                    'peso' => $imagen->peso,                  // Incluir el peso
                    'comentarios' => $imagen->comentarios,
                    'created_at' => $imagen->created_at      // Incluir los comentarios
                ];
            });

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Imágenes obtenidas correctamente',
                'data' => $imagenesBase64
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Error al obtener las imágenes: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function deleteImage($customerId, $imageId)
    {
        try {
            // Verificar si el cliente existe
            $cliente = Customers::find($customerId);
            if (!$cliente) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'Cliente no encontrado',
                    'data' => null
                ], 404);
            }

            // Buscar la imagen específica del cliente
            $imagen = SeguimientoClientesImagenes::where('customers_id', $customerId)
                ->where('id', $imageId)
                ->first();
            if (!$imagen) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'Imagen no encontrada',
                    'data' => null
                ], 404);
            }

            // Eliminar la imagen
            $imagen->delete();

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Imagen eliminada correctamente',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Error al eliminar la imagen: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
