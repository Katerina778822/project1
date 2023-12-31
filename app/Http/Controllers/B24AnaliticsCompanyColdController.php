<?php

namespace App\Http\Controllers;

use App\Models\B24Analitics;
use App\Models\B24AnaliticsCompanyCold;
use App\Models\B24Contact;
use App\Models\B24Deal;
use App\Models\B24Lead;
use App\Models\B24Ring;
use App\Models\B24Task;
use App\Models\B24User;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Hamcrest\Arrays\IsArray;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;

class B24AnaliticsCompanyColdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // выбрать, посчитать и сгруппировать по дате
        $items = B24AnaliticsCompanyCold::where('since_date', '=', DB::raw('check_date'))->select('since_date', DB::raw('count(*) as total'))->groupBy('since_date')->get();

        return view('bitrix24.b24analitics.companies_date.index', [
            'items' => $items,
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
    public function CalcRaport($date)
    {
        // получить список уникальных b24_users
        $items = B24AnaliticsCompanyCold::where([
            ['b24_analitics_company_colds.check_date', '=', $date],
            ['b24_analitics_company_colds.since_date', '=', $date]
        ])
            ->join('companies', 'b24_analitics_company_colds.company_id', '=', 'companies.ID')
            ->join('b24_users', 'companies.ASSIGNED_BY_ID', '=', 'b24_users.ID')
            ->get()->unique('NAME');
        $users = $items->map(function ($item) {
            return [
                'ID' => $item->ID,
                'NAME' => $item->NAME,
                'LAST_NAME' => $item->LAST_NAME,
            ];
        });

        $result = [];
        $looseStateArray = ['C19:LOSE', 'C19:APOLOGY', 'C19:2', 'C19:3', 'C19:4', 'C19:14', 'C19:7', 'C19:6', 'C19:5', 'C23:LOSE', 'C23:APOLOGY', 'C23:3', 'C23:6', 'C23:7', 'C23:8', 'C23:14', 'C23:15', 'C23:16'];
        $workStateArray = [
            'C23:NEW', 'C23:EXECUTING', 'C23:FINAL_INVOICE', 'C23:9', 'C23:10', 'C23:11', 'C23:12', 'C23:13',
            'C19:NEW', 'C19:PREPARATION', 'C19:EXECUTING', 'C19:FINAL_INVOICE', 'C19:1', 'C19:9', 'C19:10', 'C19:11', 'C19:12', 'C19:13'
        ];
        $winStateArray = ['C23:WON', 'C19:WON',];

        $request = new Request([
            'since_date' => $date,
        ]);

        //$userCompanies = Company::where('ASSIGNED_BY_ID', $user['ID'])->get();
        $res = $this->companiesDate($request, $date);

        foreach ($users as $user) {
            //посчитать к-во компаний по каждому
            $user_deals = B24AnaliticsCompanyCold::join('companies', 'b24_analitics_company_colds.company_id', '=', 'companies.ID')
                ->where([
                    ['b24_analitics_company_colds.check_date', '=', $date],
                    ['b24_analitics_company_colds.since_date', '=', $date],
                    ['companies.ASSIGNED_BY_ID', '=', $user['ID']],
                ])
                ->get();
            $counts = $user_deals->count();
            $result[$user['ID']] = [
                'deals_all' => $counts,
                'ID' => $user['ID'],
                'NAME' => $user['NAME'],
                'LAST_NAME' => $user['LAST_NAME'],
                'COMPANY_ALL' => $user_deals->pluck('ID')
            ];
            //посчитать к-во компаний c открытой сделкой по каждому
            $deals_count = B24AnaliticsCompanyCold::join('companies', 'b24_analitics_company_colds.company_id', '=', 'companies.ID')
                ->join('b24_deals', 'companies.ID', '=', 'b24_deals.COMPANY_ID')
                ->where([
                    ['b24_analitics_company_colds.check_date', '=', $date],
                    ['b24_analitics_company_colds.since_date', '=', $date],
                    ['b24_deals.DATE_CREATE', '>=', $date],
                    ['companies.ASSIGNED_BY_ID', '=', $user['ID']],
                ])
                ->whereIn('b24_deals.STAGE_ID', $workStateArray)
                ->get()->unique('COMPANY_ID');
            $openDealCompany = $deals_count->pluck('COMPANY_ID');
            $deals_count = $deals_count->count();
            $result[$user['ID']]['deal_created'] = $deals_count;
            $result[$user['ID']]['OPEN_DEAL_COMPANY'] = $openDealCompany;

            //посчитать к-во компаний c закрытой сделкой по каждому
            //посчитать сумму продаж c закрытых сделкой по каждому
            $deals_count = B24AnaliticsCompanyCold::join('companies', 'b24_analitics_company_colds.company_id', '=', 'companies.ID')
                ->join('b24_users', 'companies.ASSIGNED_BY_ID', '=', 'b24_users.ID')
                ->join('b24_deals', 'companies.ID', '=', 'b24_deals.COMPANY_ID')
                ->where([
                    ['b24_analitics_company_colds.check_date', '=', $date],
                    ['b24_analitics_company_colds.since_date', '=', $date],
                    ['b24_deals.DATE_CREATE', '>=', $date],
                    ['companies.ASSIGNED_BY_ID', '=', $user['ID']],
                ])
                ->whereIn('b24_deals.STAGE_ID', $winStateArray)
                ->get()->unique('COMPANY_ID');
            // dd($deals_count);
            $sum = $deals_count->sum('OPPORTUNITY');
            $closeDeal = $deals_count->pluck('COMPANY_ID');
            $deals_count = $deals_count->count();
            $result[$user['ID']]['deals_staige_won'] = $deals_count;
            $result[$user['ID']]['deals_won_sum'] = $sum;
            $result[$user['ID']]['CLOSE_DEAL_COMPANY'] = $closeDeal;

            //посчитать к-во компаний c проваленной сделкой по каждому
            $deals_count     = B24AnaliticsCompanyCold::join('companies', 'b24_analitics_company_colds.company_id', '=', 'companies.ID')
                ->join('b24_users', 'companies.ASSIGNED_BY_ID', '=', 'b24_users.ID')
                ->join('b24_deals', 'companies.ID', '=', 'b24_deals.COMPANY_ID')
                ->where([
                    ['b24_analitics_company_colds.check_date', '=', $date],
                    ['b24_analitics_company_colds.since_date', '=', $date],
                    ['b24_deals.DATE_CREATE', '>=', $date],
                    ['companies.ASSIGNED_BY_ID', '=', $user['ID']],
                ])
                ->whereIn('b24_deals.STAGE_ID', $looseStateArray)
                ->get()->unique('COMPANY_ID');
            $looseDeal = $deals_count->pluck('COMPANY_ID');
            //проверка, была ли успешно закрытая сделка
            foreach ($looseDeal as $key => $currentDeal) {
                if (in_array($currentDeal, $closeDeal->toArray()))
                    unset($looseDeal[$key]);
            }

            $deals_count = $looseDeal->count();
            $result[$user['ID']]['deals_staige_loose'] = $deals_count;
            $result[$user['ID']]['LOOSE_DEAL_COMPANY'] = $looseDeal;

            //посчитать к-во компаний без движения по каждому
            $deals_count = B24AnaliticsCompanyCold::join('companies', 'b24_analitics_company_colds.company_id', '=', 'companies.ID')
                ->where([
                    ['b24_analitics_company_colds.check_date', '=', Carbon::today()],
                    ['b24_analitics_company_colds.since_date', '=', $date],
                    ['companies.ASSIGNED_BY_ID', '=', $user['ID']],
                ])
                ->get()->unique('ID');
            $coldDeal = $looseDeal = $deals_count->pluck('ID');
            $deals_count = $deals_count->count();
            $result[$user['ID']]['company_cold_count'] = $deals_count;
            $result[$user['ID']]['COLD_DEAL_COMPANY'] = $coldDeal;
        }

        //   B24Analitics::where('AIM', 7)->delete();
        try {
            $file = 'userfiles/' . $date . 'json'; //test
            $json = json_encode($result);
            file_put_contents($file, $json);
        } catch (Exception $e) {

            Log::error('An error occurred: ' . $e->getMessage());
        }



        // проверка
        // dd('1 - ',$result,' 2 - ',$arr2);
    }

    public function showColdCompanies($date)
    {
        $file = 'userfiles/' . $date . 'json';
        // чтение массива из файла
        $json = file_get_contents($file);
        $items = json_decode($json, true);
        return view('bitrix24.b24analitics.companies_date.showRaport', [
            'items' => $items,
            //   'id_node' => $id
        ]);
    }
    public function showColdCompaniesInfo($item)
    {
        $item = str_replace(['[', ']'], '', explode(',', $item));
        $companies = NULL;

        $companies = Company::wherein('ID', $item)->get();
        return view('bitrix24.company.index', [
            'companies' => $companies,
            //   'id_node' => $id
        ]);
    }
    public function show($date)
    {
        $data = B24AnaliticsCompanyCold::where('since_date', $date)->get();
        $items = array();
        $i = 0;
        foreach ($data as $currentData) {

            $company = Company::where('ID', $currentData['company_id'])->first();
            $items[$i]['companyName'] = $company->TITLE;
            $items[$i]['company_id'] = $currentData['company_id'];

            $items[$i]['user'] = B24User::find($company->ASSIGNED_BY_ID)->NAME . '' . B24User::find($company->ASSIGNED_BY_ID)->LAST_NAME;

            $items[$i]['ring'] = B24Ring::where('ID', $currentData['ring_id'])->first();
            if (!empty($items[$i]['ring'])) {
                $items[$i]['ring'] = $items[$i]['ring']->CALL_START_DATE;
            } else
                $items[$i]['ring'] = 0;

            $items[$i]['ringContact'] = B24Ring::where('ID', $currentData['ringContact_id'])->first();
            if (!empty($items[$i]['ringContact'])) {
                $items[$i]['ringContact'] = $items[$i]['ringContact']->CALL_START_DATE;
            } else
                $items[$i]['ringContact'] = 0;

            $items[$i]['taskCLose'] = B24Ring::where('ID', $currentData['task_id'])->first();
            if (!empty($items[$i]['taskCLose'])) {
                $items[$i]['taskCLose'] = $items[$i]['taskCLose']->CALL_START_DATE;
            } else
                $items[$i]['taskCLose'] = 0;

            $items[$i]['deadline'] = B24Ring::where('ID', $currentData['task_id'])->first();
            if (!empty($items[$i]['deadline'])) {
                $items[$i]['deadline'] = $items[$i]['deadline']->CALL_START_DATE;
            } else
                $items[$i]['taskCLose'] = 0;

            $i++;
        }
        return view('bitrix24.b24analitics.companies_date.show', [
            'items' => $items,
            //   'id_node' => $id
        ]);
    }


    //B24Analitics Aim=7
    private function saveToDB(array $array, $date)
    {
        foreach ($array as $key => $item) {
            if (is_array($item)) {
                foreach ($item as $subkey => $subItem) {
                    if ($subItem instanceof Collection) {
                        foreach ($subItem as $subsubkey => $subsubItem) {
                            $B24Analitics = B24Analitics::create([
                                'AIM' => 7,
                                'id_item' => $key,
                                'string1' => $subkey,
                                //'string2' => $subItem,
                                'string3' => $subsubItem,
                                'date1' => $date
                            ]);
                        }
                    } else {
                        $B24Analitics = B24Analitics::create([
                            'AIM' => 7,
                            'id_item' => $key,
                            'string1' => $subkey,
                            'string2' => $subItem,
                            'date1' => $date
                        ]);
                    }
                }
            } else {
                $B24Analitics = B24Analitics::create([
                    'AIM' => 7,
                    'string1' => $key,
                    'string2' => $item,
                    'date1' => $date
                ]);
            }
        }
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
    public function destroy($since_date)
    {
        $file = 'userfiles/' . $since_date . 'json'; 
        if (file_exists($file)) {
            unlink($file);
        }

        $items = B24AnaliticsCompanyCold::where('since_date', $since_date)->delete();


        return $this->index();
    }



    //fill array of stattes of each company (and upload to current DB) which dont have tasks, rings, deals after the date
    public function companiesDate(Request $request, $since_date = null)
    {
        if (empty($request->since_date)) //выходим если не заполнена дата since_date - дата, с которой начинается проверка компаний без движений

            return;

        if (!empty($since_date)) {
            $items = B24AnaliticsCompanyCold::whereColumn('since_date', '!=', 'check_date')->delete();
            $check_date = Carbon::today();
            $companies = B24AnaliticsCompanyCold::where('since_date', $since_date)
                ->join('companies', 'b24_analitics_company_colds.company_id', '=', 'companies.ID')
                ->get();

            //  $items = $items
        } else {
            $since_date = $request->since_date;
            $check_date = $since_date;
            $companies = Company::where('COMPANY_TYPE', 'CUSTOMER')->get();
        }

        $DatesArray = [];
        foreach ($companies as $companie) {
            $dateLastRings = null;
            $dateLastContactsRings = null;
            $dateLastTasksDeadline = null;
            $dateLastTasksClosed = null;
            $dateLastDealsCreated = null;
            $dateLastDealsClosed = null;
            $dateLastLeadsCreated = null;
            $Company_id = $companie->ID;
            $Ring_id = 0;
            $ContactsRings_id = 0;
            $Task_id = 0;
            $Deal_id = 0;
            //        $dateLastDealsCreated=null;
            //        $dateLastDealsClosed=null;

            /////1 rings
            $rings = B24Ring::where('CRM_COMPANY_ID', $companie->ID)->get();
            foreach ($rings as $ring) {
                if ($ring->CALL_START_DATE > $dateLastRings) {
                    $dateLastRings = $ring->CALL_START_DATE;
                    $Ring_id = $ring->ID;
                }
            }
            ////2 contacts rings
            $contacts = B24Contact::where('COMPANY_ID', $companie->ID)->get();
            foreach ($contacts as $contact) {
                $rings = B24Ring::where('CRM_CONTACT_ID', $contact->ID)->get();
                foreach ($rings as $ring) {
                    if ($ring->CALL_START_DATE > $dateLastContactsRings) {
                        $dateLastContactsRings = $ring->CALL_START_DATE;
                        $ContactsRings_id = $ring->ID;
                    }
                }
            }
            ////3 tasks
            $tasks = B24Task::where('UF_CRM_TASK_COMPANY', $companie->ID)->get();
            foreach ($tasks as $task) {
                if ($task->closedDate > $dateLastTasksClosed) {
                    $dateLastTasksClosed = $task->closedDate;
                    $Task_id = $task->id;
                }

                if ($task->deadline > $dateLastTasksDeadline) {
                    $dateLastTasksDeadline = $task->deadline;
                    $Task_id = $task->id;
                }
            }
            ////4 deals
            $deals = B24Deal::where('COMPANY_ID', $companie->ID)->get();
            foreach ($deals as $deal) {
                if ($deal->DATE_CREATE > $dateLastDealsCreated) {
                    $dateLastDealsCreated = $deal->DATE_CREATE;
                    $Deal_id = $deal->ID;
                }
                if ($deal->CLOSEDATE > $dateLastDealsClosed) {
                    $dateLastDealsClosed = $deal->CLOSEDATE;
                    $Deal_id = $deal->ID;
                }
            }
            //5 leads
            $leads = B24Lead::where('COMPANY_ID', $companie->ID)->get();
            foreach ($leads as $lead) {
                $rings = B24Ring::where('CRM_LEAD_ID', $lead->ID)->get();
                foreach ($rings as $ring) {
                    if ($ring->CALL_START_DATE > $dateLastLeadsCreated) {
                        $dateLastLeadsCreated = $ring->CALL_START_DATE;
                        $LeadRings_id = $ring->ID;
                    }
                }
            }


            if ($dateLastRings || $dateLastContactsRings || $dateLastTasksDeadline || $dateLastTasksClosed)
                if (
                    $dateLastRings < $since_date && $dateLastContactsRings < $since_date && $dateLastTasksDeadline < $since_date
                    &&  $dateLastTasksClosed < $since_date &&
                    $dateLastDealsCreated < $since_date && $dateLastDealsClosed < $since_date &&
                    $dateLastLeadsCreated < $since_date
                ) {

                    $DatesArray = [

                        'company_id' => $Company_id,
                        'ring_id' => $Ring_id,
                        'task_id' => $Task_id,
                        'ringContact_id' => $ContactsRings_id,
                        'deal_id' => $Deal_id,
                        //   'lead_id' => $LeadRings_id,
                        'check_date' => $check_date,
                        'since_date' => $since_date,


                        //              'dateLastDealsCreated'=> null,
                        //              'dateLastDealsClosed'=> null,
                    ];
                    $B24AnaliticsItem = B24AnaliticsCompanyCold::where('company_id', $Company_id)->where('check_date', $check_date)->first();
                    if (empty($B24AnaliticsItem)) {
                        $res = B24AnaliticsCompanyCold::create($DatesArray);
                        if (!$res) {
                            Log::error('companies_date() error create B24Analitics companie->ID ' . $Company_id);
                        } else {
                            // Log::info(" B24Analitics is trying to create second item for current company! ID: " . $Company_id);
                        }
                        //throw new Exception("ERROR! B24Analitics is trying to create second item for current company!");
                    }
                }
        }
        /*  dd($DatesArray);

        return view('bitrix24.b24analitics.b24companies_date', [
            'items' => $DatesArray
        ]);*/
    }

    public function companiesDateShow()
    {
        $items = B24AnaliticsCompanyCold::where('since_date', '')->get();

        return view('bitrix24.b24analitics.b24companies_date', [
            'items' => $items,
            //   'id_node' => $id
        ]);
    }
}
