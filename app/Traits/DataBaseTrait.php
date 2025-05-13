<?php

namespace App\Traits;

use Envms\FluentPDO\Exception;
use Envms\FluentPDO\Query;

/**
 * Trait para isolar o tratamento de banco de dados
 */
trait DataBaseTrait
{
    protected ?Query $fluent = null;

    protected bool $fillModel = false;

    protected function db(): Query
    {
        if ($this->fluent instanceof Query) {
            return $this->fluent;
        }

        $pdo = new \PDO(
            sprintf(
                'mysql:host=%s;dbname=%s;charset=utf8mb4',
                $_ENV['DB_HOST'],
                $_ENV['DB_NAME']
            ),
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD'],
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]
        );

        $this->fluent = new Query($pdo);

        return $this->fluent;
    }

    private function getTable(string $table = null): ?string
    {

        if (!$table && property_exists($this, 'table')) {
            $table = $this->table;
            $this->fillModel = true;
        }

        if (!$table) {
            throw new \RuntimeException('Nome da tabela não definido');
        }

        return $table;

    }

    /**
     * Faz uma consulta com base em um ID
     *
     * @param int $id
     * @param string|null $table
     * @return array|bool|null
     * @throws Exception
     */
    protected function findById(int $id, string $table = null): array|bool|null
    {
        $table = $this->getTable($table);
        return $this->db()->from($table)->where('id', $id)->fetch();
    }

    /**
     * Busca um registro com base em qualquer parâmetro
     * @param array $where
     * @param string|null $table
     * @param array $ignore
     * @return array|null
     * @throws Exception
     */
    public function findOneBy(array $where, string $table = null, array $ignore = []): array|bool|null
    {

        $table = $this->getTable($table);

        if (empty($where)) return null;

        $result = $this->db()->from($table);

        foreach ($where as $field => $value) {
            $result->where($field, $value);
        }

        if ($ignore) {
            foreach ($ignore as $field => $value) {
                $result->where("$field <> ?", $value);
            }
        }

        $data = $result->fetch();

        if ($this->fillModel && $data) {
            $this->initData = $data;
            $this->fill($data);
        }

        if ($data) {
            foreach ($data as $field => $value) {
                if (property_exists($this, 'hidden') && in_array($field, $this->hidden)) {
                    unset($data[$field]);
                }
            }
        }

        return $data;

    }

    /**
     * Faz um Update
     * @param int $id
     * @param array $data
     * @param string|null $table
     * @return bool
     * @throws Exception
     */
    protected function update(int $id, array $data, string $table = null): bool
    {
        $table = $this->getTable($table);
        return (bool)$this->db()->update($table)->set($data)->where('id', $id)->execute();
    }

    /**
     * Faz um Insert
     * @param array $data
     * @param string|null $table
     * @return int
     * @throws Exception
     */
    protected function insert(array $data, string $table = null): int
    {
        $table = $this->getTable($table);
        return $this->db()->insertInto($table)->values($data)->execute();
    }

    /**
     * @param int $id
     * @param string|null $table
     * @return bool
     * @throws Exception
     */
    public function delete(int $id, string $table = null): bool
    {
        $table = $this->getTable($table);
        return $this->db()->deleteFrom($table)->where('id', $id)->execute();
    }

    /**
     * @param int $limit
     * @param string $orderBy
     * @param string|null $table
     * @return array
     * @throws Exception
     */
    public function all(int $limit = 1000, string $orderBy = 'id', string $table = null)
    {
        $table = $this->getTable($table);
        $query = $this->db()->from($table)->orderBy($orderBy)->limit($limit ?? 1000);
        $items = (array)$query->fetchAll();
        if ($items) {
            foreach ($items as $key => $row) {
                $fields = array_keys($row);
                foreach ($fields as $field) {
                    if (property_exists($this, 'hidden') && in_array($field, $this->hidden)) {
                        unset($items[$key][$field]);
                    }
                }
            }
        }
        return $items;
    }

    /**
     * @param int $page
     * @param int $perPage
     * @param array $where
     * @param string $orderBy
     * @param string $direction
     * @param string|null $table
     * @return array
     * @throws Exception
     */
    public function paginate(int $page = 1, int $perPage = 10, array $where = [], string $orderBy = 'id', string $direction = 'ASC', string $table = null): array
    {

        $table = $this->getTable($table);

        $direction = sanitizeDirection($direction ?? 'ASC');

        $offset = ($page - 1) * $perPage;

        $query = $this->db()->from($table)
            ->orderBy("$orderBy $direction")
            ->limit($perPage)
            ->offset($offset);

        foreach ($where as $field => $value) {
            $query->where($field, $value);
        }

        $items = $query->fetchAll();

        if ($items) {
            foreach ($items as $key => $row) {
                $fields = array_keys($row);
                foreach ($fields as $field) {
                    if (property_exists($this, 'hidden') && in_array($field, $this->hidden)) {
                        unset($items[$key][$field]);
                    }
                }
            }
        }

        $total = $this->db()->from($table)->select(null)->select('COUNT(*)');
        foreach ($where as $field => $value) {
            $total->where($field, $value);
        }

        $total = (int)$total->fetchColumn();

        $total_pages = ceil($total / $perPage);

        return [
            'items' => $items,
            'current_page' => $page,
            'next_page' => $page < $total_pages ? $page + 1 : null,
            'previous_page' => ($page - 1) ?: null,
            'per_page' => $perPage,
            'total_pages' => $total_pages,
            'total' => $total
        ];
    }

    /**
     * Inicia uma transação
     * @return void
     */
    public function beginTransaction(): void
    {
        $this->db()->getPdo()->beginTransaction();
    }

    /**
     * Confirma uma transação
     * @return void
     */
    public function commit(): void
    {
        $this->db()->getPdo()->commit();
    }

    /**
     * Cancela uma transação
     * @return void
     */
    public function rollBack(): void
    {
        $this->db()->getPdo()->rollBack();
    }

}
