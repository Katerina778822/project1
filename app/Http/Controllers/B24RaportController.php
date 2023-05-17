<?php

namespace App\Http\Controllers;

use App\Models\B24Activity;
use App\Models\B24Raport;
use App\Models\B24Ring;
use App\Models\B24Task;
use App\Models\Company;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class B24RaportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $D = Company::find(5445);
        $deals = $D->getClientStatus();// 4-новый; 3-Остывший; 2 - База; 1 - Клиент;
        $timezone = new DateTimeZone('Europe/Kiev');
        $start = new DateTime('now', $timezone);
        $end = new DateTime('now', $timezone);
        $start->setTime(0, 0, 0);
$user_id=14;
        $Rings = B24Ring::whereBetween('b24_rings.CALL_START_DATE', [$start, $end])
        ->where('CALL_DURATION','>','10')->get();
        $Activities = B24Activity::whereBetween('b24_activity.LAST_UPDATED', [$start, $end])
        ->where('PROVIDER_ID','IMOPENLINES_SESSION')->get();
        $itemsRings = Company::whereIn('CRM_COMPANY_ID',$Rings->pluck('F2')->toArray());
        //dd($catalog);
        return view('bitrix24.raport.index', [
            'items' => $items,
         //   'items' => $id
        ]);
        
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
    public function store(Request $request)
    {
        //
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
    //@fill b24raports table by actual data
    public function calculatePeriod(DateTime $start, DateTime $end = null)
    {
    }
}
