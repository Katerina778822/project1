<?php

namespace App\Http\Controllers;

use App\Models\B24Activity;
use App\Models\B24Activity2;
use App\Models\B24Agenda;
use App\Models\B24Contact;
use App\Models\B24Deal;
use App\Models\B24Task;
use App\Models\B24test;
use App\Models\Company;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class B24AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $activity = B24Contact::find(4437);
        $activity->NAME = 'Юра Черкассы Тэч'; // Устанавливаем новое значение
        $activity->save();
       
        $activity = B24Contact::find(4437);
        dd($activity->NAME);


        $date = Carbon::today();
        $date2 = new DateTime();
        $date2 = $date2->setTime(0, 0, 0);
        //$date->modify('+1 month');
        $tomorrow = new DateTime();
        $tomorrow = $tomorrow->setTime(23, 59, 59);
        // получить список компаний по пользователю
        $user_id = 1;
        $userCompanies = Company::where('ASSIGNED_BY_ID', $user_id)->get();
        //перебор компаний на предмет наличия задач
        //  $date2->modify('-4 day'); //temp

        foreach ($userCompanies as $userCompany) {
            //актуальность компании на сегодня
            // задача в компании
            $companyTasks = B24Task::where('UF_CRM_TASK_COMPANY', $userCompany->ID)
                ->whereBetween('b24_tasks.deadline', [$date2, $tomorrow])
                ->get();
            if (count($companyTasks)) {
                $userCompany->STATUS = 1; // TODAY
                $userCompany->AGENDA_DATE = $companyTasks->max(function ($item) {
                    return $item->deadline;
                });
            } else { //дело (активность) в компании
                $companyTasks = B24Activity::where('COMPANY_ID', $userCompany->ID)
                    ->whereBetween('b24_activity.DEADLINE', [$date2, $tomorrow])->get();
                if (count($companyTasks)) {
                    $userCompany->STATUS = 1; // TODAY
                    $userCompany->AGENDA_DATE = $companyTasks->max(function ($item) {
                        return $item->DEADLINE;
                    });
                    $i = 0; //temp
                } else { // задача в сделке
                    $deals = B24Deal::where('COMPANY_ID', $userCompany->ID)->get();
                    $dealIds = $deals->pluck('ID');
                    $companyTasks = B24Task::whereIn('UF_CRM_TASK_DEAL',  $dealIds)
                        ->whereBetween('b24_tasks.deadline', [$date2, $tomorrow])->get();
                    if (count($companyTasks)) {
                        $userCompany->STATUS = 1; // TODAY
                        $userCompany->AGENDA_DATE = $companyTasks->max(function ($item) {
                            return $item->DEADLINE;
                        });
                    } else { // дело в сделке
                        $companyTasks = B24Activity::whereIn('DEAL_ID',  $dealIds)
                            ->whereBetween('b24_activity.DEADLINE', [$date2, $tomorrow])
                            ->where('COMPLETED', 'N')
                            ->get();
                        if (count($companyTasks)) {
                            $userCompany->STATUS = 1; // TODAY
                            $userCompany->AGENDA_DATE = $companyTasks->max(function ($item) {
                                return $item->DEADLINE;
                            });
                            $i = 0; //temp
                        }
                    }
                }
            }
        }

        //получить список компаний для данного юзера с актуальной задачей/активностью в компании, сделке
        // актуальная задача в компании 
        $t = Company::join('b24_tasks', 'companies.ID', '=', 'b24_tasks.UF_CRM_TASK_COMPANY')
            // ->where('ASSIGNED_BY_ID', $user_id)
            ->whereBetween('b24_tasks.deadline', [$date2, $tomorrow])
            /*       ->where([
                ['b24_tasks.deadline', '>',  '2023-05-05 00:00:00'],
                ['b24_tasks.deadline', '<', '2023-05-06 00:00:00'],
            ])*/
            ->select('companies.*', 'b24_tasks.UF_CRM_TASK_COMPANY', 'b24_tasks.title')
            ->distinct()
            ->get();
        // dd($t);
        //актуальная задача в сделке
        $t2 = Company::join('b24_deals', 'companies.ID', '=', 'b24_deals.COMPANY_ID')
            ->join('b24_tasks', 'b24_deals.ID', '=', 'b24_tasks.UF_CRM_TASK_DEAL')
            //           ->where('companies.ASSIGNED_BY_ID', $user_id)
            ->where([
                ['b24_tasks.deadline', '>',  $date],
                ['b24_tasks.deadline', '<', $date->copy()->addDay()],
            ])
            //           ->whereBetween('b24_tasks.deadline', [$date . ' 00:00:00', $date . ' 23:59:59'])
            ->select('companies.*', 'b24_tasks.UF_CRM_TASK_COMPANY', 'b24_tasks.title')
            ->distinct()
            ->get();
        //   dd($t2);
        //актуальная активность в компании
        //актуальная активность в сделке
        return view('bitrix24.b24agenda.index', [
            'items' => $t,
            //   'id_node' => $id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
