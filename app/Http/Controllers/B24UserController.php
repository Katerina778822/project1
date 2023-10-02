<?php

namespace App\Http\Controllers;

use App\Models\B24User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class B24UserController extends AbstractB24Controller
{
    private $validateArray = [
        'ID' => 'required|integer|unique:App\Models\B24User,ID',
        'NAME' => 'required|string|max:25',
        'LAST_NAME' => 'required|string|max:25',
        'ACTIVE' => 'required|integer|min:0|max:1',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = B24User::orderBy('ID', 'asc')->get();
        return view('bitrix24.b24user.index', [
            'items' => $users,
            //   'id_node' => $id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Bitrix24.B24User.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!empty($request)) {
   
            $validator = $request->validate($this->validateArray);


            $user = B24User::create($request->all());

            return redirect()->back()->with('status', 'User added!');
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
        $user = B24User::findOrFail($id);

        return view('bitrix24.B24user.edit', [
            'item' => $user,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $user = B24User::findOrFail($id);
        $this->validateArray['ID'] =  'required|integer';//
        $validator = $request->validate($this->validateArray);

          $user->update($request->all());

        return redirect()->back()->with('status', 'crm User updated!');
    }

    public function updateItem(array $item)
    {
        $b24Item = B24User::find($item['ID']);

        if (!empty($b24Item)) {
            $b24Item->update($item);
        } else
            B24User::create($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        B24User::findOrFail($id)->delete();

        return redirect()->route('B24User.index')->with('status', 'User deleted!');
    }


    public function fetchAll()
    {
        //  $count = 0;
        $checkDate = null; //'2016-01-01T00:00:00+03:00';
        $b24countItems = $this->helperOriginAPI->getQuantity('user', $checkDate);
        //$b24count = B24Analitics::where('AIM', 2)->first();
        $b24count = B24User::count();



        //$requestArray['filter'][ '>CREATED_DATE']=$checkDate;
        $requestArray['DATE'] = $checkDate;
        $requestArray['select'] = [
            'ID',
            'TITLE',
            'UF_CRM_1540465145514', // замените на идентификатор своего пользовательского поля
            'UF_CRM_1540121191354', // замените на идентификатор своего пользовательского поля
            'UF_CRM_5DBAA9FFCC357', // замените на идентификатор своего пользовательского поля
            'UF_CRM_1597826997473', // замените на идентификатор своего пользовательского поля

            'ASSIGNED_BY_ID',
            'LAST_ACTIVITY_BY',
            'COMPANY_TYPE',
            'DATE_CREATE',
            'DATE_MODIFY',
            'LAST_ACTIVITY_TIME',
        ];
        $requestArray['start'] = $b24count;

        //      $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
        $items = $this->helperOriginAPI->getItem('user', $requestArray);
        //dd($items);
        while (count($items) && $b24countItems > $b24count) {
            foreach ($items as $item) {


                $this->updateItem($item);
            }
            $b24count = B24User::count(); //save result count
            //$b24count->save();
            // $count = 0;
            $requestArray['start'] = $b24count;
            $items = $this->helperOriginAPI->getItem('user', $requestArray);
            // $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
            $b24countItems = $this->helperOriginAPI->getQuantity('user', $checkDate);
        }
    }
    public function updateData($checkDate)
    {
        //  $count = 0;
        $checkDate = null; //'2016-01-01T00:00:00+03:00';
        $b24countItems = $this->helperOriginAPI->getQuantityUpdate('user', $checkDate);
        //$b24count = B24Analitics::where('AIM', 2)->first();
        $count = 0;


        //$requestArray['filter'][ '>CREATED_DATE']=$checkDate;
        $requestArray['DATE'] = $checkDate;
        $requestArray['select'] = [
            'ID',
            'TITLE',
            'UF_CRM_1540465145514', // замените на идентификатор своего пользовательского поля
            'UF_CRM_1540121191354', // замените на идентификатор своего пользовательского поля
            'UF_CRM_5DBAA9FFCC357', // замените на идентификатор своего пользовательского поля
            'UF_CRM_1597826997473', // замените на идентификатор своего пользовательского поля

            'ASSIGNED_BY_ID',
            'LAST_ACTIVITY_BY',
            'COMPANY_TYPE',
            'DATE_CREATE',
            'DATE_MODIFY',
            'LAST_ACTIVITY_TIME',
        ];
        $requestArray['start'] = $count;

        //      $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
        $items = $this->helperOriginAPI->getItemUpdate('user', $requestArray);
        //dd($items);
        while (count($items) && $b24countItems > $count) {
            foreach ($items as $item) {


                $this->updateItem($item);
                $count++;
            }
            $b24count = B24User::count(); //save result count
            //$b24count->save();
            // $count = 0;
            $requestArray['start'] = $count;
            $items = $this->helperOriginAPI->getItemUpdate('user', $requestArray);
            // $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
            $b24countItems = $this->helperOriginAPI->getQuantityUpdate('user', $checkDate);
        }
    }
}
