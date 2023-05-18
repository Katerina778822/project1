<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B24Raport extends Model
{
    use HasFactory;
    protected $fillable = [
        'USER_ID', 'COMPANY_ID', 'LEAD_ID', 'CONTACT_ID', 'DEAL_ID', 'TASK_ID', 'RING_ID', 'ACTIVITY_ID', 'DEAL_TYPE',
        'DEAL_STATUS', 'DATE',
    ];
}
