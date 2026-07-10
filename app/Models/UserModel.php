<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tenant_id',
        'name',
        'email',
        'password',
        'role',
        'profile_photo',
        'phone',
        'address',
        'is_active',
        'email_verified',
        'email_verified_at',
        'verification_token',
        'reset_token',
        'reset_token_expired_at',
    ];
    protected $useTimestamps = true;
    protected $hidden = ['password'];

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }
}
