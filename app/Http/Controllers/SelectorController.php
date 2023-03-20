<?php

namespace App\Http\Controllers;

use App\Models\Nodes;
use App\Models\Selectors;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class SelectorController extends Controller
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

    public function createAll($id)
    {
$node=Nodes::find($id);

        $selectors = $node->Selectors;
        //dd('Here');  
        /*  foreach ($selectors as $selector) {
            if (isEmpty($selectors['b1']))
                $selectors['b1'] = '';
            if (isEmpty($selectors['b2']))
                $selectors['b2'] = '';
            if (isEmpty($selectors['b3']))
                $selectors['b3'] = '';
            if (isEmpty($selectors['gd']))
                $selectors['gd'] = '';
            if (isEmpty($selectors['im']))
                $selectors['im'] = '';
            if (isEmpty($selectors['ds']))
                $selectors['ds'] = '';
            if (isEmpty($selectors['cp']))
                $selectors['cp'] = '';
            if (isEmpty($selectors['nm']))
                $selectors['nm'] = '';
            if (isEmpty($selectors['vd']))
                $selectors['vd'] = '';
            if (isEmpty($selectors['ar']))
                $selectors['ar'] = '';
            if (isEmpty($selectors['pr']))
                $selectors['pr'] = '';
            if (isEmpty($selectors['st']))
                $selectors['st'] = '';
            if (isEmpty($selectors['f1']))
                $selectors['f1'] = '';
            if (isEmpty($selectors['f2']))
                $selectors['f2'] = '';
            if (isEmpty($selectors['f3']))
                $selectors['f3'] = '';
            if (isEmpty($selectors['f4']))
                $selectors['f4'] = '';
            if (isEmpty($selectors['f5']))
                $selectors['f5'] = '';
        }*/
    
        return view('selector.create', [
            'selectors' => $selectors,
            'node_id' => $id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $selectorsOld = Selectors::all();
        $input = $request->except(['_token', 'node_id']);
        foreach ($input as $key => $field) {
           
            if ($request->get($key)!=''){//check not null entered selector data
                $Selector = Selectors::firstOrNew(
                    [
                        'name' => $key,
                        'fid_id_node' => (int) $request->get('node_id')
                    ],

                );
                $Selector->value=$field;
                $Selector->fid_id_node=(int) $request->get('node_id');
                
                $Selector->save();
               // dd($Selector);
          
           // dd($Selector->value);
            }
    
        }
        /* $Selectors = Selectors::create([
            'b1' => $request->get('b1'),
            'b2' => $request->get('b2'),
            'b2' => $request->get('b3'),
            'gd' => $request->get('gd'),
            'im' => $request->get('im'),
            'ds' => $request->get('ds'),
            'ch' => $request->get('ch'),
            'cp' => $request->get('cp'),
            'nm' => $request->get('nm'),
            'vd' => $request->get('vd'),
            'ar' => $request->get('ar'),
            'pr' => $request->get('pr'),
            'st' => $request->get('st'),
            'f1' => $request->get('f1'),
            'f2' => $request->get('f2'),
            'f3' => $request->get('f3'),
            'f4' => $request->get('f4'),
            'f5' => $request->get('f5'),

        ]);*/

        $selectors = Nodes::find($request->get('node_id'))->Selectors;

        return view('selector.show', [
            'selectors' => $selectors
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $selectors = Selectors::where('fid_id_node', $id)->get();
         // dd(count($selectors));
        return view('selector.show', [
            'selectors' => $selectors
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
        $selector = Selectors::find($id);
        return view('selector.edit', [
            'selector' => $selector
        ]);
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
        $selector = Selectors::findOrFail($id);
        $selector->fill($request->all());
        //dd($request);
        //$selector->save();
        //dd($selector);
        if (!$selector->save()) {
            return redirect()->back()->withErrors('Update Error');
        }
        $request->session()->flash('flash massage', 'selector updated');
        return $this->show($selector->fid_id_node);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Selector = Selectors::find($id);
        $id_node=$Selector->fid_id_node;
        $Selector->delete();
        $selectors = Selectors::where('fid_id_node',$id_node)->get();
        return view('selector.show', [
            'selectors' => $selectors
        ]);
    }
}

