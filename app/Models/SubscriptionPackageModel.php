<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriptionPackageModel extends Model
{
    protected $table      = 'subscription_packages';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'duration_days', 'price', 'description', 'is_active'];
    protected $useTimestamps = true;
}
