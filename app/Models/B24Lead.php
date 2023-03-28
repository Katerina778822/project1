<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B24Lead extends Model
{
    use HasFactory;
    protected $table = 'b24_leads';
    protected $fillable = [
        'ID','TITLE','NAME','LAST_NAME','SOURCE_ID','STATUS_ID','COMMENTS','ADDRESS','UTM_SOURCE',
        'UTM_MEDIUM','UTM_CAMPAIGN','UTM_CONTENT','UTM_TERM','CURRENCY_ID','PHONE','OPPORTUNITY','COMPANY_ID',  
        'CONTACT_ID','ASSIGNED_BY_ID','CREATED_BY_ID','DATE_CREATE','DATE_CLOSED','DATE_MODIFY',
    ];
}
