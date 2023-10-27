<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Business;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    private $validateArray = [        
        'name' => 'required|string|max:25',
        'business_id' => 'required|integer',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Branch::orderBy('name', 'asc')->get();

        return view('branch.index', [
            'items' => $users,

            //   'id_node' => $id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Branch::orderBy('name', 'asc')->get();
        $businesses = Business::orderBy('name', 'asc')->get();

        return view('branch.create', [
            'items' => $items,
            'businesses' => $businesses,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!empty($request)) {
            $validator = $request->validate($this->validateArray);
            $business = Branch::create($request->all());
            return redirect()->back()->with('status', 'Branch added!');
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
        $item = Branch::findOrFail($id);
        $businesses = Business::orderBy('name', 'asc')->get();

        return view('branch.edit', [
            'item' => $item,
            'businesses' => $businesses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Branch::findOrFail($id);
        $this->validateArray['id'] =  'required|integer';//
        $validator = $request->validate($this->validateArray);
          $user->update($request->all());
        return redirect()->back()->with('status', 'Branch updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Branch::findOrFail($id)->delete();
        return redirect()->route('branch.index')->with('status', 'Branch deleted!');
    }
}
