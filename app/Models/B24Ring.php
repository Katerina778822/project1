<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B24Ring extends Model
{
    use HasFactory;

    protected $table = 'b24_rings';
    protected $fillable = [
        'ID', 'CALL_ID', 'PORTAL_USER_ID', 'PHONE_NUMBER', 'CALL_CATEGORY',
        'CALL_DURATION',
        'CALL_START_DATE',
        'CRM_ENTITY_TYPE',
        // 'CRM_ENTITY_ID',
        'CRM_ACTIVITY_ID',
        'CALL_TYPE',
        'RECORD_FILE_ID',
        'CALL_RECORD_URL',
        'CALL_FAILED_REASON',
        'CRM_LEAD_ID',
        'CRM_COMPANY_ID',
        'CRM_CONTACT_ID',
    ];
}
