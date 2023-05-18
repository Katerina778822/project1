<?php

namespace App\Http\Controllers;

use App\Models\B24Activity;
use App\Models\B24Contact;
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
        $deals = $D->getClientStatus(); // 4-новый; 3-Остывший; 2 - База; 1 - Клиент;

        $item = [];
        $timezone = new DateTimeZone('Europe/Kiev');
        $start = new DateTime('now', $timezone);
        $end = new DateTime('now', $timezone);
        $start->setTime(0, 0, 0);
        $user_id = 14;
        $Rings = B24Ring::whereBetween('b24_rings.CALL_START_DATE', [$start, $end])
            ->where([
                ['CALL_DURATION', '>', '10'],
                ['PORTAL_USER_ID', $user_id],
            ])->get();
        //заполнение/обновление клиентодел из звонков
        foreach ($Rings as $ring) {

            $ring->CRM_COMPANY_ID?$item['COMPANY_ID'] = $ring->CRM_COMPANY_ID:0;
            $ring->CRM_CONTACT_ID?$item['CONTACT_ID'] = $ring->CRM_CONTACT_ID:0;
            $ring->CRM_LEAD_ID?$item['LEAD_ID'] = $ring->CRM_LEAD_ID:0;
            $item['PHONE_NUMBER'] = $ring->PHONE_NUMBER;
            $item['DATE'] = $end;
            $item['USER_ID'] = $user_id;
            //поиск клиентодел данной компании за сегодня 
            $raport = B24Raport::join('b24_rings','b24_raports.RING_ID','=','b24_rings.ID')
            ->whereBetween('b24_raports.DATE', [ $start->format('Y-m-d'), $end->format('Y-m-d')])
            ->where([
        //        ['b24_raports.DATE','=',$end->format('Y-m-d')],
                ['b24_rings.PHONE_NUMBER','=',$ring->PHONE_NUMBER],
        //        ['COMPANY_ID' => $ring->PHONE_NUMBER],
            ])
            ->get();
            if (count($raport)) {
                $raport->update($item);
            } else { //создаем клиентодело для контакта
                $raport = B24Raport::create($item);
            }
            
        }


        $var =  $Rings->unique('CRM_COMPANY_ID')->pluck('CRM_COMPANY_ID')->toArray();
        $itemsRings = Company::whereIn('ID', $var);
        $Activities = B24Activity::whereBetween('b24_activity.LAST_UPDATED', [$start, $end])
            ->where('PROVIDER_ID', 'IMOPENLINES_SESSION')->get();

        //dd($catalog);
        return view('bitrix24.raport.index', [
            //'items' => $items,
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
