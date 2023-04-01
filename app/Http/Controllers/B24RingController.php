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
        $count = 0;
        $b24countItems = $this->helperOriginAPI->getQuantity('ring');
        $b24count = B24Analitics::where('AIM', 1)->first();
        if (!empty($b24count))
            if (!empty($b24count->big_int1)) {
            } else {
                $b24count->big_int1 = 0;
                $b24count->string1 = 'rings total fetch quantity';
                $b24count->save();
            }
        else {
            $b24count = B24Analitics::create(['AIM' => 1, 'big_int1' => 0]);
        }
        $items = $this->helper->getRings($b24count->big_int1);

        while (count($items)&&$b24countItems> $b24count->big_int1) {

            foreach ($items as $item) {
                //      dd($item);
                $item = get_object_vars($item);
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
                $count++;
            }
            $b24count->big_int1 = B24Ring::count();; //save result in DB
            $b24count->save();
            $count = 0;

            $items = $this->helper->getRings($b24count->big_int1);
            $b24countItems = $this->helperOriginAPI->getQuantity('ring');
        }
        //dd($items);

        return redirect()->back();
    }
}
