<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->typeTask = (int) request('typeTask'); // Convert the received value to integer

        $validator = $request->validate([
            'name' => 'string|max:25',
            'description' => 'required|string|max:1000',
            'deadline' => 'required',
            'deal_id' => 'integer|min:0|required',
            'typeTask' => 'integer|min:0|required',
        ]);
        try {
            $item = Task::find($id);
            if ($item) {
                $item->update($request->all());
            } else
                $this->store($request);

            return redirect()->back()->with('status', 'Task updated!');
        } catch (Exception $e) {
            Log::error('Couldnt create/update Task: ID ' . $id . '\ ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
