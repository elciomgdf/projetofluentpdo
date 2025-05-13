<?php

namespace App\Interfaces;

use App\Models\Model;

interface ModelInterface {
    public function getId(): ?int;
    public function setId(?int $id): Model;
}