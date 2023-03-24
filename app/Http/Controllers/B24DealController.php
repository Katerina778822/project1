<?php

namespace App\Http\Controllers;

use App\Models\B24Deal;
use DateTime;
use Exception;
use Illuminate\Http\Request;

class B24DealController extends AbstractB24Controller
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
        $modelItem = B24Deal::where('ID', $item['ID'])->get();
        if (count($modelItem)) {
            return;
        }
        $modelItem = B24Deal::create($item);

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
        $items = $this->helper->getDeals();
        //dd($items);
        foreach ($items as $item) {
            //      dd($item);
            $item = get_object_vars($item);
            $item['DATE_CREATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_CREATE']);
            if (!empty($item['UF_CRM_5CAB07390C964']))
                $item['UF_CRM_5CAB07390C964'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['UF_CRM_5CAB07390C964']);
                else $item['UF_CRM_5CAB07390C964'] = NULL;
            if (!empty($item['UF_CRM_1540120643248']))
                $item['UF_CRM_1540120643248'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['UF_CRM_1540120643248']);
                else $item['UF_CRM_1540120643248'] = NULL;
            if (!empty($item['UF_CRM_1545811274193']))
                $item['UF_CRM_1545811274193'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['UF_CRM_1545811274193']);
                else $item['UF_CRM_1545811274193'] = NULL;
            if (!empty($item['UF_CRM_1547732437301']))
                $item['UF_CRM_1547732437301'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['UF_CRM_1547732437301']);
                else $item['UF_CRM_1547732437301'] = NULL;
            if (!empty($item['CLOSEDATE']))
                $item['CLOSEDATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['CLOSEDATE']);
                else $item['CLOSEDATE'] = NULL;

                $this->store($item);
        }
        return redirect()->back();
    }
}
