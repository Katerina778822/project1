<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B24Deal extends Model
{
    use HasFactory;
    public  static $dealStatusArray = [
        0 => '-',
        1 => 'Отказ',
        2 => 'Перенос',
        3 => 'Прогресс',
        4 => 'Продажа',
    ];
    public static $returnArray = ['C23:8','C19:5'];
    public static $looseStateArray = ['C19:LOSE', 'C19:APOLOGY', 'C19:2', 'C19:3', 'C19:4', 'C19:14', 'C19:7', 'C19:6', 'C23:LOSE', 'C23:APOLOGY', 'C23:3', 'C23:6', 'C23:7',  'C23:14', 'C23:15', 'C23:16'];
    public static $startArray = [
        'C23:NEW', 'C19:NEW', 
    ];
    public static $workStateArrayCargo = [
        'C23:NEW', 
    ];
    public static $workStateArrayUkr = [
        'C19:NEW', 'C19:PREPARATION', 'C19:EXECUTING', 'C19:FINAL_INVOICE', 
    ];
    public static $winStateArray = ['C23:WON', 'C19:WON','C23:EXECUTING', 'C23:FINAL_INVOICE', 'C23:9', 'C23:10', 'C23:11', 'C23:12', 'C23:13','C19:1', 'C19:9', 'C19:10', 'C19:11', 'C19:12', 'C19:13'];

    protected $table = 'b24_deals';
    protected $fillable = [
        'ID', 'ASSIGNED_BY_ID', 'COMPANY_ID', 'TITLE', 'STAGE_ID', 'CURRENCY_ID', 'CATEGORY_ID', 'CLOSED', 'STAGE_ID_BEFORE',
        'OPPORTUNITY', 'COMMENTS', 'IS_RETURN_CUSTOMER', 'UF_CRM_1545747379148', 'UF_CRM_5C20F23556A62',
        'UF_CRM_5BB6246DC30D8', 'UF_CRM_1545811346080', 'UF_CRM_1564411704463', 'UF_CRM_5CAB07390C964', 'UF_CRM_1540120643248',
        'UF_CRM_1545811274193', 'UF_CRM_1547732437301', 'DATE_CREATE', 'CLOSEDATE', 'UF_CRM_5C224D08961A9', 'DATE_MODIFY'
    ];
    protected $primaryKey = 'ID';

    //@ returns array ['STATUS' => $,'SUMM'=>$]
    public function getStatus($statusBefore)
    {
        $timezone = new DateTimeZone('Europe/Kiev');
        $start = new DateTime('now', $timezone);
        $start->setTime(0, 0, 0);
        $summ=$this->OPPORTUNITY;
        $dateModify = new DateTime($this->DATE_MODIFY??'2019-01-01');

        if($dateModify<$start)
            return ['STATUS' => 2,'SUMM'=>0];
      
        if ($this->STAGE_ID_BEFORE == ''&&!in_array($this->STAGE_ID, B24Deal::$looseStateArray)&&!(in_array($this->STAGE_ID, B24Deal::$winStateArray))) {
            $this->STAGE_ID_BEFORE = $this->STAGE_ID;
            $this->save();
            return ['STATUS' => 2,'SUMM'=>$summ];
        }
        if (in_array($this->STAGE_ID_BEFORE, B24Deal::$startArray)&&in_array($this->STAGE_ID, B24Deal::$returnArray)) {
            return ['STATUS' => -1,'SUMM'=> -$summ];
        }

        if ($this->STAGE_ID_BEFORE == $this->STAGE_ID&&$statusBefore==2&&!(in_array($this->STAGE_ID, B24Deal::$winStateArray))||$statusBefore==0) {
            return ['STATUS' => 2,'SUMM'=>$summ];
        } else {
            if (in_array($this->STAGE_ID, B24Deal::$looseStateArray)) {
                $this->STAGE_ID_BEFORE = 'C19:NEW';
                $this->save();
                return ['STATUS' => 1,'SUMM'=>$summ];
            }

            if (in_array($this->STAGE_ID, B24Deal::$winStateArray) || in_array($this->STAGE_ID, ['C23:FINAL_INVOICE', 'C23:9', 'C23:10', 'C23:11', 'C23:12', 'C23:13', 'C19:1', 'C19:9', 'C19:10', 'C19:11', 'C19:12', 'C19:13'])) {
                $this->STAGE_ID_BEFORE = 'C19:NEW';
                $this->DATE_WIN=$start->format('Y-m-d');
                $this->save();
                return ['STATUS' => 4,'SUMM'=>$summ];
            }

            if (in_array($this->STAGE_ID_BEFORE, ['C23:NEW', 'C19:NEW'])) {
                if (in_array($this->STAGE_ID, ['C19:PREPARATION', 'C19:EXECUTING', 'C19:FINAL_INVOICE', 'C23:EXECUTING'])) {
                    $this->STAGE_ID_BEFORE = $this->STAGE_ID;
                    $this->save();
                    return ['STATUS' => 3,'SUMM'=>$summ];
                }
            } elseif (in_array($this->STAGE_ID_BEFORE, ['C19:PREPARATION'])) {
                if (in_array($this->STAGE_ID, ['C19:EXECUTING', 'C19:FINAL_INVOICE',])) {
                    $this->STAGE_ID_BEFORE = $this->STAGE_ID;
                    $this->save();
                    return ['STATUS' => 3,'SUMM'=>$summ];
                }
            } elseif (in_array($this->STAGE_ID_BEFORE, ['C19:EXECUTING'])) {
                if (in_array($this->STAGE_ID, ['C19:FINAL_INVOICE',])) {
                    $this->STAGE_ID_BEFORE = $this->STAGE_ID;
                    $this->save();
                    return ['STATUS' => 3,'SUMM'=>$summ];
                }
            }
        }
        return ['STATUS' => 0,'SUMM'=>$summ];
    }
}
