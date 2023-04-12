<?php

namespace App\Http\Controllers;

use App\Models\B24AnaliticsCompanyCold;
use App\Models\B24Contact;
use App\Models\B24Ring;
use App\Models\B24Task;
use App\Models\B24User;
use App\Models\Company;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
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
        $dates = array();
        $counts = array();
        $items = B24AnaliticsCompanyCold::all();
        foreach ($items as $item) { //Список выгрузок
            if (!in_array($item->date, $dates)) {
                $counts[$item->date] = 0;
                $dates[] = $item->date;
            }
            $counts[$item->date]++;
        }

        return view('bitrix24.b24analitics.companies_date.index', [
            'items' => $dates,
            'counts' => $counts,
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
    public function show($date)
    {
        $data = B24AnaliticsCompanyCold::where('date', $date)->get();
        $items = array();
        $i = 0;
        foreach ($data as $currentData) {

            $company=Company::where('ID', $currentData['company_id'])->first();
            $items[$i]['companyName'] = $company->TITLE;
            $items[$i]['company_id'] = $currentData['company_id'];

            $items[$i]['user']=B24User::find($company->ASSIGNED_BY_ID)->NAME . '' . B24User::find($company->ASSIGNED_BY_ID)->LAST_NAME;

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

    public function companiesDate(Request $request)
    { //returns array of companies which dont have tasks, rings, deals after the date

        if (empty($request->date))
            return;
        //       B24Analitics::query()->delete();
        $today = Carbon::today();
        $todayStart = Carbon::today()->startOfDay();
        $todayEnd = Carbon::today()->endOfDay();
        /*  $b24currentDate = B24Analitics::whereBetween('created_at', [$todayStart, $todayEnd])->get();
        if ($b24currentDate->count())
            return;*/
        $companies = Company::where('COMPANY_TYPE', 'CUSTOMER')->get();
        $DatesArray = [];
        foreach ($companies as $companie) {
            $dateLastRings = null;
            $dateLastContactsRings = null;
            $dateLastTasksDeadline = null;
            $dateLastTasksClosed = null;
            $Company_id = $companie->ID;
            $Ring_id = 0;
            $ContactsRings_id = 0;
            $Task_id = 0;
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
            /*        $deals = B24Deal::where('COMPANY_ID', $companie->ID)->get();
            foreach ($deals as $deal) {
                if ($deal->DATE_CREATE > $dateLastDealsCreated)
                    $dateLastDealsCreated = $deal->DATE_CREATE;
                if ($deal->CLOSEDATE > $dateLastDealsClosed)
                    $dateLastDealsClosed = $deal->CLOSEDATE;
            }*/
            if ($dateLastRings || $dateLastContactsRings || $dateLastTasksDeadline || $dateLastTasksClosed)
                if (
                    $dateLastRings < $request->date && $dateLastContactsRings < $request->date && $dateLastTasksDeadline < $request->date
                    &&  $dateLastTasksClosed < $request->date
                ) {

                    $DatesArray = [

                        'company_id' => $Company_id,
                        'ring_id' => $Ring_id,
                        'task_id' => $Task_id,
                        'ringContact_id' => $ContactsRings_id,
                        //   'deal_id' => $dateLastRings,
                        'date' => $today,


                        //              'dateLastDealsCreated'=> null,
                        //              'dateLastDealsClosed'=> null,
                    ];


                    $B24AnaliticsItem = B24AnaliticsCompanyCold::where('company_id', $Company_id)->first();
                    if (empty($B24AnaliticsItem)) {
                        $res = B24AnaliticsCompanyCold::create($DatesArray);
                        if (!$res)
                            Log::error('companies_date() error create B24Analitics companie->ID ' . $Company_id);
                    } else {
                        Log::info(" B24Analitics is trying to create second item for current company! ID: " . $Company_id);
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
        $items = B24AnaliticsCompanyCold::where('date', '')->get();

        return view('bitrix24.b24analitics.b24companies_date', [
            'items' => $items,
            //   'id_node' => $id
        ]);
    }
}
