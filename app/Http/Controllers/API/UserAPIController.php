<?php

namespace App\Http\Controllers\API;

use App\DTOs\User\UserDTO;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserAPIController extends Controller {

    /** Constructor de la clase */
    public function __construct(
        private readonly UserService $userService
    ) {}

    /**
     * Muestra el listado de tareas asociadas al usuario
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getTasks(Request $request, int $id): JsonResponse {

        // Obtener todos los users
        $user = $this->userService->getTasks($id);

        $user->loadMissing('tasks');

        $result = [
            'user'  => $user->name,
            'tasks' => $user->tasks ?? null
        ];

        // Devuelve respuesta en formato JSON
        return $this->successResponse(
            message: 'Datos obtenidos exitosamente', 
            result : $result
        );
    }

    /**
     * Almacena un nuevo user en la base de datos
     * 
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse {

        // Validación de datos
        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string'],
            'email'     => ['required', 'email'],
        ]);

        // Responde con error de datos de formulario
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = $this->userService->create(
            UserDTO::fromArray($request->all())
        );

        return $this->successResponse(
            message: 'Registro guardado exitosamente',
            result  : $user
        );
    }

}