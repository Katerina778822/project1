<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    public static $clientStatus = [
        0 => '-',
        1 => 'Клиент',
        2 => 'База',
        3 => 'Остывший',
        4 => 'Новый',
    ];
    protected $table = 'companies';
    protected $fillable = [
        'ID', 'TITLE', 'UF_CRM_1597826997473', 'ASSIGNED_BY_ID', 'COMPANY_TYPE', 'DATE_CREATE', 'DATE_MODIFY', 'LAST_ACTIVITY_TIME',
        'ASSIGNED_BY_ID', 'LAST_ACTIVITY_BY', 'UF_CRM_1540465145514', 'UF_CRM_1540121191354', 'UF_CRM_5DBAA9FFCC357'
    ];


    protected $primaryKey = 'ID';

    public function b24deals()
    {
        return $this->hasMany(B24Deal::class, 'b24deal');
    }

    public function b24fields()
    {
        return $this->hasOne(B24Field::class, 'b24field');
    }

    public function b24ring()
    {
        return $this->hasMany(B24Ring::class, 'b24ring');
    }
    public function b24task()
    {
        return $this->hasMany(B24Task::class, 'b24task');
    }


    public function contacts()
    {
        return $this->belongsToMany(Company::class, 'b24_contact_company', 'company_id', 'contact_id');
    }



    public function b24user()
    {
        return $this->belongsTo(B24User::class, 'ASSIGNED_BY_ID', 'ID');
    }

    //@returns 4-новый; 3-Остывший; 2 - База; 1 - Клиент;
    public function getClientStatus()
    {
        if($this->ID==1179)//TEMP!!
        $r=0; 
        $deals  = B24Deal::where('COMPANY_ID',$this->ID)->get();
        if ($deals->count() == 0)
            return 4;   //4-новый
        else {
            $dealsLastData = $deals->max(function ($deal) {
                return $deal->CLOSEDATE;
            });
            $dealsLast = $deals->firstWhere('CLOSEDATE', $dealsLastData);
            if ($deals->count() == 1 && $dealsLast->CLOSED == 'N') //последняя сделка открыта
                return 4;  //4-новый
            $winStateArray = ['C23:WON']; //развоз
            $dealsSuccessCargo = $deals->whereIn('STAGE_ID', $winStateArray);
            $winStateArray = ['C19:WON']; //Украина
            $dealsSuccessUkraine = $deals->whereIn('STAGE_ID', $winStateArray);
            if ($dealsSuccessCargo->count() > 0 || $dealsSuccessUkraine->count() > 0) {
                $dealWithMaxDateCargo = $dealsSuccessCargo->max(function ($deal) {
                    return $deal->CLOSEDATE;
                });
                $dealWithMaxDateUkraine = $dealsSuccessUkraine->max(function ($deal) {
                    return $deal->CLOSEDATE;
                });
                $dealWithMaxDateCargo = new DateTime($dealWithMaxDateCargo);
                $dealWithMaxDateUkraine = new DateTime($dealWithMaxDateUkraine);
                $yesterdayCargo = new DateTime();
                $yesterdayUkraine = new DateTime();
                $yesterdayCargo->modify('-28 day')->setTime(0, 0, 0);
                $yesterdayUkraine->modify('-60 day')->setTime(0, 0, 0);
                if (
                    $dealWithMaxDateUkraine > $yesterdayUkraine ||
                    $dealWithMaxDateCargo> $yesterdayCargo
                ) {
                    return 1; //Клиент
                } else
                    return 3; //Остывший
            } else
                return 2; //2 - База
        }
    }
}
