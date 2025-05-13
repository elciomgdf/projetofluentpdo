<?php

namespace App\Models;

namespace App\Models;

use App\Traits\DataBaseTrait;
use Envms\FluentPDO\Exception;

abstract class Model
{

    use DataBaseTrait;

    /**
     * Conserva os dados iniciais para que sejam persistidas apenas as diferenças
     * @var array
     */
    private array $initData;

    protected string $table;

    public function __construct()
    {
        $this->initData = $this->toArray();
    }

    /**
     * Salva um registro na base de dados
     * @return Model|null
     * @throws \Envms\FluentPDO\Exception
     */
    public function save()
    {

        $data = $this->getDirty();

        if (!empty($this->getId())) {
            if (empty($data)) {
                // Não há o que alterar
                return $this->find();
            }
            $this->update($this->getId(), $data);
        } else {
            if (empty($data)) {
                throw new Exception("Tentando salvar um registro sem dados");
            }
            $this->setId($this->insert($data));
        }

        return $this->find();

    }

    /**
     * Retorna e alienta a próprio Model com base em seu ID
     * @param $id
     * @return $this|null
     * @throws \Envms\FluentPDO\Exception
     */
    public function find($id = null): Model|null
    {

        if (empty($id) && empty($this->getId())) {
            return null;
        }

        $id = $this->getId() ?? $id;
        $data = $this->findById($id);

        if (empty($data)) {
            return null;
        }

        $this->initData = $data;
        $this->setId($id);
        $this->fill($data);
        return $this;

    }

    /**
     * Preenche os campos da Model
     * @param array $data
     * @return void
     */
    public function fill(array $data): void
    {
        if (property_exists($this, 'fields')) {
            foreach ($this->fields as $field) {
                if (array_key_exists($field, $data)) {
                    $setter = 'set' . ucfirst($field);
                    if (method_exists($this, $setter)) {
                        $this->$setter($data[$field]);
                    }
                }
            }
        }
    }

    /**
     * Retorna apenas os dados que foram alterados na Model
     */
    public function getDirty(): array
    {
        $dirty = [];
        if (property_exists($this, 'fields')) {
            foreach ($this->fields as $field) {
                if ($field == 'id') {
                    continue;
                }
                $getter = 'get' . ucfirst($field);
                $current = method_exists($this, $getter) ? $this->$getter() : null;
                $original = $this->initData[$field] ?? null;
                if ($current !== $original) {
                    $dirty[$field] = $current;
                }
            }
        }
        return $dirty;
    }

    /**
     * Retorna um array com os dados que podem ser exibidos da Model
     * @return array
     */
    public function toArray(): array
    {
        $data = [];
        if (property_exists($this, 'fields')) {
            foreach ($this->fields as $field) {
                if (property_exists($this, 'hidden') && in_array($field, $this->hidden)) {
                    continue;
                }
                $getter = 'get' . ucfirst($field);
                if (method_exists($this, $getter)) {
                    $data[$field] = $this->$getter();
                }
            }
        }
        return $data;
    }

    /**
     * @return array
     */
    public function getFields($all = false): array
    {
        $data = [];
        if (property_exists($this, 'fields')) {
            foreach ($this->fields as $field) {
                if (property_exists($this, 'hidden') && in_array($field, $this->hidden) && !$all) {
                    continue;
                }
                $data[] = $field;
            }
        }
        return $data;
    }
}
