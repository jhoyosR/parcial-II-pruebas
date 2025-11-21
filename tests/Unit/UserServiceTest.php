<?php

namespace Tests\Unit;

use App\DTOs\Task\TaskDTO;
use Tests\TestCase;
use App\Services\UserService;
use App\DTOs\User\UserDTO;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_user()
    {
        $dto = new UserDTO(
            name        : 'José Alfredo',
            email       : 'jespinosa@gmail.com',
        );

        $service = app(UserService::class);
        $user = $service->create($dto);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', ['name' => 'José Alfredo']);
    }

    public function test_can_get_user_tasks()
    {
        $dto = new UserDTO(
            name        : 'José Alfredo',
            email       : 'jespinosa@gmail.com',
        );

        $service = app(UserService::class);
        $user = $service->create($dto);
        
        $taskDto = new TaskDTO(
            title: 'prueba',
            description: 'prueba descripción',
            is_completed: false,
            user_id: $user->id
        );

        $taskService = app(TaskService::class);
        $task = $taskService->create($taskDto);

        $result = $service->getTasks($user->id);
        $this->assertCount(1, $result->tasks);
    }
}