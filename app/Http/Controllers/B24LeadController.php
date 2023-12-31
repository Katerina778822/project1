<?php

namespace App\Http\Controllers;

use App\Jobs\b24LeadFetch;
use App\Models\B24Analitics;
use App\Models\B24Deal;
use App\Models\B24Lead;
use App\Models\B24User;
use App\Models\Company;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\returnSelf;

class B24LeadController extends AbstractB24Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(array $item)
    {
        $modelItem = null;
        $modelItem = B24Lead::where('ID', $item['ID'])->get();
        if (count($modelItem)) {
            return;
        }
        $modelItem = B24Lead::create($item);

        try {
        } catch (Exception $e) {
            $e->getMessage();
        } finally {
            return;
        }
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
    public function update(array $item)
    {
        $lead = B24Lead::find($item['ID']);
        try {
            if (!empty($lead)) {
                $lead->update($item);
            } else
                $this->store($item);
        } catch (Exception $e) {
            Log::error('Couldnt create/update Lead: ID ' . $item['ID'] . '\ ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function fetchAll()
    {
        $job = new b24LeadFetch();
        $this->dispatch($job);
    }


    public function fetchData()
    {

        //  $count = 0;
        $checkDate = null; //'2016-01-01T00:00:00+03:00';
        $b24countItems = $this->helperOriginAPI->getQuantity('lead', $checkDate);
        //$b24count = B24Analitics::where('AIM', 2)->first();
        $b24count = B24Lead::count();



        //$requestArray['filter'][ '>CREATED_DATE']=$checkDate;
        $requestArray['DATE'] = $checkDate;
        $requestArray['select'] = [
            'ID', 'TITLE', 'NAME', 'LAST_NAME', 'SOURCE_ID', 'STATUS_ID', 'COMMENTS', 'ADDRESS', 'UTM_SOURCE',
            'UTM_MEDIUM', 'UTM_CAMPAIGN', 'UTM_CONTENT', 'UTM_TERM', 'CURRENCY_ID', 'PHONE', 'OPPORTUNITY', 'COMPANY_ID',
            'CONTACT_ID', 'ASSIGNED_BY_ID', 'CREATED_BY_ID', 'DATE_CREATE', 'DATE_CLOSED', 'DATE_MODIFY',
        ];
        $requestArray['start'] = $b24count;

        //      $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
        $items = $this->helperOriginAPI->getItem('lead', $requestArray);
        //dd($items);
        while (count($items) && $b24countItems > $b24count) {
            foreach ($items as $item) {
                if (!empty($item['DATE_CREATE']))
                    $item['DATE_CREATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_CREATE'])->format('Y-m-d H:i:s');
                else $item['DATE_CREATE'] = NULL;
                if (!empty($item['DATE_MODIFY']))
                    $item['DATE_MODIFY'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_MODIFY'])->format('Y-m-d H:i:s');
                else $item['DATE_MODIFY'] = NULL;
                if (!empty($item['DATE_CLOSED']))
                    $item['DATE_CLOSED'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_CLOSED'])->format('Y-m-d H:i:s');
                else $item['DATE_CLOSED'] = NULL;

                if (
                    empty($item['CREATED_BY_ID']) || $item['CREATED_BY_ID'] == 1059 || $item['CREATED_BY_ID'] == 1061 || //deleted users
                    $item['CREATED_BY_ID'] == 1063 ||
                    $item['CREATED_BY_ID'] == 1067
                )
                    $item['CREATED_BY_ID'] = 1;
                if (!empty($item['PHONE'][0]['VALUE']) || !empty($item['PHONE']))
                    $item['PHONE'] = $item['PHONE'][0]['VALUE'];
                $this->store($item);
            }
            $b24count = B24Lead::count(); //save result count
            //$b24count->save();
            // $count = 0;
            $requestArray['start'] = $b24count;
            $items = $this->helperOriginAPI->getItem('lead', $requestArray);
            // $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
            $b24countItems = $this->helperOriginAPI->getQuantity('lead', $checkDate);
        }

        return redirect()->back();
    }

    public function updateData($checkDate)
    {

        //  $count = 0;
        // $checkDate = null;//'2016-01-01T00:00:00+03:00';
        $b24countItems = $this->helperOriginAPI->getQuantityUpdate('lead', $checkDate);
        //$b24count = B24Analitics::where('AIM', 2)->first();
        $count = 0; //B24Lead::where('DATE_MODIFY', '>=', $checkDate)->get()->count();
        //$requestArray['filter'][ '>CREATED_DATE']=$checkDate;

        $requestArray['DATE'] = $checkDate;
        $requestArray['select'] = [
            'ID', 'TITLE', 'NAME', 'LAST_NAME', 'SOURCE_ID', 'STATUS_ID', 'COMMENTS', 'ADDRESS', 'UTM_SOURCE',
            'UTM_MEDIUM', 'UTM_CAMPAIGN', 'UTM_CONTENT', 'UTM_TERM', 'CURRENCY_ID', 'PHONE', 'OPPORTUNITY', 'COMPANY_ID',
            'CONTACT_ID', 'ASSIGNED_BY_ID', 'CREATED_BY_ID', 'DATE_CREATE', 'DATE_CLOSED', 'DATE_MODIFY',
        ];
        $requestArray['start'] = $count;

        //      $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
        $items = $this->helperOriginAPI->getItemUpdate('lead', $requestArray);
        //dd($items);

        while (count($items) && $b24countItems > $count) {
            foreach ($items as $item) {
                if (!empty($item['DATE_CREATE']))
                    $item['DATE_CREATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_CREATE'])->format('Y-m-d H:i:s');
                else $item['DATE_CREATE'] = NULL;
                if (!empty($item['DATE_MODIFY']))
                    $item['DATE_MODIFY'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_MODIFY'])->format('Y-m-d H:i:s');
                else $item['DATE_MODIFY'] = NULL;
                if (!empty($item['DATE_CLOSED']))
                    $item['DATE_CLOSED'] = Carbon::createFromFormat('Y-m-d\TH:i:sP', $item['DATE_CLOSED'])->format('Y-m-d H:i:s'); //DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_CLOSED']);
                //Carbon::createFromFormat('Y-m-d\TH:i:sP', '2023-04-03T01:38:42+03:00')->format('Y-m-d H:i:s');
                else $item['DATE_CLOSED'] = NULL;

                if (
                    empty($item['CREATED_BY_ID']) || $item['CREATED_BY_ID'] == 1059 || $item['CREATED_BY_ID'] == 1061 || //deleted users
                    $item['CREATED_BY_ID'] == 1063 ||
                    $item['CREATED_BY_ID'] == 1067
                )
                    $item['CREATED_BY_ID'] = 1;
                if (!empty($item['PHONE'][0]['VALUE']) || !empty($item['PHONE']))
                    $item['PHONE'] = $item['PHONE'][0]['VALUE'];
                $this->update($item);
                $count++; //save result count
            }

            //$b24count->save();
            // $count = 0;
            $requestArray['start'] = $count;
            $items = $this->helperOriginAPI->getItemUpdate('lead', $requestArray);
            // $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
            $b24countItems = $this->helperOriginAPI->getQuantityUpdate('lead', $checkDate);
        }
    }

    public function newLeadAnalise(Request $request)
    {
        $dateStart = null;
        $dateEnd = null;
        $timezone = new DateTimeZone('Europe/Kiev');
        if (empty($request->dateStart)) {
            $dateStart = new DateTime('now', $timezone);
            // $dateStart->modify("-1 day");
        } else {
            $dateStart =  new DateTime($request->dateStart, $timezone);
        }

        if (empty($request->dateEnd)) {

            $dateEnd = new DateTime('now', $timezone);
        } else {
            $dateEnd =  new DateTime($request->dateEnd, $timezone);
            $dateEnd->setTime(23, 59, 59);
        }
        $dateStart->setTime(0, 0, 0);
        // получение лидов за период
        $leads = B24Lead::where([
            ['b24_leads.DATE_CREATE', '>', $dateStart->format('Y-m-d H:i:s')],
            ['b24_leads.DATE_CREATE', '<', $dateEnd->format('Y-m-d H:i:s')],
        ])->get();
        foreach ($leads as $lead) {
            $lead->USER_NAME = B24User::find($lead->ASSIGNED_BY_ID)->NAME;
            //поиск компании, сделок и суммы всех продаж данного лида
            if (!empty($lead->COMPANY_ID)) {
                $company = Company::find($lead->COMPANY_ID);
                $deals = B24Deal::where([
                    ['COMPANY_ID', $company->ID],
                    ['CLOSED', 'y'],
                ])->get();
                if (!empty($deals)) {
                    $deals_count = 0;
                    $deals_summ = 0;
                    foreach ($deals as $deal) {
                        $deals_count++;
                        $deals_summ += $deal->OPPORTUNITY;
                    }
                    $lead->DEALS_COUNT = $deals_count;
                    $lead->DEALS_SUMM = $deals_summ;
                }
            }
        }



        return view('bitrix24.b24lead.index', [
            'items' => $leads,

        ]);
    }
}
