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
    public function getClientStatus($start, $end)
    {
       // if ($this->ID == 8759) //TEMP!!
         //   $r = 0;
        $deals  = B24Deal::where('COMPANY_ID', $this->ID)->get();
        if ($deals->count() == 0)
            return 4;   //4-новый
        else {
            $dealsLastData = $deals->max(function ($deal) {
                return $deal->CLOSEDATE;
            });
            if ($dealsLastData > $start->format('Y-m-d H:i:s') && $dealsLastData < $end->format('Y-m-d H:i:s') && $deals->count() <= 1) {
                return 4;  //4-новый - сделка закрыта сегодня
            }
            $dealsLast = $deals->firstWhere('CLOSEDATE', $dealsLastData);
            if ($deals->count() == 1 && $dealsLast->CLOSED == 'N') //последняя сделка открыта
                return 4;  //4-новый
                //поиск выигрышных сделок
            $winStateArray = ['C23:WON','C25:WON']; //развоз
            $dealsSuccessCargo = $deals->whereIn('STAGE_ID', $winStateArray)->where('OPPORTUNITY','>','1');
            $winStateArray = ['C19:WON','C27:WON']; //Украина
            $dealsSuccessUkraine = $deals->whereIn('STAGE_ID', $winStateArray)->where('OPPORTUNITY','>','1');

            if ($dealsSuccessCargo->count() > 0 || $dealsSuccessUkraine->count() > 0) {
                $dealWithMaxDateCargo = null; //определение нач значений
                $yesterdayCargo = null;
                $yesterdayUkraine = null;
                $dealWithMaxDateUkraine = null;
                //выбор макс значений дат успешных сделок
                $dealWithMaxDateCargo = $dealsSuccessCargo->max(function ($deal) {
                    return $deal->CLOSEDATE;
                });
                $dealWithMaxDateUkraine = $dealsSuccessUkraine->max(function ($deal) {
                    return $deal->CLOSEDATE;
                });
                //приведение дат к нормальному формату
                if ($dealWithMaxDateCargo) {
                    $dealWithMaxDateCargo = new DateTime($dealWithMaxDateCargo);
                    $yesterdayCargo = new DateTime();
                    $yesterdayCargo->modify('-28 day')->setTime(0, 0, 0);
                }
                if ($dealWithMaxDateUkraine) {
                    $dealWithMaxDateUkraine = new DateTime($dealWithMaxDateUkraine);
                    $yesterdayUkraine = new DateTime();
                    $yesterdayUkraine->modify('-60 day')->setTime(0, 0, 0);
                }
                //определение состояние клиента по дате сделки
                if (
                    $dealWithMaxDateUkraine > $yesterdayUkraine ||
                    $dealWithMaxDateCargo > $yesterdayCargo
                ) {
                    return 1; //Клиент
                } else
                    return 3; //Остывший
            } else
                return 2; //2 - База
        }
    }

    //returns last open Deal
    public function getLastOpenDealStatus($statusBefore, DateTime $start, DateTime $end = null)
    {
        $deal = B24Deal::where([
            ['COMPANY_ID', $this->ID],
            ['CLOSED', 'N']
        ])->orderByDesc('DATE_CREATE')->first();
        if (!empty($deal)) {
            return $deal->getStatus($statusBefore, $start, $end);
        } else {
            $deal = B24Deal::where([
                ['COMPANY_ID', $this->ID],
            ])->orderByDesc('DATE_CREATE')->first();
            if (!empty($deal)) {
                return $deal->getStatus($statusBefore, $start, $end);
            }
        }
        return ['STATUS' => 0, 'SUMM' => 0];
    }
}
