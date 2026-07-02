<?php
namespace App\Models;
use CodeIgniter\Model;
class PaymentAccountModel extends Model
{
    protected $table = 'payment_accounts';
    protected $primaryKey = 'id';
    protected $allowedFields=[
        'type',
        'account_name',
        'account_number',
        'holder_name',
        'is_active'
    ];
    protected $useTimestamps=true;
}