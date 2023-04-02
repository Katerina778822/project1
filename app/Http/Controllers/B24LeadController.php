<?php

namespace App\Http\Controllers;

use App\Jobs\b24LeadFetch;
use App\Models\B24Analitics;
use App\Models\B24Lead;
use DateTime;
use Exception;
use Illuminate\Http\Request;

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
    }

    public function fetchAll()
    {
        $job = new b24LeadFetch();
        $this->dispatch($job);
    }


    public function fetchData()
    {

        //  $count = 0;
        $checkDate = null;//'2016-01-01T00:00:00+03:00';
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
                    $item['DATE_CREATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_CREATE']);
                else $item['DATE_CREATE'] = NULL;
                if (!empty($item['DATE_MODIFY']))
                    $item['DATE_MODIFY'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_MODIFY']);
                else $item['DATE_MODIFY'] = NULL;
                if (!empty($item['DATE_CLOSED']))
                    $item['DATE_CLOSED'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_CLOSED']);
                    else $item['DATE_CLOSED'] = NULL;

                if (empty($item['CREATED_BY_ID'])||$item['CREATED_BY_ID']==1059||$item['CREATED_BY_ID']==1061||//deleted users
                $item['CREATED_BY_ID']==1063||
                $item['CREATED_BY_ID']==1067)
                    $item['CREATED_BY_ID'] = 1;
                if (!empty($item['PHONE'][0]['VALUE'])||!empty($item['PHONE']))
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
}
