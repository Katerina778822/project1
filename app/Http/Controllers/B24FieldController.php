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
        $items = $this->helper->getFields();
        //dd($items);
        foreach ($items as $item) {
        
            if (property_exists($item, 'LIST') && !empty($item->LIST)) {
                foreach ($item->LIST as $list) {

                    $list->FIELD_ID = $item->ID;
                    $list->ENTITY_ID = $item->ENTITY_ID;
                    $list->FIELD_NAME = $item->FIELD_NAME;
                    $list = get_object_vars($list);
                    $this->store($list);
    
                }
            }
        }
        return redirect()->back();
    }
}
