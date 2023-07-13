<?php

namespace App\Http\Controllers;

use App\Models\B24Analitics;
use App\Models\B24Contact;
use App\Models\B24Deal;
use App\Models\B24Ring;
use App\Models\B24Task;
use App\Models\B24User;
use App\Models\Company;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;

class B24AnaliticsController extends Controller
{
    public function companiesDate(Request $request)
    { //returns array of companies which dont have tasks, rings, deals after the date

        if (empty($request->date))
            return;
        B24Analitics::query()->delete();
        $today = Carbon::today();
        $todayStart = Carbon::today()->startOfDay();
        $todayEnd = Carbon::today()->endOfDay();
        $b24currentDate = B24Analitics::whereBetween('created_at', [$todayStart, $todayEnd])->get();
        if ($b24currentDate->count())
            return;
        $companies = Company::where('COMPANY_TYPE', 'CUSTOMER')->get();
        $DatesArray = [];
        foreach ($companies as $companie) {
            $dateLastRings = null;
            $dateLastContactsRings = null;
            $dateLastTasksDeadline = null;
            $dateLastTasksClosed = null;
            //        $dateLastDealsCreated=null;
            //        $dateLastDealsClosed=null;

            /////1 rings
            $rings = B24Ring::where('CRM_COMPANY_ID', $companie->ID)->get();
            foreach ($rings as $ring) {
                if ($ring->CALL_START_DATE > $dateLastRings)
                    $dateLastRings = $ring->CALL_START_DATE;
            }
            ////2 contacts rings
            $contacts = B24Contact::where('COMPANY_ID', $companie->ID)->get();
            foreach ($contacts as $contact) {
                $rings = B24Ring::where('CRM_CONTACT_ID', $contact->ID)->get();
                foreach ($rings as $ring) {
                    if ($ring->CALL_START_DATE > $dateLastContactsRings)
                        $dateLastContactsRings = $ring->CALL_START_DATE;
                }
            }
            ////3 tasks
            $tasks = B24Task::where('UF_CRM_TASK_COMPANY', $companie->ID)->get();
            foreach ($tasks as $task) {
                if ($task->closedDate > $dateLastTasksClosed)
                    $dateLastTasksClosed = $task->closedDate;
                if ($task->deadline > $dateLastTasksDeadline)
                    $dateLastTasksDeadline = $task->deadline;
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

                        'AIM' => 3,
                        'id_item' => $companie->ID,
                        'string3' => B24User::find($companie->ASSIGNED_BY_ID)->NAME . '' . B24User::find($companie->ASSIGNED_BY_ID)->LAST_NAME,
                        'date1' => $dateLastRings,
                        'date2' => $dateLastContactsRings,
                        'date3' => $dateLastTasksDeadline,
                        'date4' => $dateLastTasksClosed,
                        'string1' => $companie->TITLE,
                        'string2' => 'www. - url'

                        //              'dateLastDealsCreated'=> null,
                        //              'dateLastDealsClosed'=> null,
                    ];


                    $B24AnaliticsItem = B24Analitics::where('id_item', $companie->ID)->first(); //check if item exist
                    if ($B24AnaliticsItem == 0) {
                        $res = B24Analitics::create($DatesArray);
                        if (!$res)
                            log('companies_date() error create B24Analitics companie->ID ' . $companie->ID);
                    } else {
                        log("ERROR! B24Analitics is trying to create second item for current company! ID: " . $companie->ID);
                        throw new Exception("ERROR! B24Analitics is trying to create second item for current company!");
                    }
                    $dateLastRings = null;
                    $dateLastContactsRings = null;
                    $dateLastTasksDeadline = null;
                    $dateLastTasksClosed = null;
                }
        }
        /*  dd($DatesArray);

        return view('bitrix24.b24analitics.b24companies_date', [
            'items' => $DatesArray
        ]);*/
    }



    public function companiesDateShow()
    {
        $items = B24Analitics::where('AIM', '3')->get();

        return view('bitrix24.b24analitics.companies_date.b24companies_date', [
            'items' => $items,
            //   'id_node' => $id
        ]);
    }


    public function destroy($id)
    {
        $item = B24Analitics::find($id);
        $item->delete();
    }



    public function destroyAim($id_AIm) //delete all goods  of $id_catalog
    {
        $items = B24Analitics::where('AIM', $id_AIm)->get();
        foreach ($items as $item) {
            $item->delete();
        }
    }
    public function destroyAll($id_AIm) //delete all goods  of $id_catalog
    {
        $items = B24Analitics::all();
        foreach ($items as $item) {
            $item->delete();
        }
    }
   

}
