<?php

namespace App\Http\Controllers;

use App\Jobs\B24AgendaFetch;
use App\Models\B24Activity;
use App\Models\B24Activity2;
use App\Models\B24Agenda;
use App\Models\B24Contact;
use App\Models\B24Deal;
use App\Models\B24Lead;
use App\Models\B24Task;
use App\Models\B24test;
use App\Models\B24User;
use App\Models\Company;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class B24AgendaController extends Controller
{
    private DateTime $today;
    private DateTime $tomorrow;
    private DateTime $tomorrowday1;
    private DateTime $tomorrowday2;
    private DateTime $yesterday1;
    private DateTime $yesterday2;



    public function __construct()
    {
        $this->today = new DateTime();
        $this->today = $this->today->setTime(0, 0, 0);
        //$date->modify('+1 month');
        $this->tomorrow = new DateTime();
        $this->tomorrow->setTime(23, 59, 59);
        $this->tomorrowday1 = new DateTime();
        $this->tomorrowday2 = new DateTime();
        $this->yesterday1 = new DateTime();
        $this->yesterday2 = new DateTime();
        $this->tomorrowday1->modify('+1 day')->setTime(0, 0, 0);
        $this->tomorrowday2->modify('+180 day')->setTime(23, 59, 59);
        $this->yesterday1->modify('-1 day')->setTime(23, 59, 59);
        $this->yesterday2->modify('-60 day')->setTime(23, 59, 59);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // получить список компаний по пользователю
        $items = B24User::WHERE('ACTIVE', 1)->get();




        return view('bitrix24.b24agenda.index', [
            'items' => $items,
            //   'id_node' => $id
        ]);
    }

    private function checkUserCompanyToday(Company $userCompany)
    {
        // задача в компании
        $companyTasks = B24Task::where('UF_CRM_TASK_COMPANY', $userCompany->ID)
            ->whereBetween('b24_tasks.deadline', [$this->today, $this->tomorrow])
            ->where('closedDate', '=', null)
            ->get();
        if (count($companyTasks)) {
            $userCompany->STATUS = 1; // TODAY
            $userCompany->AGENDA_DATE = $companyTasks->max(function ($item) {
                return $item->deadline;
            });
            return true;
        } else { //дело (активность) в компании
            $companyTasks = B24Activity::where('COMPANY_ID', $userCompany->ID)
                ->whereBetween('b24_activity.DEADLINE', [$this->today, $this->tomorrow])
                ->where('COMPLETED', 'N')
                ->get();
            if (count($companyTasks)) {
                $userCompany->STATUS = 1; // TODAY
                $userCompany->AGENDA_DATE = $companyTasks->max(function ($item) {
                    return $item->DEADLINE;
                });
                return true;
            } else { // задача в сделке
                $deals = B24Deal::where('COMPANY_ID', $userCompany->ID)->get();
                $dealIds = $deals->pluck('ID');
                $companyTasks = B24Task::whereIn('UF_CRM_TASK_DEAL',  $dealIds)
                    ->whereBetween('b24_tasks.deadline', [$this->today, $this->tomorrow])
                    ->where('closedDate', '=', null)
                    ->get();
                if (count($companyTasks)) {
                    $userCompany->STATUS = 1; // TODAY
                    $userCompany->AGENDA_DATE = $companyTasks->max(function ($item) {
                        return $item->deadline;
                    });
                    return true;
                } else { // дело в сделке
                    $companyTasks = B24Activity::whereIn('DEAL_ID',  $dealIds)
                        ->whereBetween('b24_activity.DEADLINE', [$this->today, $this->tomorrow])
                        ->where('COMPLETED', 'N')
                        ->get();
                    if (count($companyTasks)) {
                        $userCompany->STATUS = 1; // TODAY
                        $userCompany->AGENDA_DATE = $companyTasks->max(function ($item) {
                            return $item->DEADLINE;
                        });
                        return true;
                    }
                }
            }
        }
        return false;
    }
    private function checkUserCompanyTomorrow(Company $userCompany)
    {
        // задача в компании
        $companyTasks = B24Task::where('UF_CRM_TASK_COMPANY', $userCompany->ID)
            ->whereBetween('b24_tasks.deadline', [$this->tomorrowday1, $this->tomorrowday2])
            ->where('closedDate', '=', null)
            ->get();
        if (count($companyTasks)) {
            $userCompany->STATUS = 0; // TODAY
            $userCompany->AGENDA_DATE = $companyTasks->max(function ($item) {
                return $item->deadline;
            });
            return true;
        } else { //дело (активность) в компании
            $companyTasks = B24Activity::where('COMPANY_ID', $userCompany->ID)
                ->whereBetween('b24_activity.DEADLINE', [$this->tomorrowday1, $this->tomorrowday2])
                ->where('COMPLETED', 'N')
                ->get();
            if (count($companyTasks)) {
                $userCompany->STATUS = 0; // TODAY
                $userCompany->AGENDA_DATE = $companyTasks->max(function ($item) {
                    return $item->DEADLINE;
                });
                return true;
            } else { // задача в сделке
                $deals = B24Deal::where('COMPANY_ID', $userCompany->ID)->get();
                $dealIds = $deals->pluck('ID');
                $companyTasks = B24Task::whereIn('UF_CRM_TASK_DEAL',  $dealIds)
                    ->whereBetween('b24_tasks.deadline', [$this->tomorrowday1, $this->tomorrowday2])
                    ->where('closedDate', '=', null)
                    ->get();
                if (count($companyTasks)) {
                    $userCompany->STATUS = 0; // TODAY
                    $userCompany->AGENDA_DATE = $companyTasks->max(function ($item) {
                        return $item->deadline;
                    });
                    return true;
                } else { // дело в сделке
                    $companyTasks = B24Activity::whereIn('DEAL_ID',  $dealIds)
                        ->whereBetween('b24_activity.DEADLINE', [$this->tomorrowday1, $this->tomorrowday2])
                        ->where('COMPLETED', 'N')
                        ->get();
                    if (count($companyTasks)) {
                        $userCompany->STATUS = 0; // TODAY
                        $userCompany->AGENDA_DATE = $companyTasks->max(function ($item) {
                            return $item->DEADLINE;
                        });
                        return true;
                    }
                }
            }
        }
        return false;
    }
    private function checkUserCompanyYesterday(Company $userCompany)
    {
        // задача в компании
        $companyTasks = B24Task::where('UF_CRM_TASK_COMPANY', $userCompany->ID)
            ->where([
                ['closedDate', '=', null],
                ['b24_tasks.deadline', '<', $this->yesterday1],
            ])
            ->get();
        if (count($companyTasks)) {
            $userCompany->STATUS = 2; // TODAY
            $userCompany->AGENDA_DATE = $companyTasks->max(function ($item) {
                return $item->deadline;
            });
            return true;
        } else { //дело (активность) в компании
            $companyTasks = B24Activity::where('COMPANY_ID', $userCompany->ID)
                ->where([
                    ['COMPLETED', 'N'],
                    ['b24_activity.DEADLINE', '<', $this->yesterday1],
                ])
                ->get();
            if (count($companyTasks)) {
                $userCompany->STATUS = 2; // TODAY
                $userCompany->AGENDA_DATE = $companyTasks->max(function ($item) {
                    return $item->DEADLINE;
                });
                return true;
            } else { // задача в сделке
                $deals = B24Deal::where('COMPANY_ID', $userCompany->ID)->get();
                $dealIds = $deals->pluck('ID');
                $companyTasks = B24Task::whereIn('UF_CRM_TASK_DEAL',  $dealIds)
                    ->where([
                        ['closedDate', '=', null],
                        ['b24_tasks.deadline', '<', $this->yesterday1],
                    ])
                    ->get();
                if (count($companyTasks)) {
                    $userCompany->STATUS = 2; // TODAY
                    $userCompany->AGENDA_DATE = $companyTasks->max(function ($item) {
                        return $item->deadline;
                    });
                    return true;
                } else { // дело в сделке
                    $companyTasks = B24Activity::whereIn('DEAL_ID',  $dealIds)
                        ->where([
                            ['COMPLETED', 'N'],
                            ['b24_activity.DEADLINE', '<', $this->yesterday1],
                        ])
                        ->get();
                    if (count($companyTasks)) {
                        $userCompany->STATUS = 2; // TODAY
                        $userCompany->AGENDA_DATE = $companyTasks->max(function ($item) {
                            return $item->DEADLINE;
                        });
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function checkUserCompanyLastDealWon(Company $userCompany)
    {
        //последняя сделка успешная
        $winStateArray = ['C23:WON', 'C19:WON',];
        $companyDeals = B24Deal::where('COMPANY_ID', $userCompany->ID)
            ->whereBetween('CLOSEDATE', [$this->yesterday2, $this->yesterday1])
            ->whereIn('STAGE_ID', $winStateArray)
            ->get();
        if (count($companyDeals)) {
            $userCompany->STATUS = 3; // TODAY
            $userCompany->AGENDA_DATE = $companyDeals->max(function ($item) {
                return $item->CLOSEDATE;
            });
            return true;
        }
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
    public function show($user_id)
    {
        $file = 'userfiles/' . $user_id . 'json';
        // чтение массива из файла
        $json = file_get_contents($file);
        $userCompanies = json_decode($json, true);
        return view('bitrix24.b24agenda.show', [
            'items' => $userCompanies,
            //   'id_node' => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {

        $job = new B24AgendaFetch($user_id);
        $this->dispatch($job);
        return redirect()->back();
    }

    public function fetchData($user_id)
    {

        //получить список компаний для данного юзера с актуальной задачей/активностью в компании, сделке
        // актуальная задача в компании 
        $statusArr = [1617, 349, 1417, 1659, 1419, 1753]; //UF_CRM_1540465145514 - статусы клиента
        $userCompanies = Company::where('ASSIGNED_BY_ID', $user_id)
            ->whereIn('UF_CRM_1540465145514', $statusArr)
            ->get();

        //перебор компаний на предмет наличия задач
        //  $date2->modify('-4 day'); //temp
        foreach ($userCompanies as $userCompany) {
            //актуальность компании на сегодня
            if ($userCompany->ID == 4495) //temp
                $i = 0;
            if (!$this->checkUserCompanyToday($userCompany))
                if (!$this->checkUserCompanyTomorrow($userCompany))
                    if (!$this->checkUserCompanyYesterday($userCompany))
                        if (!$this->checkUserCompanyLastDealWon($userCompany)) {
                            $userCompany->STATUS = 4;
                        }
            //if ($userCompany->ID == 4495)
            //  dd($userCompany->STATUS, ' ', $userCompany->AGENDA_DATE);

        }

        //перебор лидов на предмет наличия задач
        $dealStage = ['NEW', '22'];
        $userLeads = B24Lead::where([
            ['ASSIGNED_BY_ID', $user_id],
            ['STATUS_ID', '!=', 'CONVERTED']
        ])
            ->whereIn('STATUS_ID',  $dealStage)
            ->get();
        foreach ($userLeads as $userLead) {
            if ($userLead->ID == 32495) //temp
                $i = 0;
            if (!$this->checkUserLeadToday($userLead, $userCompanies))
                if (!$this->checkUserLeadTomorrow($userLead, $userCompanies))
                    if (!$this->checkUserLeadYesterday($userLead, $userCompanies)) {
                        $userLead->TITLE = 'ЛИД: ' . $userLead->TITLE;
                        $userLead->STATUS = 4; // TODAY
                        $userLead->URL = $userLead->ID; // TODAY
                        $userCompanies->add($userLead);
                    }
        }



        $userCompanies = $userCompanies->sortByDesc('AGENDA_DATE')->sortBy('STATUS');
        try {
            $file = 'userfiles/' . $user_id  . 'json'; //test
            $json = json_encode($userCompanies);
            file_put_contents($file, $json);
        } catch (Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());
        }
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

    private function old()
    {
        $t = Company::join('b24_tasks', 'companies.ID', '=', 'b24_tasks.UF_CRM_TASK_COMPANY')
            // ->where('ASSIGNED_BY_ID', $user_id)
            ->whereBetween('b24_tasks.deadline', [$this->today, $this->tomorrow])
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
                ['b24_tasks.deadline', '>',  $this->today],
                ['b24_tasks.deadline', '<', $this->tomorrow],
            ])
            //           ->whereBetween('b24_tasks.deadline', [$date . ' 00:00:00', $date . ' 23:59:59'])
            ->select('companies.*', 'b24_tasks.UF_CRM_TASK_COMPANY', 'b24_tasks.title')
            ->distinct()
            ->get();
        //   dd($t2);
        //актуальная активность в компании
        //актуальная активность в сделке
    }

    public function checkUserLeadToday($lead, $companyCollection)
    {
        $leadTasks = B24Task::where([
            ['UF_CRM_TASK_LEAD', $lead->ID],
            ['closedDate', '=', null]
        ])
            ->whereBetween('b24_tasks.deadline', [$this->today, $this->tomorrow])
            ->get();
        if (count($leadTasks)) {
            $lead->TITLE = 'ЛИД: ' . $lead->TITLE;
            $lead->STATUS = 1; // TODAY
            $lead->URL = $lead->ID; // TODAY
            $lead->AGENDA_DATE = $leadTasks->max(function ($item) {
                return $item->deadline;
            });
            $companyCollection->add($lead);
            return true;
        } else { //дело (активность) в компании
            $leadTasks = B24Activity::whereBetween('b24_activity.DEADLINE', [$this->today, $this->tomorrow])
                ->where([
                    ['LEAD_ID', $lead->ID],
                    ['COMPLETED', 'N'],
                ])
                ->get();
            if (count($leadTasks)) {

                $lead->TITLE = 'ЛИД: ' . $lead->TITLE;
                $lead->STATUS = 1; // TODAY
                $lead->URL = $lead->ID; // TODAY
                $lead->AGENDA_DATE = $leadTasks->max(function ($item) {
                    return $item->DEADLINE;
                });
                $companyCollection->add($lead);
                return true;
            }
        }
    }
    public function checkUserLeadTomorrow($lead, $companyCollection)
    {

        $leadTasks = B24Task::where([
            ['UF_CRM_TASK_LEAD', $lead->ID],
            ['closedDate', '=', null]
        ])
            ->whereBetween('b24_tasks.deadline', [$this->tomorrowday1, $this->tomorrowday2])
            ->get();
        if (count($leadTasks)) {
            $lead->TITLE = 'ЛИД: ' . $lead->TITLE;
            $lead->STATUS = 0; // TODAY
            $lead->URL = $lead->ID; // TODAY
            $lead->AGENDA_DATE = $leadTasks->max(function ($item) {
                return $item->deadline;
            });
            $companyCollection->add($lead);
            return true;
        } else { //дело (активность) в компании
            $leadTasks = B24Activity::whereBetween('b24_activity.DEADLINE', [$this->tomorrowday1, $this->tomorrowday2])
                ->where([
                    ['LEAD_ID', $lead->ID],
                    ['COMPLETED', 'N'],
                ])
                ->get();
            if (count($leadTasks)) {

                $lead->TITLE = 'ЛИД: ' . $lead->TITLE;
                $lead->STATUS = 0; // TODAY
                $lead->URL = $lead->ID; // TODAY
                $lead->AGENDA_DATE = $leadTasks->max(function ($item) {
                    return $item->DEADLINE;
                });
                $companyCollection->add($lead);
                return true;
            }
        }
    }
    public function checkUserLeadYesterday($lead, $companyCollection)
    { {

            $leadTasks = B24Task::where([
                ['UF_CRM_TASK_LEAD', $lead->ID],
                ['closedDate', '=', null],
                ['b24_tasks.deadline', '<', $this->yesterday1]
            ])
                //                ->whereBetween('b24_tasks.deadline', [$this->tomorrowday1, $this->tomorrowday2])
                ->get();
            if (count($leadTasks)) {
                $lead->TITLE = 'ЛИД: ' . $lead->TITLE;
                $lead->STATUS = 2; // TODAY
                $lead->URL = $lead->ID; // TODAY
                $lead->AGENDA_DATE = $leadTasks->max(function ($item) {
                    return $item->deadline;
                });
                $companyCollection->add($lead);
                return true;
            } else { //дело (активность) в компании
                $leadTasks = B24Activity::where([
                    ['LEAD_ID', $lead->ID],
                    ['COMPLETED', 'N'],
                    ['b24_activity.DEADLINE', '<', $this->yesterday1],
                ])
                    ->get();
                if (count($leadTasks)) {

                    $lead->TITLE = 'ЛИД: ' . $lead->TITLE;
                    $lead->STATUS = 2; // TODAY
                    $lead->URL = $lead->ID; // TODAY
                    $lead->AGENDA_DATE = $leadTasks->max(function ($item) {
                        return $item->DEADLINE;
                    });
                    $companyCollection->add($lead);
                    return true;
                }
            }
        }
    }
}
