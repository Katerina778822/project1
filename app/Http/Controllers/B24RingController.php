<?php

namespace App\Http\Controllers;

use App\Jobs\b24RingFetch;
use App\Models\B24Analitics;
use App\Models\B24Ring;
use DateTime;
use Exception;
use Illuminate\Http\Request;

class B24RingController extends AbstractB24Controller
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
        $modelItem = B24Ring::where('ID', $item['ID'])->get();
        if (count($modelItem)) {
            return;
        }
        $modelItem = B24Ring::create($item);

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

    public function fetchAll()
    {
        $job = new b24RingFetch();
        $this->dispatch($job);
    }

   

    public function fetchData()
    {
      //  $count = 0;
      $checkDate='2022-01-01T00:00:00+03:00';
        $b24countItems=$this->helperOriginAPI->getQuantity('ring',$checkDate);
        //$b24count = B24Analitics::where('AIM', 2)->first();
        $b24count = B24Ring::count();

        $requestArray['DATE']=$checkDate;
        $requestArray['select'] = ['ID', 'DESCRIPTION', 'RESPONSIBLE_ID', 'TIME_ESTIMATE', 'TITLE', 'DEADLINE', 'DATE_START', 'STATUS', 'CREATED_DATE', 'guid', 'CREATEDDATE', 'CHANGED_DATE', 'CLOSED_DATE', 'UF_CRM_TASK'];
        $requestArray['start'] = $b24count;

  //      $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
        $items = $this->helperOriginAPI->getItem('ring',$requestArray);
        //dd($items);
        while (count($items)&&$b24countItems> $b24count) {
            foreach ($items as $item) {
                //      dd($item);
              //  $item = get_object_vars($item);
                $item['CALL_START_DATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['CALL_START_DATE']);
                switch ($item['CRM_ENTITY_TYPE']) {
                    case 'CONTACT': {
                            $item['CRM_LEAD_ID'] = $item['CRM_ENTITY_ID'];
                            break;
                        }
                    case 'COMPANY': {
                            $item['CRM_COMPANY_ID'] = $item['CRM_ENTITY_ID'];
                            break;
                        }
                    case 'LEAD': {
                            $item['CRM_LEAD_ID'] = $item['CRM_ENTITY_ID'];
                            break;
                        }
                    default:
                        break;
                }

                if ($item['PORTAL_USER_ID'] == 0)
                    $item['PORTAL_USER_ID'] = 1;
                $this->store($item);
            }
            $b24count =B24Ring::count(); //save result count
            //$b24count->save();
           // $count = 0;
           $requestArray['start'] = $b24count;
            $items = $this->helperOriginAPI->getItem('ring',$requestArray);
           // $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
            $b24countItems=$this->helperOriginAPI->getQuantity('ring',$checkDate);
        }

        return redirect()->back();
    }
}
