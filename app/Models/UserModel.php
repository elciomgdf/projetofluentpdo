<?php

namespace App\Models;

use App\Interfaces\ModelInterface;

class UserModel extends Model implements ModelInterface
{

    private ?int $id = null;
    private ?string $name = null;
    private ?string $email = null;
    private ?string $password = null;
    private ?string $created_at = null;
    private ?string $updated_at = null;

    protected string $table = 'users';

    protected array $fields = ['id', 'name', 'email', 'password', 'created_at', 'updated_at'];

    protected array $hidden = ['password'];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId($id): UserModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName($name): UserModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail($email): UserModel
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): UserModel
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCreated_at(): ?string
    {
        return $this->created_at;
    }

    /**
     * @param string|null $created_at
     */
    public function setCreated_at(?string $created_at): UserModel
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUpdated_at(): ?string
    {
        return $this->updated_at;
    }

    /**
     * @param string|null $updated_at
     */
    public function setUpdated_at(?string $updated_at): UserModel
    {
        $this->updated_at = $updated_at;
        return $this;
    }

}