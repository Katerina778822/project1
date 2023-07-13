<?php

namespace App\Http\Controllers;

use App\Jobs\b24ContactFetch;
use App\Models\B24Contact;
use DateTime;
use Exception;
use Illuminate\Http\Request;

class B24ContactController extends AbstractB24Controller
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
        $modelItem = B24Contact::where('ID', $item['ID'])->first();
        if (empty($modelItem)) {
            $modelItem = B24Contact::create($item);
        }
        else{
            $modelItem->update($item);
            $modelItem->save();
        }


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
        $job = new b24ContactFetch();
        $this->dispatch($job);
    }

    public function fetchData()
    {
        //  $count = 0;
        $checkDate = null; //'2016-01-01T00:00:00+03:00';
        $b24countItems = $this->helperOriginAPI->getQuantity('contact', $checkDate);
        //$b24count = B24Analitics::where('AIM', 2)->first();
        $b24count = B24Contact::count();



        $requestArray['DATE'] = $checkDate;
        $requestArray['select'] = ['ID', 'LAST_NAME', 'NAME', 'ASSIGNED_BY_ID', 'COMPANY_ID', 'DATE_CREATE'];
        $requestArray['start'] = $b24count;

        //      $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
        $items = $this->helperOriginAPI->getItem('contact', $requestArray);
        //dd($items);
        while (count($items) && $b24countItems > $b24count) {
            foreach ($items as $item) {

                if (!empty($item['DATE_CREATE']))
                    $item['DATE_CREATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_CREATE'])->format('Y-m-d H:i:s');
                else $item['DATE_CREATE'] = NULL;



                $this->store($item);
            }
            $b24count = B24Contact::count(); //save result count
            //$b24count->save();
            // $count = 0;
            $requestArray['start'] = $b24count;
            $items = $this->helperOriginAPI->getItem('contact', $requestArray);
            // $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
            $b24countItems = $this->helperOriginAPI->getQuantity('contact', $checkDate);
        }
    }
    public function updateData($checkDate)
    {
        $count = 0;
        // $checkDate = null; //'2016-01-01T00:00:00+03:00';
        $b24countItems = $this->helperOriginAPI->getQuantityUpdate('contact', $checkDate);
        //$b24count = B24Analitics::where('AIM', 2)->first();
        //$b24count = B24Contact::count();



        $requestArray['DATE'] = $checkDate;
        $requestArray['select'] = ['ID', 'LAST_NAME', 'NAME', 'ASSIGNED_BY_ID', 'COMPANY_ID', 'DATE_CREATE', 'DATE_MODIFY'];
        $requestArray['start'] = $count;

        //      $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
        $items = $this->helperOriginAPI->getItemUpdate('contact', $requestArray);
        //dd($items);
        while (count($items) && $b24countItems > $count) {
            foreach ($items as $item) {

                if (!empty($item['DATE_MODIFY']))
                    $item['DATE_MODIFY'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_MODIFY'])->format('Y-m-d H:i:s');
                else $item['DATE_MODIFY'] = NULL;
                if (!empty($item['DATE_CREATE']))
                    $item['DATE_CREATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_CREATE'])->format('Y-m-d H:i:s');
                else $item['DATE_CREATE'] = NULL;
                $this->store($item);
                $count++;
            }
            // $b24count = B24Contact::count(); //save result count
            //$b24count->save();

            $requestArray['start'] = $count;
            $items = $this->helperOriginAPI->getItemUpdate('contact', $requestArray);
            // $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
            $b24countItems = $this->helperOriginAPI->getQuantityUpdate('contact', $checkDate);
        }
    }
}
