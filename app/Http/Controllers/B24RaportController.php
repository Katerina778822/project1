<?php

namespace App\Http\Controllers;

use App\Jobs\B24Raport as JobsB24Raport;
use App\Models\B24Activity;
use App\Models\B24Analitics;
use App\Models\B24Contact;
use App\Models\B24Deal;
use App\Models\B24Lead;
use App\Models\B24Raport;
use App\Models\B24Ring;
use App\Models\B24Task;
use App\Models\B24User;
use App\Models\Company;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class B24RaportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function UpdateData()
    {
        // $deals = $D->getClientStatus(); // 4-новый; 3-Остывший; 2 - База; 1 - Клиент;
        $timezone = new DateTimeZone('Europe/Kiev');
        $start = new DateTime('now', $timezone);
        //$start = $start->modify('-1 day'); //TEMP!!
        $end = new DateTime('now', $timezone);
        // $end = $end->modify('-1 day'); //TEMP!!
        // $end->setTime(21, 0, 0);//TEMP!!
        $start->setTime(0, 0, 0);
        $user_id = 1489;
        //заполнение/обновление клиентодел из чатов
        $Activities = B24Activity::whereBetween('b24_activity.LAST_UPDATED', [$start, $end])
            ->where('PROVIDER_ID', 'IMOPENLINES_SESSION')->get();
        foreach ($Activities as $activity) {
            $item = [];
            $company = null;
            $item['ACTIVITY_ID'] = $activity->ID2;
            $item['DATE'] = $end;
            if ($activity->COMPANY_ID) { //если в чате есть компания
                $item['COMPANY_ID'] = $activity->COMPANY_ID;
                $company = Company::find($activity->COMPANY_ID);
                $item['USER_ID'] = $company->ASSIGNED_BY_ID;
                $item['DEAL_TYPE'] = $company->getClientStatus();
                $searchRaportConditions[] = ['b24_raports.COMPANY_ID', '=', $activity->COMPANY_ID];
            } elseif ($activity->CONTACT_ID) { //если в чате есть контакт
                $item['CONTACT_ID'] = $activity->CONTACT_ID;
                $company = Company::find(B24Contact::find($activity->CONTACT_ID)->COMPANY_ID);
                $searchRaportConditions[] = ['b24_raports.CONTACT_ID', '=', $item['CONTACT_ID']];
                if ($company) {
                    $item['COMPANY_ID'] = $company->ID;
                    $item['USER_ID'] = $company->ASSIGNED_BY_ID;
                    $item['DEAL_TYPE'] = $company->getClientStatus();
                    $searchRaportConditions[] = ['b24_raports.COMPANY_ID', '=', $item['COMPANY_ID']];
                }
            } elseif ($activity->DEAL_ID) { //если в чате есть сделка
                $item['DEAL_ID'] = $activity->DEAL_ID;
                $company = Company::find(B24Deal::find($activity->DEAL_ID)->COMPANY_ID);
                $searchRaportConditions[] = ['b24_raports.DEAL_ID', '=', $item['DEAL_ID']];
                if ($company) {
                    $item['COMPANY_ID'] = $company->ID;
                    $item['USER_ID'] = $company->ASSIGNED_BY_ID;
                    $item['DEAL_TYPE'] = $company->getClientStatus();
                    $searchRaportConditions[] = ['b24_raports.COMPANY_ID', '=', $item['COMPANY_ID']];
                }
            } elseif ($activity->DEAL_ID) { //если в чате есть лид
                $item['LEAD_ID'] = $activity->LEAD_ID;
                $item['USER_ID'] =  B24Lead::find($activity->LEAD_ID)->ASSIGNED_BY_ID;
                $item['DEAL_TYPE'] = 1;
                $searchRaportConditions[] = ['b24_raports.COMPANY_ID', '=', $item['COMPANY_ID']];
                $company = Company::find(B24Lead::find($activity->LEAD_ID)->COMPANY_ID);
                if ($company) {
                    $item['COMPANY_ID'] = $company->ID;
                    $item['USER_ID'] = $company->ASSIGNED_BY_ID;
                    $item['DEAL_TYPE'] = $company->getClientStatus();
                    $searchRaportConditions[] = ['b24_raports.COMPANY_ID', '=', $item['COMPANY_ID']];
                }
            }
            //поиск клиентодел (чаты) данной компании за сегодня 
            $raportFound = false;
            $raport = null;
            //  if (!empty($item['COMPANY_ID'])) //TEMP!!
            //    if ($item['COMPANY_ID'] == 4199) //TEMP!!
            //      $r = 0; //TEMP!!!
            foreach ($searchRaportConditions as $condition) {
                $raport = B24Raport:: //
                    //    ->whereBetween('b24_raports.DATE', [ $start->format('Y-m-d'), $end->format('Y-m-d')])
                    where([
                        ['b24_raports.DATE', '=', $end->format('Y-m-d')],
                        $condition,
                        //        ['COMPANY_ID' => $ring->PHONE_NUMBER],
                    ])
                    ->join('b24_activity', 'b24_raports.ACTIVITY_ID', '=', 'b24_activity.ID2')
                    ->first();
                if (!empty($raport)) {
                    $raportFound = true;
                    break;
                }
            }
            if ($raportFound) {
                if ($company) {
                    $dealArray = $company->getLastOpenDealStatus($raport->DEAL_STATUS ?? 0);
                    $item['DEAL_STATUS'] = $dealArray['STATUS'];
                    $item['SUMM'] = $dealArray['SUMM'] ?? 0;
                }
                $raport->update($item);
            } else { //создаем клиентодело для контакта
                if ($company) {
                    $dealArray = $company->getLastOpenDealStatus($raport->DEAL_STATUS ?? 0);
                    $item['DEAL_STATUS'] = $dealArray['STATUS'];
                    $item['SUMM'] = $dealArray['SUMM'] ?? 0;
                }
                $raport = B24Raport::create($item);
            }
        }
        //заполнение/обновление клиентодел из звонков
        $Rings = B24Ring::whereBetween('b24_rings.CALL_START_DATE', [$start, $end])
            ->where([
                ['CALL_DURATION', '>', '10'],
                //    ['PORTAL_USER_ID', $user_id],//TEMP!!
            ])
            ->get();
        foreach ($Rings as $ring) {

            $item = [];
            $searchRaportConditions = [];
            $searchRaportConditions[] = ['b24_rings.PHONE_NUMBER', '=', $ring->PHONE_NUMBER];
            $company = null;
            //  $item['USER_ID'] = $user_id;
            $item['RING_ID'] = $ring->ID;
            $item['PHONE_NUMBER'] = $ring->PHONE_NUMBER;
            $item['DATE'] = $end;
            if ($ring->CRM_COMPANY_ID) { //если в звонке есть компания
                $item['COMPANY_ID'] = $ring->CRM_COMPANY_ID;
                $company = Company::find($ring->CRM_COMPANY_ID);
                $item['USER_ID'] = $company->ASSIGNED_BY_ID;
                $item['DEAL_TYPE'] = $company->getClientStatus();
                // $item['DEAL_STATUS'] = $company->getLastOpenDealStatus();
                $searchRaportConditions[] = ['b24_raports.COMPANY_ID', '=',  $item['COMPANY_ID']];
            } elseif ($ring->CRM_CONTACT_ID) { //если в звонке есть контакт
                $item['CONTACT_ID'] = $ring->CRM_CONTACT_ID;
                $searchRaportConditions[] = ['b24_raports.CONTACT_ID', '=',  $item['CONTACT_ID']]; //ищем рапорт по контакту               $company = Company::find(B24Contact::find($ring->CRM_CONTACT_ID)->COMPANY_ID);
                $company = Company::find(B24Contact::find($ring->CRM_CONTACT_ID)->COMPANY_ID);
                if ($company) {
                    $item['COMPANY_ID'] = $company->ID;
                    $item['USER_ID'] = $company->ASSIGNED_BY_ID;
                    $item['DEAL_TYPE'] = $company->getClientStatus();
                    //   $item['DEAL_STATUS'] = $company->getLastOpenDealStatus();
                    $searchRaportConditions[] = ['b24_raports.COMPANY_ID', '=',  $item['COMPANY_ID']]; //ищем рапорт по компании
                }
            } elseif ($ring->CRM_LEAD_ID) { //если в звонке есть лид
                $item['LEAD_ID'] = $ring->CRM_LEAD_ID;
                $item['USER_ID'] =  B24Lead::find($ring->CRM_LEAD_ID)->ASSIGNED_BY_ID;
                $item['DEAL_TYPE'] = 4;
                $searchRaportConditions[] = ['b24_raports.LEAD_ID', '=',  $item['LEAD_ID']];
                $company = Company::find(B24Lead::find($ring->CRM_LEAD_ID)->COMPANY_ID);
                if ($company) {
                    $item['COMPANY_ID'] = $company->ID;
                    $item['USER_ID'] = $company->ASSIGNED_BY_ID;
                    $item['DEAL_TYPE'] = $company->getClientStatus();
                    //  $item['DEAL_STATUS'] = $company->getLastOpenDealStatus();
                    $searchRaportConditions[] = ['b24_raports.COMPANY_ID', '=',  $item['COMPANY_ID']];
                }
            }
            //   if (!empty($item['COMPANY_ID'])) //TEMP!!
            //       if ($item['COMPANY_ID'] == 103137) //TEMP!!
            //           $r = 0; //TEMP!!!
            //поиск клиентодел (звонки) данной компании за сегодня 
            $raportFound = false;
            $raport = null;

            //     if (!empty($item['COMPANY_ID'])) //TEMP!!
            //           if ($item['COMPANY_ID'] == 4199) //TEMP!!
            //                 $r = 0; //TEMP!!!

            foreach ($searchRaportConditions as $condition) {
                $raport = B24Raport:: //
                    //    ->whereBetween('b24_raports.DATE', [ $start->format('Y-m-d'), $end->format('Y-m-d')])
                    where([
                        ['b24_raports.DATE', '=', $end->format('Y-m-d')],
                        //     ['b24_rings.PHONE_NUMBER',$ring->PHONE_NUMBER]
                        $condition
                        //        ['COMPANY_ID' => $ring->PHONE_NUMBER],
                    ])
                    ->leftjoin('b24_rings', 'b24_raports.RING_ID', '=', 'b24_rings.ID')
                    ->first();
                if (!empty($raport)) {
                    $raportFound = true;
                    break;
                }
            }
            if ($raportFound) {
                if ($company) {
                    $dealArray = $company->getLastOpenDealStatus($raport->DEAL_STATUS ?? 0);
                    $item['DEAL_STATUS'] = $dealArray['STATUS'];
                    $item['SUMM'] = $dealArray['SUMM'] ?? 0;
                }
                $raport->update($item);
            } else { //создаем клиентодело новое
                if ($company) {
                    $dealArray = $company->getLastOpenDealStatus($raport->DEAL_STATUS ?? 0);
                    $item['DEAL_STATUS'] = $dealArray['STATUS'];
                    $item['SUMM'] = $dealArray['SUMM'] ?? 0;
                }
                $raport = B24Raport::create($item);
            }
        }

        //заполнение/обновление клиентодел из СДЕЛОК
        $Deals = B24Deal::whereBetween('b24_deals.DATE_MODIFY', [$start, $end])
            ->where([
                //    ['PORTAL_USER_ID', $user_id],//TEMP!!
            ])
            ->get();
        foreach ($Deals as $deal) {
            $item = [];
            $searchRaportConditions = [];
            $company = null;
            //  if ($deal['ID'] == 103137) //TEMP!!
            //        $r = 0; //TEMP!!!
            //  $item['USER_ID'] = $user_id;
            $item['DEAL_ID'] = $deal->ID;
            $item['DATE'] = $end;
            $item['USER_ID'] = $deal->ASSIGNED_BY_ID;
            if ($deal->COMPANY_ID && ($deal->DATE_WIN == '' || $deal->DATE_WIN == $start->format('Y-m-d'))) { //если в сделке есть компания
                $item['COMPANY_ID'] = $deal->COMPANY_ID;
                $company = Company::find($deal->COMPANY_ID);
                $item['DEAL_TYPE'] = $company->getClientStatus();
                // $item['DEAL_STATUS'] = $company->getLastOpenDealStatus();
                $searchRaportConditions[] = ['b24_raports.COMPANY_ID', '=',  $item['COMPANY_ID']];

                //поиск клиентодел (сделка)по компаниям за сегодня 
                $raportFound = false;
                $raport = null;

                //     if (!empty($item['COMPANY_ID'])) //TEMP!!
                //           if ($item['COMPANY_ID'] == 4199) //TEMP!!
                //                 $r = 0; //TEMP!!!

                foreach ($searchRaportConditions as $condition) {
                    $raport = B24Raport:: //
                        //    ->whereBetween('b24_raports.DATE', [ $start->format('Y-m-d'), $end->format('Y-m-d')])
                        where([
                            ['b24_raports.DATE', '=', $end->format('Y-m-d')],
                            //     ['b24_rings.PHONE_NUMBER',$ring->PHONE_NUMBER]
                            $condition
                            //        ['COMPANY_ID' => $ring->PHONE_NUMBER],
                        ])
                        ->leftjoin('b24_deals', 'b24_raports.DEAL_ID', '=', 'b24_deals.ID')
                        ->first();
                    if (!empty($raport)) {
                        $raportFound = true;
                        break;
                    }
                }
                if ($raportFound) {
                    if ($company && (!$raport->ACTIVITY_ID && !$raport->RING_ID)) {
                        $dealArray = $company->getLastOpenDealStatus($raport->DEAL_STATUS ?? 0);
                        $item['DEAL_STATUS'] = $dealArray['STATUS'];
                        $item['SUMM'] = $dealArray['SUMM'] ?? 0;
                    }
                    $raport->update($item);
                } else { //создаем клиентодело новое
                    if ($company && (!$raport->ACTIVITY_ID && !$raport->RING_ID)) {
                        $dealArray = $company->getLastOpenDealStatus($raport->DEAL_STATUS ?? 0);
                        $item['DEAL_STATUS'] = $dealArray['STATUS'];
                        $item['SUMM'] = $dealArray['SUMM'] ?? 0;
                    }
                    $raport = B24Raport::create($item);
                }
            }
        }
        //запись даты формирования отчета в базу данных
        $timezone = new DateTimeZone('Europe/Kiev');
        $currentTime = new DateTime('now', $timezone);
        $Time = B24Analitics::where([
            ['AIM', 4488],
        ])->first();
        if (empty($Time)) {
            $time = B24Analitics::create([
                'AIM' => 4488,
                'date1' => $currentTime,
            ]);
        } else {
            $Time->date1  = $currentTime->format('Y-m-d H:i:s');
            $Time->save();
        }
    }

    public function index()
    {

        $job = new JobsB24Raport();
        $this->dispatch($job);
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
    public function show($user_id, Request $request)
    {
        $raports = B24Raport::where([
            ['USER_ID', $user_id],
            ['DATE', $request->date],
        ])->get();
        $items = new Collection();
        foreach ($raports as $raport) {
            $company = 'Компания/Лид не найдены';
            $title = '';
            if ($raport['COMPANY_ID']) {
                $company = Company::find($raport['COMPANY_ID']);
            } elseif ($raport['LEAD_ID']) {
                $company =  B24Lead::find($raport['LEAD_ID']);
                $title = 'ЛИД: ';
            } elseif ($raport['CONTACT_ID']) {
                $contact =  B24Contact::find($raport['CONTACT_ID']);
                $title = 'Контакт: ' . $contact->NAME . ' ' . $contact->LAST_NAME;
            }
            $business = '-';


            if ($raport->RING_ID)
                $business = 'Звонок';
            else if ($raport->ACTIVITY_ID)
                $business = 'Чат';
            else if ($raport->DEAL_ID)
                $business = 'Сделка';

            // if ($raport['DEAL_ID']) {
            //$deal = B24Deal::find($raport['DEAL_ID']);            }
            $items->add([
                'TITLE' => $title . ($company->TITLE ?? "Не найдено"),
                'ID' => $company->ID ?? "Не найдено",
                'DEAL' => $raport->DEAL_ID ?? "-",
                'DATE' => $raport->DATE ?? "-",
                'SUMM' => $raport->SUMM,
                'DEAL_STATUS' => B24Deal::$dealStatusArray[$raport->DEAL_STATUS],
                'DEAL_TYPE' =>  Company::$clientStatus[$raport->DEAL_TYPE],
                'BUSINESS' => $business,
                'RING_ID' => $raport->RING_ID ?? "-",
                'ACTIVITY_ID' => $raport->ACTIVITY_ID ?? "-",
                'URL_TYPE' => $raport['COMPANY_ID'] ? 0 : 1,

            ]);
        }
        $mainRaports = $this->calculateMainRaport($user_id, $request->date);
        $user = B24User::find($user_id);
        $cronTime = B24Analitics::where('AIM', 4477)->first() ?? 0;
        $agendaTime = B24Analitics::where([
            'AIM' => 4488,
        ])->first() ?? 0;
        return view('bitrix24.raport.show', [
            'mainRaports' => $mainRaports,
            'user' => $user->NAME . ' ' . $user->LAST_NAME,
            'items' => $items,
            'cronTime' => $cronTime ? $cronTime->date1 : 0,
            'agendaTime' => $agendaTime ? $agendaTime->date1 : 0
        ]);
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
    public function calculateMainRaport($user_id, string $start, string  $end = null)
    {
        if (!$end) {
            $timezone = new DateTimeZone('Europe/Kiev');
            $end  = new DateTime('now', $timezone);
            $end = $end->format('Y-m-d');
        }
        $items = B24Raport::where([
            ['b24_raports.USER_ID', '=', $user_id],
            ['b24_raports.DATE', '>=', $start],
            ['b24_raports.DATE', '<=', $end],
            ['b24_raports.DEAL_STATUS', '=', 4],
        ])
            ->select('DEAL_TYPE', DB::raw('SUM(SUMM) as TOTAL'))
            ->groupBy('DEAL_TYPE')
            ->get();

        foreach ($items as $item) {
            $item['DEAL_TYPE'] = Company::$clientStatus[$item['DEAL_TYPE']];
        }
        return $items;
    }
}
