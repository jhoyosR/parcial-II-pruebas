<?php 

namespace App\Services;

use App\DTOs\User\UserDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/** Servicio de Users */
class UserService {

    /** Constructor de la clase */
    public function __construct(
        
    ) {}

    /**
     * Obtiene las tareas asociadas a un usuario
     *
     * @return Collection
     */
    public function getTasks(int $id): ?User {
        // Obtiene los registros 
        $userTasks = User::with('tasks')->where('id', '=', $id)->first();
        return $userTasks;
    }
    
    /**
     * Crea un registro
     *
     * @param  UserDTO $data
     * @return User
     */
    public function create(UserDTO $data): User {
        return DB::transaction(function () use ($data) {
            // Crea User
            $user = User::create($data->toArray());

            return $user;
        });
    }
}