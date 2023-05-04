<?php

namespace App\Http\Controllers;

use App\Jobs\B24ActivityFetch;
use App\Models\B24Activity;
use App\Models\B24Agenda;
use App\Models\B24Deal;
use DateTime;
use Exception;
use Illuminate\Http\Request;

class B24ActivityController extends AbstractB24Controller
{

    public function fetchAll()
    {
        $job = new B24ActivityFetch();
        $this->dispatch($job);
    }

    public function fetchData()
    {

        //  $count = 0;
        $checkDate = null; //'2023-03-01T00:00:00+03:00';
        //$b24count = B24Analitics::where('AIM', 2)->first();
        $b24count = B24Activity::count();

        //$requestArray['filter'][ '>CREATED_DATE']=$checkDate;
        $requestArray['DATE'] = $checkDate;
        $requestArray['filter'] = [
            'PROVIDER_ID' => ['IMOPENLINES_SESSION','CRM_TODO']
        ];
        // $requestArray['select'] = [ "*", "COMMUNICATIONS" ];
        $requestArray['select'] =  [
            'ID', 'OWNER_ID', 'OWNER_TYPE_ID', 'ASSOCIATED_EN', 'AUTHOR_ID', 'EDITOR_ID', 'PROVIDER_ID',
            'PROVIDER_TYPE_ID', 'SUBJECT', 'ASSIGNED_BY_ID', 'COMPANY_ID', 'CREATED', 'LAST_UPDATED',
            'START_TIME', 'END_TIME', 'DEADLINE',
        ];
        $b24countItems = $this->helperOriginAPI->getQuantity('activity', $checkDate,null, $requestArray);
        
        $requestArray['start'] = $b24count;

        //      $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
        $items = $this->helperOriginAPI->getItem('activity', $requestArray);
        //dd($items);
        while (count($items) && $b24countItems > $b24count) {
            foreach ($items as $item) {
                //      dd($item);
                //               $item = get_object_vars($item);
                $item['CREATED'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['CREATED'])->format('Y-m-d H:i:s');
                if (!empty($item['LAST_UPDATED']))
                    $item['LAST_UPDATED'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['LAST_UPDATED'])->format('Y-m-d H:i:s');
                else $item['LAST_UPDATED'] = NULL;
                if (!empty($item['START_TIME']))
                    $item['START_TIME'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['START_TIME'])->format('Y-m-d H:i:s');
                else $item['START_TIME'] = NULL;
                if (!empty($item['END_TIME']))
                    $item['END_TIME'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['END_TIME'])->format('Y-m-d H:i:s');
                else $item['END_TIME'] = NULL;
                if (!empty($item['DEADLINE']))
                    $item['DEADLINE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DEADLINE'])->format('Y-m-d H:i:s');
                else $item['DEADLINE'] = NULL;

                switch ($item['OWNER_TYPE_ID']) {
                    case '1': {
                        $item['LEAD_ID'] = $item['OWNER_ID'];
                        break;
                        }
                    case '2': {
                        $item['DEAL_ID'] = $item['OWNER_ID'];
                        break;
                        }
                    case '3': {
                        $item['CONTACT_ID'] = $item['OWNER_ID'];
                        break;
                        }
                    case '4': {
                        $item['COMPANY_ID'] = $item['OWNER_ID'];
                        break;
                        }
                }

                $this->store($item);
            }
            $b24count = B24Activity::count(); //save result count
            //$b24count->save();
            // $count = 0;
            $requestArray['start'] = $b24count;
            $items = $this->helperOriginAPI->getItem('activity', $requestArray);
            // $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
            $b24countItems = $this->helperOriginAPI->getQuantity('activity', $checkDate,null,$requestArray);
        }

        return redirect()->back();
    }

    public function updateData($checkDate)
    {
        $items = $this->helperOriginAPI->getItemUpdateTemp();
        $count=0;
        $requestArray['DATE'] = $checkDate;
      //  $requestArray['DATE'] = $requestArray['DATE']->format('Y-01-01\TH:i:sP');
        $requestArray['filter'] = [
            'PROVIDER_ID' => ['IMOPENLINES_SESSION','CRM_TODO']
        ];
        // $requestArray['select'] = [ "*", "COMMUNICATIONS" ];
  /*      $requestArray['select'] =  [
            'ID', 'OWNER_ID', 'OWNER_TYPE_ID', 'ASSOCIATED_ENTITY_ID', 'AUTHOR_ID', 'EDITOR_ID', 'PROVIDER_ID',
            'PROVIDER_TYPE_ID', 'SUBJECT', 'ASSIGNED_BY_ID', 'COMPANY_ID', 'CREATED', 'LAST_UPDATED',
            'START_TIME', 'END_TIME', 'DEADLINE',
        ]; */
        $b24countItems = $this->helperOriginAPI->getQuantityUpdate('activity', $checkDate,null, $requestArray);
        
        $items = $this->helperOriginAPI->getItemUpdate('activity', $requestArray);
        dd($items);
        while (count($items) && $b24countItems > $count) {
            foreach ($items as $item) {
                //      dd($item);
                //               $item = get_object_vars($item);
                $item['CREATED'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['CREATED'])->format('Y-m-d H:i:s');
                if (!empty($item['LAST_UPDATED']))
                    $item['LAST_UPDATED'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['LAST_UPDATED'])->format('Y-m-d H:i:s');
                else $item['LAST_UPDATED'] = NULL;
                if (!empty($item['START_TIME']))
                    $item['START_TIME'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['START_TIME'])->format('Y-m-d H:i:s');
                else $item['START_TIME'] = NULL;
                if (!empty($item['END_TIME']))
                    $item['END_TIME'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['END_TIME'])->format('Y-m-d H:i:s');
                else $item['END_TIME'] = NULL;
                if (!empty($item['DEADLINE']))
                    $item['DEADLINE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DEADLINE'])->format('Y-m-d H:i:s');
                else $item['DEADLINE'] = NULL;

                switch ($item['OWNER_TYPE_ID']) {
                    case '1': {
                        $item['LEAD_ID'] = $item['OWNER_ID'];
                        break;
                        }
                    case '2': {
                        $item['DEAL_ID'] = $item['OWNER_ID'];
                        break;
                        }
                    case '3': {
                        $item['CONTACT_ID'] = $item['OWNER_ID'];
                        break;
                        }
                    case '4': {
                        $item['COMPANY_ID'] = $item['OWNER_ID'];
                        break;
                        }
                }

                $this->store($item);
            }
            $b24count = B24Activity::count(); //save result count
            //$b24count->save();
            // $count = 0;
            $requestArray['start'] = $b24count;
            $items = $this->helperOriginAPI->getItem('activity', $requestArray);
            // $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
            $b24countItems = $this->helperOriginAPI->getQuantity('activity', $checkDate,null,$requestArray);
        }

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fetchData();
        //    $requestArray['DATE']=null;
        //    $requestArray['select'] = ['ID', 'DESCRIPTION', 'RESPONSIBLE_ID', 'TIME_ESTIMATE', 'TITLE', 'DEADLINE', 'DATE_START', 'STATUS', 'CREATED_DATE', 'guid', 'CREATEDDATE', 'CHANGED_DATE', 'CLOSED_DATE', 'UF_CRM_TASK'];
        //  $requestArray['start'] = 19300;

        //      $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
        //      $items = $this->helperOriginAPI->getItem('activity',$requestArray);
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
        $modelItem = B24Activity::where('ID', $item['ID'])->get();
        if (count($modelItem)) {
            return;
        }
        $modelItem = B24Activity::create($item);

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
        //
    }
}
