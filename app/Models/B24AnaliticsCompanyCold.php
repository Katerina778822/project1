<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B24AnaliticsCompanyCold extends Model
{
    use HasFactory;
    protected $table = 'b24_analitics_company_colds';
    public $timestamps = false;

    protected $fillable = [
        'company_id',    'ring_id' ,   'task_id',    'deal_id'  ,  'ringContact_id',    'date'
    ];
}
