<?php

namespace App\Http\Controllers;

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
        $items = $this->helperOriginAPI->getLeads();
        //dd($items);
        foreach ($items as $item) {

            $item['COMMENTS'] = substr($item['COMMENTS'], 0, 255);
            if (!empty($item['DATE_CREATE']))
                $item['DATE_CREATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_CREATE']);
            else $item['DATE_CREATE'] = NULL;
            if (!empty($item['DATE_CLOSED']))
                $item['DATE_CLOSED'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_CLOSED']);
            else $item['DATE_CLOSED'] = NULL;
            if (!empty($item['DATE_MODIFY']))
                $item['DATE_MODIFY'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_MODIFY']);
            else $item['DATE_MODIFY'] = NULL;

            if (!empty($item['PHONE']))
                if (!empty($item['PHONE'][0]))
                    $item['PHONE'] = $item['PHONE'][0]['VALUE'];


            $this->store($item);
        }
        return redirect()->back();
    }
}
