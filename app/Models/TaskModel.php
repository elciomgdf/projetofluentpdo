<?php

namespace App\Models;

use App\Interfaces\ModelInterface;

class TaskModel extends Model implements ModelInterface
{

    const STATUS_PENDENTE = 'Pendente';
    const STATUS_EM_ANDAMENTO = 'Em Andamento';
    const STATUS_COMPLETA = 'Completa';

    const PRIORIDADE_BAIXA = 'Baixa';
    const PRIORIDADE_MEDIA = 'Média';
    const PRIORIDADE_ALTA = 'Alta';

    private ?int $id = null;
    private ?int $user_id = null;
    private ?int $category_id = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?string $status = null;
    private ?string $priority = null;
    private ?string $due_date = null;
    private ?string $created_at = null;
    private ?string $updated_at = null;

    protected string $table = 'tasks';

    protected array $fields = [
        'id',
        'user_id',
        'category_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'created_at',
        'updated_at'
    ];

    // Getters e Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): TaskModel
    {
        $this->id = $id;
        return $this;
    }

    public function getUser_id(): ?int
    {
        return $this->user_id;
    }

    public function setUser_id(?int $user_id): TaskModel
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getCategory_id(): ?int
    {
        return $this->category_id;
    }

    public function setCategory_id(?int $category_id): TaskModel
    {
        $this->category_id = $category_id;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): TaskModel
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): TaskModel
    {
        $this->description = $description;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): TaskModel
    {
        $this->status = $status;
        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(?string $priority): TaskModel
    {
        $this->priority = $priority;
        return $this;
    }

    public function getDue_date(): ?string
    {
        return $this->due_date;
    }

    public function setDue_date(?string $due_date): TaskModel
    {
        $this->due_date = $due_date;
        return $this;
    }

    public function getCreated_at(): ?string
    {
        return $this->created_at;
    }

    public function setCreated_at(?string $created_at): TaskModel
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdated_at(): ?string
    {
        return $this->updated_at;
    }

    public function setUpdated_at(?string $updated_at): TaskModel
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * Relacionamento: retorna a categoria da tarefa (pode ser null).
     */
    public function getCategory(): ?TaskCategoryModel
    {
        if (!$this->category_id) return null;
        return (new TaskCategoryModel())->find($this->category_id);
    }

    /**
     * Relacionamento: retorna o usuário dono da tarefa.
     */
    public function getUser(): ?UserModel
    {
        return (new UserModel())->find($this->user_id);
    }

}
