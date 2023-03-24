<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    protected $fillable = [
        'ID', 'TITLE', 'UF_CRM_1597826997473', 'ASSIGNED_BY_ID', 'COMPANY_TYPE', 'DATE_CREATE', 'DATE_MODIFY', 'LAST_ACTIVITY_TIME',
        'ASSIGNED_BY_ID', 'LAST_ACTIVITY_BY', 'UF_CRM_1540465145514', 'UF_CRM_1540121191354', 'UF_CRM_5DBAA9FFCC357'
    ];

    public function b24deals()
    {
        return $this->hasMany(B24Deal::class, 'b24deal');
    }

    public function b24fields()
    {
        return $this->hasOne(B24Field::class, 'b24field');
    }

    public function b24ring()
    {
        return $this->hasMany(B24Ring::class, 'b24ring');
    }
    public function b24task()
    {
        return $this->hasMany(B24Task::class, 'b24task');
    }
    public function b24user()
    {
        return $this->hasOne(B24User::class, 'b24user');
    }
}
