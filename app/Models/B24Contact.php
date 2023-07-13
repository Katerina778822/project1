<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B24Contact extends Model
{
    use HasFactory;
    protected $table = 'b24_contacts';
    protected $fillable = [
        'ID', 'LAST_NAME', 'NAME', 'ASSIGNED_BY_ID', 'COMPANY_ID', 'DATE_CREATE','DATE_MODIFY'
    ];
    protected $primaryKey = 'ID';

    public function company()
    {
        return $this->belongsToMany(Company::class, 'b24_contact_company', 'contact_id', 'company_id');
    }

    public function checkCompany()
    {
        if ($this->COMPANY_ID)
            return true;
        else
            return
                false;
    }
}
