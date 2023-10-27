<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class BusinessController extends Controller
{
    private $validateArray = [        
        'name' => 'required|string|max:25',
        'type' => 'required|string|max:25',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = Business::orderBy('name', 'asc')->get();

        return view('business.index', [
            'items' => $item,

            //   'id_node' => $id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Business::orderBy('name', 'asc')->get();

        return view('business.create', [
            'items' => $items,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!empty($request)) {
            $validator = $request->validate($this->validateArray);
            $user = Business::create($request->all());
            return redirect()->back()->with('status', 'Business added!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Business::findOrFail($id);

        return view('business.edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Business::findOrFail($id);
        $this->validateArray['id'] =  'required|integer';//
        $validator = $request->validate($this->validateArray);
          $user->update($request->all());
        return redirect()->back()->with('status', 'Business updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Business::findOrFail($id)->delete();
        return redirect()->route('business.index')->with('status', 'Business deleted!');
    }
}
