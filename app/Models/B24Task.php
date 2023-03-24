<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B24Task extends Model
{
    use HasFactory;
    
    protected $table = 'b24_tasks';
    protected $fillable = [
        'ID', 'STAGE_ID', 'PARENT_ID', 'GROUP_ID', 'RESPONSIBLE_ID','REAL_STATUS',
        'STATUS', 'FORUM_ID', 'FORUM_TOPIC_ID', 'DESCRIPTION', 'RESPONSIBLE_NAME','RESPONSIBLE_LAST_NAME',
        'GUID', 'ACTIVITY_DATE', 'CLOSED_DATE', 'CREATED_DATE', 'DEADLINE',
    ];
}