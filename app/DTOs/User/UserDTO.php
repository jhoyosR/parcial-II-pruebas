<?php 

namespace App\DTOs\User;

/**
 * DTO para creación del modelo
 */
class UserDTO {

    /** Constructor */
    public function __construct(
        private readonly string $name,
        private readonly string $email,
    ) {}

    /**
     * Obtencion de datos desde array
     *
     * @param array $data Datos del modelo
     */
    public static function fromArray(array $data): UserDTO {
        return new self(
            name  : data_get(target: $data, key: 'name'),
            email : data_get(target: $data, key: 'email')
        );
    }

    /** Datos del modelo */
    public function toArray(): array {
        return [
            'name'  => $this->name,
            'email' => $this->email
        ];
    }

}