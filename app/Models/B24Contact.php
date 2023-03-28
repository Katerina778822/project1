<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B24Contact extends Model
{
    use HasFactory;
    protected $table = 'b24_contacts';
    protected $fillable = [
        'ID','LAST_NAME','NAME','ASSIGNED_BY_ID','COMPANY_ID','DATE_CREATE',
    ];

    public function company()
    {
        return $this->belongsToMany(Company::class, 'b24_contact_company', 'contact_id', 'company_id');
    }
}
