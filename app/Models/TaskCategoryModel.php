<?php

namespace App\Models;

use App\Interfaces\ModelInterface;

class TaskCategoryModel extends Model implements ModelInterface
{
    public ?int $id = null;

    public ?string $name = null;

    public ?string $description = null;

    public ?string $created_at = null;

    public ?string $updated_at = null;

    protected string $table = 'task_categories';

    protected array $fields = ['id', 'name', 'description', 'created_at', 'updated_at'];

    protected array $hidden = [];

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
    public function setId(?int $id): TaskCategoryModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): TaskCategoryModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): TaskCategoryModel
    {
        $this->description = $description;
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
    public function setCreated_at(?string $created_at): TaskCategoryModel
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
    public function setUpdated_at(?string $updated_at): TaskCategoryModel
    {
        $this->updated_at = $updated_at;
        return $this;
    }

}
