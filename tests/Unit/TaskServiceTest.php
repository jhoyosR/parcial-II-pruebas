<?php

namespace Tests\Unit;

use App\DTOs\Task\TaskDTO;
use App\DTOs\User\UserDTO;
use Tests\TestCase;
use App\Services\TaskService;
use App\Models\Task;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_task()
    {
        $dto = new UserDTO(
            name        : 'José Alfredo',
            email       : 'jespinosa@gmail.com',
        );

        $service = app(UserService::class);
        $user = $service->create($dto);

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
    }

    public function test_can_delete_task() {
        $dto = new UserDTO(
            name        : 'José Alfredo',
            email       : 'jespinosa@gmail.com',
        );

        $service = app(UserService::class);
        $user = $service->create($dto);

        $dtoTask = new TaskDTO(
            user_id      : $user->id,
            title        : 'Backend',
            description  : 'Desarrollar backend',
            is_completed : true
        );

        $serviceTask = app(TaskService::class);
        $task = $serviceTask->create($dtoTask);

        $serviceTask->delete($task->id);
        $this->assertDatabaseMissing('tasks', ['title' => 'Backend']);
    }
}