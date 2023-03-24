<?php

namespace App\Http\Controllers;

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
        $modelItem = B24Task::where('ID', $item['ID'])->get();
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
        $items = $this->helper->getTasks();
        //dd($items);
        foreach ($items as $item) {
            //      dd($item);
            $item = get_object_vars($item);

            if (!empty($item['DEADLINE']))
                $item['DEADLINE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DEADLINE']);
            else $item['DEADLINE'] = NULL;
            if (!empty($item['ACTIVITY_DATE']))
                $item['ACTIVITY_DATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['ACTIVITY_DATE']);
            else $item['ACTIVITY_DATE'] = NULL;
            if (!empty($item['CLOSED_DATE']))
                $item['CLOSED_DATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['CLOSED_DATE']);
            else $item['CLOSED_DATE'] = NULL;
            if (!empty($item['CREATED_DATE']))
                $item['CREATED_DATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['CREATED_DATE']);
            else $item['CREATED_DATE'] = NULL;

            $this->store($item);
        }
        return redirect()->back();
    }
}
