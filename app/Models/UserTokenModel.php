<?php

namespace App\Models;

use App\Interfaces\ModelInterface;

class UserTokenModel extends Model implements ModelInterface
{

    const VALID = 'valid';
    const INVALID = 'invalid';

    private ?int $id = null;
    private ?int $user_id = null;
    private ?string $token = null;
    private ?string $device = null;
    private ?string $ip_address = null;
    private ?string $status = null;
    private ?string $expire_at = null;
    private ?string $created_at = null;
    private ?string $logged_out_at = null;

    protected string $table = 'user_tokens';

    protected array $fields = [
        'id', 'user_id', 'token', 'device', 'ip_address',
        'status', 'expire_at', 'created_at', 'logged_out_at'
    ];

    protected array $hidden = ['token'];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): UserTokenModel
    {
        $this->id = $id;
        return $this;
    }

    public function getUser_id(): ?int
    {
        return $this->user_id;
    }

    public function setUser_id(?int $user_id): UserTokenModel
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): UserTokenModel
    {
        $this->token = $token;
        return $this;
    }

    public function getDevice(): ?string
    {
        return $this->device;
    }

    public function setDevice(?string $device): UserTokenModel
    {
        $this->device = $device;
        return $this;
    }

    public function getIp_address(): ?string
    {
        return $this->ip_address;
    }

    public function setIp_address(?string $ip_address): UserTokenModel
    {
        $this->ip_address = $ip_address;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): UserTokenModel
    {
        $this->status = $status;
        return $this;
    }

    public function getExpire_at(): ?string
    {
        return $this->expire_at;
    }

    public function setExpire_at(?string $expire_at): UserTokenModel
    {
        $this->expire_at = $expire_at;
        return $this;
    }

    public function getCreated_at(): ?string
    {
        return $this->created_at;
    }

    public function setCreated_at(?string $created_at): UserTokenModel
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getLogged_out_at(): ?string
    {
        return $this->logged_out_at;
    }

    public function setLogged_out_at(?string $logged_out_at): UserTokenModel
    {
        $this->logged_out_at = $logged_out_at;
        return $this;
    }
}
