<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B24Activity extends Model
{
    use HasFactory;
    protected $table = 'b24_activity';
    protected $fillable = [
        'ID2','OWNER_ID','OWNER_TYPE_ID','ASSOCIATED_ENTITY_ID','AUTHOR_ID','EDITOR_ID','PROVIDER_ID',
        'PROVIDER_TYPE_ID','SUBJECT','ASSIGNED_BY_ID','COMPANY_ID','CREATED','LAST_UPDATED',
        'START_TIME','END_TIME','DEADLINE','LEAD_ID','DEAL_ID','CONTACT_ID', 'COMPLETED','DESCRIPTION'
    ];

    protected $guarded = [];
} 