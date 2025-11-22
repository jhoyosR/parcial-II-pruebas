<?php

namespace Tests\Unit;

use App\DTOs\Task\TaskDTO;
use App\DTOs\User\UserDTO;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use App\Services\UserService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FullFlowSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_flow_system()
    {
        // Crear usuario
        $dto = new UserDTO(
            name        : 'José Alfredo',
            email       : 'jespinosa@gmail.com',
        );

        $service = app(UserService::class);
        $user = $service->create($dto);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', ['name' => 'José Alfredo']);

        // Crear tarea
        $dtoTask = new TaskDTO(
            user_id      : $user->id,
            title        : 'Backend',
            description  : 'Desarrollar backend',
            is_completed : true
        );

        $serviceTask = app(TaskService::class);
        $task = $serviceTask->create($dtoTask);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertDatabaseHas('tasks', ['title' => 'Backend']);

        // Listar tareas asociadas a un usuario
        $result = $service->getTasks($user->id);
        $this->assertCount(1, $result->tasks);

        // Actualizar tarea
        $updatedState = [
            'is_completed' => false
        ];

        $updatedTask = $serviceTask->update($task->id, $updatedState);

        $this->assertFalse($updatedTask->is_completed);
        $this->assertDatabaseHas('tasks', ['title' => 'Backend', 'is_completed' => false]);

        // Eliminar tarea
        $serviceTask->delete($task->id);
        $this->assertDatabaseMissing('tasks', ['title' => 'Backend']);
    }

}