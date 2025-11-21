<?php 

namespace App\Services;

use App\DTOs\Task\TaskDTO;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

/** Servicio de Tasks */
class TaskService {

    /** Constructor de la clase */
    public function __construct(
        
    ) {}

    /**
     * Encuentra un registro
     *
     * @param  integer $id
     * @return Task|null
     */
    public function find(int $id): ?Task {
        return Task::findOrFail($id);
    }
    
    /**
     * Crea un registro
     *
     * @param  TaskDTO $data
     * @return Task
     */
    public function create(TaskDTO $data): Task {
        return DB::transaction(function () use ($data) {
            // Crea Task
            $task = Task::create($data->toArray());

            return $task;
        });
    }

    /**
     * Actualiza un registro
     *
     * @param  array $data
     * @return Task
     */
    public function update(int $id, array $data): Task {
        // Inicia una transacción
        return DB::transaction(function () use ($id, $data) {

            // Buscar o lanzar ModelNotFoundException automáticamente
            $task = $this->find($id);

            $data['title'] = $task->title;
            $data['description'] = $task->description;
            $data['user_id'] = $task->user_id;

            // Actualizar con los datos del DTO
            $task->update($data);

            return $task->fresh();
        });
    }

    /**
     * Elimina un registro
     *
     * @param  integer $id
     * @return boolean
     */
    public function delete(int $id): void {
        DB::transaction(function () use ($id) {

            // Buscar o fallar
            $task = $this->find($id);

            // Eliminar
            $task->delete();
        });
    }
}