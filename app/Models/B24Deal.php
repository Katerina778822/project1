<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B24Deal extends Model
{
    use HasFactory;
    
    protected $table = 'b24_deals';
    protected $fillable = [
        'ID','ASSIGNED_BY_ID', 'COMPANY_ID', 'TITLE', 'STAGE_ID', 'CURRENCY_ID','CATEGORY_ID', 
        'OPPORTUNITY', 'COMMENTS', 'IS_RETURN_CUSTOMER', 'UF_CRM_1545747379148', 'UF_CRM_5C20F23556A62',
        'UF_CRM_5BB6246DC30D8', 'UF_CRM_1545811346080', 'UF_CRM_1564411704463', 'UF_CRM_5CAB07390C964', 'UF_CRM_1540120643248',
        'UF_CRM_1545811274193', 'UF_CRM_1547732437301', 'DATE_CREATE', 'CLOSEDATE', 'UF_CRM_5C224D08961A9', 'DATE_MODIFY'
    ];
    protected $primaryKey = 'ID';
}
