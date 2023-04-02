<?php

namespace App\Http\Controllers;

use App\Helpers\Bitrix24\b24Companies;
use App\Models\B24Field;
use Exception;
use Illuminate\Http\Request;

class B24FieldController extends AbstractB24Controller
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
        $modelItem = B24Field::where('ID', $item['ID'])->get();
        if (count($modelItem)) {
            return;
        }
        $modelItem = B24Field::create($item);

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
  //      $item2 = $this->helper->getFields();
        //  $count = 0;
        $checkDate = null;//'2016-01-01T00:00:00+03:00';
        $b24countItems = $this->helperOriginAPI->getQuantity('field', $checkDate);
        //$b24count = B24Analitics::where('AIM', 2)->first();
        $b24count = B24Field::count();


        $fieldApicount=0;
        //$requestArray['filter'][ '>CREATED_DATE']=$checkDate;
        $requestArray['DATE'] = $checkDate;
        $requestArray['select'] = ['ID', 'VALUE', 'ENTITY_ID', 'FIELD_NAME', 'FIELD_ID'];
        $requestArray['start'] = 0;

        //      $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
        $items = $this->helperOriginAPI->getItem('field', $requestArray);
        //dd($items);
    //  while (count($items)) {
            foreach ($items as $item) {
                $fieldApicount++;
                if ( !empty($item['LIST'])) {
                    foreach ($item['LIST'] as $list) {
    
                        $list['FIELD_ID'] = $item["ID"];
                        $list['ENTITY_ID'] = $item['ENTITY_ID'];
                        $list['FIELD_NAME'] = $item['FIELD_NAME'];
                       // $list = get_object_vars($list);
                        $this->store($list);
        
                    }
                  
                }
            }
           // $b24count = B24Field::count(); //save result count
            //$b24count->save();
            // $count = 0;
            $requestArray['start'] = 0;//передаем только основные поля без значений
            $items = $this->helperOriginAPI->getItem('field', $requestArray);
            // $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
           
     //   }
     //   dd($item);
        return redirect()->back();
    }
}
