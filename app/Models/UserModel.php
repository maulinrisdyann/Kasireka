<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tenant_id', 'name', 'email', 'password', 'role', 'is_active',
    ];
    protected $useTimestamps = true;
    protected $hidden = ['password'];

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }
}
