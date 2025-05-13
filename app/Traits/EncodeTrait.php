<?php

namespace App\Traits;

use Hashids\Hashids;

trait EncodeTrait
{

    use RequestTrait;

    protected $hashids;

    /**
     * Obtém a instância singleton de Hashids.
     *
     * @return Hashids
     */
    protected function getHashids(): Hashids
    {
        if (!$this->hashids) {
            $this->hashids = new Hashids($_ENV['APP_SECRET'], 8);
        }
        return $this->hashids;
    }

    /**
     * @param int|null $value
     * @return string
     */
    public function encode(int $value = null): ?string
    {
        if (empty($value)) {
            return null;
        }
        return $this->getHashids()->encode($value);
    }

    /**
     * Decodifica uma string obfuscada de volta ao valor original.
     *
     * @param string|null $value
     * @return int|null
     */
    public function decode(string $value = null): ?int
    {
        if (empty($value)) {
            return null;
        }
        $decoded = $this->getHashids()->decode($value);
        return $decoded[0] ?? null;
    }


    /**
     * @param string|null $name
     * @return int|null
     */
    public function decodeRouteParam(string $name = null): ?int
    {
        $value = $this->getRouteParam($name);
        if (empty($value)) {
            return null;
        }
        $decoded = $this->getHashids()->decode($value);
        return $decoded[0] ?? null;
    }

}
