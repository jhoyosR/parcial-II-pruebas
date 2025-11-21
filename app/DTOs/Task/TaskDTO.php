<?php 

namespace App\DTOs\Task;

/**
 * DTO para creación del modelo
 */
class TaskDTO {

    /** Constructor */
    public function __construct(
        private readonly int    $user_id,
        private readonly string $title,
        private readonly string $description,
        private readonly bool   $is_completed,
    ) {}

    /**
     * Obtencion de datos desde array
     *
     * @param array $data Datos del modelo
     */
    public static function fromArray(array $data): TaskDTO {
        return new self(
            user_id      : data_get(target: $data, key: 'user_id'),
            title        : data_get(target: $data, key: 'title'),
            description  : data_get(target: $data, key: 'description'),
            is_completed : data_get(target: $data, key: 'is_completed'),
        );
    }

    /** Datos del modelo */
    public function toArray(): array {
        return [
            'user_id'      => $this->user_id,
            'title'        => $this->title,
            'description'  => $this->description,
            'is_completed' => $this->is_completed
        ];
    }

}