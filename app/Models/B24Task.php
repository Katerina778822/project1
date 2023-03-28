<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B24Task extends Model
{
    use HasFactory;
    
    protected $table = 'b24_tasks';
    protected $fillable = [
        'id', 'timeEstimate', 'UF_CRM_TASK_LEAD', 'UF_CRM_TASK_CONTACT','UF_CRM_TASK_COMPANY', 'responsibleId','status',
        'UF_CRM_TASK_DEAL', 'title', 'description', 'closedDate', 'createdDate','deadline','changedDate',
        'dateStart', 
    ];
}