<?php

namespace App\Http\Controllers;


use App\Helpers\Bitrix24\b24OriginAPI;
use App\Jobs\b24TaskFetch;
use App\Models\B24Analitics;
use App\Models\B24Task;

use DateTime;
use Exception;
use Illuminate\Http\Request;


class B24TaskController extends AbstractB24Controller
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
        $modelItem = B24Task::where('id', $item['id'])->get();
        if (count($modelItem)) {
            return;
        }
        $modelItem = B24Task::create($item);

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
        $b24Item = B24Task::find($item['id']);

        if (B24Task::where('ID', $item['id'])->exists()) {
            $b24Item->update($item);
        } else
            $this->store($item);
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
        $job = new b24TaskFetch();
        $this->dispatch($job);
    }

    public function fetchData()
    {
        //  $count = 0;
        $checkDate = null; //'2022-01-01T00:00:00+03:00';
        $b24countItems = $this->helperOriginAPI->getQuantity('task', $checkDate);
        //$b24count = B24Analitics::where('AIM', 2)->first();
        $b24count = B24Task::count();



        //$requestArray['filter'][ '>CREATED_DATE']=$checkDate;
        $requestArray['DATE'] = $checkDate;
        $requestArray['select'] = ['ID', 'DESCRIPTION', 'RESPONSIBLE_ID', 'TIME_ESTIMATE', 'TITLE', 'DEADLINE', 'DATE_START', 'STATUS', 'CREATED_DATE', 'guid', 'CREATEDDATE', 'CHANGED_DATE', 'CLOSED_DATE', 'UF_CRM_TASK'];
        $requestArray['start'] = $b24count;

        //      $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
        $items = $this->helperOriginAPI->getItem('task', $requestArray);
        //dd($items);
        while (count($items) && $b24countItems > $b24count) {
            foreach ($items as $item) {
                //      dd($item);
                //     $item = get_object_vars($item);

                if (!empty($item['closedDate']))
                    $item['closedDate'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['closedDate'])->format('Y-m-d H:i:s');
                else $item['closedDate'] = NULL;
                if (!empty($item['createdDate']))
                    $item['createdDate'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['createdDate'])->format('Y-m-d H:i:s');
                else $item['createdDate'] = NULL;
                if (!empty($item['deadline']))
                    $item['deadline'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['deadline'])->format('Y-m-d H:i:s');
                else $item['deadline'] = NULL;
                if (!empty($item['dateStart']))
                    $item['dateStart'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['dateStart'])->format('Y-m-d H:i:s');
                else $item['dateStart'] = NULL;
                if (!empty($item['changedDate']))
                    $item['changedDate'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['changedDate'])->format('Y-m-d H:i:s');
                else $item['changedDate'] = NULL;

                if (!empty($item['ufCrmTask']))
                    foreach ($item['ufCrmTask'] as $hostItem)
                        if (!empty($hostItem))
                            switch (substr($hostItem, 0, 2)) {      //находим сущность, кот принадлежит данная задача
                                case 'C_': {
                                        $str = substr($hostItem, 2, (strlen($hostItem) - 3));
                                        $unsignedBigInt = intval($str);
                                        $item['UF_CRM_TASK_CONTACT'] = $unsignedBigInt;
                                        break;
                                    }
                                case 'CO': {
                                        $str = substr($hostItem, 3, (strlen($hostItem) - 3));
                                        $unsignedBigInt = intval($str);
                                        $item['UF_CRM_TASK_COMPANY'] = $unsignedBigInt;
                                        break;
                                    }
                                case 'L_': {
                                        $str = substr($hostItem, 2, (strlen($hostItem) - 2));
                                        $unsignedBigInt = intval($str);
                                        $item['UF_CRM_TASK_LEAD'] = $unsignedBigInt;
                                        break;
                                    }
                                case 'D_': {
                                        $str = substr($hostItem, 2, (strlen($hostItem) - 2));
                                        $unsignedBigInt = intval($str);
                                        $item['UF_CRM_TASK_DEAL'] = $unsignedBigInt;
                                        break;
                                    }
                                default:
                                    // $item['description'] = $hostItem;
                                    break;
                            }

                $this->update($item);
                // $count++;
            }
            $b24count = B24Task::count(); //save result count
            //$b24count->save();
            // $count = 0;
            $requestArray['start'] = $b24count;
            $items = $this->helperOriginAPI->getItem('task', $requestArray);
            // $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
            $b24countItems = $this->helperOriginAPI->getQuantity('task', $checkDate);
        }

        return redirect()->back();
    }

    public function updateData($checkDate)
    {
        //  $count = 0;
        //$checkDate=null;//'2022-01-01T00:00:00+03:00';
        $b24countItems = $this->helperOriginAPI->getQuantityUpdate('task', $checkDate);
        //$b24count = B24Analitics::where('AIM', 2)->first();
        $count = 0;



        //$requestArray['filter'][ '>CREATED_DATE']=$checkDate;
        $requestArray['DATE'] = $checkDate;
        $requestArray['select'] = ['ID', 'DESCRIPTION', 'RESPONSIBLE_ID', 'TIME_ESTIMATE', 'TITLE', 'DEADLINE', 'DATE_START', 'STATUS', 'CREATED_DATE', 'guid', 'CREATEDDATE', 'CHANGED_DATE', 'CLOSED_DATE', 'UF_CRM_TASK'];
        $requestArray['start'] = $count;

        //      $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
        $items = $this->helperOriginAPI->getItemUpdate('task', $requestArray);
        //dd($items);
        while (count($items) && $b24countItems > $count) {
            foreach ($items as $item) {
                //      dd($item);
                //     $item = get_object_vars($item);

                if (!empty($item['closedDate']))
                    $item['closedDate'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['closedDate'])->format('Y-m-d H:i:s');
                else $item['closedDate'] = NULL;
                if (!empty($item['createdDate']))
                    $item['createdDate'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['createdDate'])->format('Y-m-d H:i:s');
                else $item['createdDate'] = NULL;
                if (!empty($item['deadline']))
                    $item['deadline'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['deadline'])->format('Y-m-d H:i:s');
                else $item['deadline'] = NULL;
                if (!empty($item['dateStart']))
                    $item['dateStart'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['dateStart'])->format('Y-m-d H:i:s');
                else $item['dateStart'] = NULL;
                if (!empty($item['changedDate']))
                    $item['changedDate'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['changedDate'])->format('Y-m-d H:i:s');
                else $item['changedDate'] = NULL;

                if (!empty($item['ufCrmTask']))
                    foreach ($item['ufCrmTask'] as $hostItem)
                        if (!empty($hostItem))
                            switch (substr($hostItem, 0, 2)) {      //находим сущность, кот принадлежит данная задача
                                case 'C_': {
                                        $str = substr($hostItem, 2, (strlen($hostItem) - 3));
                                        $unsignedBigInt = intval($str);
                                        $item['UF_CRM_TASK_CONTACT'] = $unsignedBigInt;
                                        break;
                                    }
                                case 'CO': {
                                        $str = substr($hostItem, 3, (strlen($hostItem) - 3));
                                        $unsignedBigInt = intval($str);
                                        $item['UF_CRM_TASK_COMPANY'] = $unsignedBigInt;
                                        break;
                                    }
                                case 'L_': {
                                        $str = substr($hostItem, 2, (strlen($hostItem) - 2));
                                        $unsignedBigInt = intval($str);
                                        $item['UF_CRM_TASK_LEAD'] = $unsignedBigInt;
                                        break;
                                    }
                                case 'D_': {
                                        $str = substr($hostItem, 2, (strlen($hostItem) - 2));
                                        $unsignedBigInt = intval($str);
                                        $item['UF_CRM_TASK_DEAL'] = $unsignedBigInt;
                                        break;
                                    }
                                default:
                                    // $item['description'] = $hostItem;
                                    break;
                            }
                if ($item['id'] == 242737)
                dd($item);
                    $this->update($item);
                $count++;
            }
            //$b24count =B24Task::count(); //save result count
            //$b24count->save();
            // $count = 0;
            $requestArray['start'] = $count;
            $items = $this->helperOriginAPI->getItemUpdate('task', $requestArray);
            // $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
            $b24countItems = $this->helperOriginAPI->getQuantityUpdate('task', $checkDate);
        }
    }
}
