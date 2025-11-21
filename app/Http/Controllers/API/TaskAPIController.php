<?php

namespace App\Http\Controllers\API;

use App\DTOs\Task\TaskDTO;
use App\Http\Controllers\Controller;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TaskAPIController extends Controller {

    /** Constructor de la clase */
    public function __construct(
        private readonly TaskService $taskService
    ) {}

    /**
     * Almacena un nuevo task en la base de datos
     * 
     * @param TaskRequest $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse {

        // Validación de datos
        $validator = Validator::make($request->all(), [
            'title'      => ['required', 'string'],
            'description'     => ['required', 'string'],
            'is_completed'     => ['required', 'boolean'],
            'user_id'     => ['required', 'integer', Rule::exists('users', 'id')],
        ]);

        // Responde con error de datos de formulario
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $task = $this->taskService->create(
            TaskDTO::fromArray($request->all())
        );

        return $this->successResponse(
            message: 'Registro guardado exitosamente',
            result  : $task
        );
    }

    /**
     * Actualiza un task en la base de datos
     * 
     * @param TaskRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateState(Request $request, int $id): JsonResponse {

        // Validación de datos
        $validator = Validator::make($request->all(), [
            'is_completed' => ['required', 'boolean'],
        ]);

        // Responde con error de datos de formulario
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $request->all();

        $task = $this->taskService->update(
            id: $id,
            data: $request->all()
        );

        return $this->successResponse(
            message: 'Registro actualizado exitosamente',
            result  : $task
        );
    }

    /**
     * Elimina un task de la base de datos
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {

        $this->taskService->delete($id);

        return $this->successResponse(
            message: 'Registro eliminado exitosamente'
        );
    }

}