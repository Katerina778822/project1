<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nodes;
use App\Models\Selectors;
use App\Http\Controllers\SelectorController;
use App\Models\Catalogs;
use App\Models\Goods;
use Exception;

class NodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nodes = Nodes::all();

        return view('node.index', ['nodes' => $nodes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('node.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        try {
            $node = Nodes::create([
                'name' => $request->get('nodename'),
                'url' => $request->get('url'),
                'node_paginat_pattern' => $request->get('node_paginat_pattern'),
                'login' => $request->get('login')??null,
                'pass' => $request->get('pass')??null,
            ]);
        } catch (Exception $e) {
            $e->getMessage();
        }
        if (!$node) {
            return die("Error store Node " . $request->get('name'));
        }
        if (!empty($request->get('b1'))) {
            $selector = Selectors::create([
                'name' => 'b1',
                'value' => $request->get('b1'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('b1'));
        }
        if (!empty($request->get('b2'))) {
            $selector = Selectors::create([
                'name' => 'b2',
                'value' => $request->get('b2'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('b2'));
        }

        if (!empty($request->get('gd'))) {
            $selector = Selectors::create([
                'name' => 'gd',
                'value' => $request->get('gd'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('gd'));
        }

        if (!empty($request->get('b3'))) {
            $selector = Selectors::create([
                'name' => 'b3',
                'value' => $request->get('b3'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('b3'));
        }

        if (!empty($request->get('im'))) {
            $selector = Selectors::create([
                'name' => 'im',
                'value' => $request->get('im'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('im'));
        }
        if (!empty($request->get('vd'))) {
            $selector = Selectors::create([
                'name' => 'vd',
                'value' => $request->get('vd'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('vd'));
        }

        if (!empty($request->get('ds'))) {
            $selector = Selectors::create([
                'name' => 'ds',
                'value' => $request->get('ds'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('ds'));
        }

        if (!empty($request->get('ch'))) {
            $selector = Selectors::create([
                'name' => 'ch',
                'value' => $request->get('ch'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('ch'));
        }

        if (!empty($request->get('cp'))) {
            $selector = Selectors::create([
                'name' => 'cp',
                'value' => $request->get('cp'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('cp'));
        }

        if (!empty($request->get('nm'))) {
            $selector = Selectors::create([
                'name' => 'nm',
                'value' => $request->get('nm'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('nm'));
        }

        if (!empty($request->get('ar'))) {
            $selector = Selectors::create([
                'name' => 'ar',
                'value' => $request->get('ar'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('ar'));
        }

        if (!empty($request->get('pr'))) {
            $selector = Selectors::create([
                'name' => 'pr',
                'value' => $request->get('pr'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('pr'));
        }

        if (!empty($request->get('st'))) {
            $selector = Selectors::create([
                'name' => 'st',
                'value' => $request->get('st'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('st'));
        }

        if (!empty($request->get('f1'))) {
            $selector = Selectors::create([
                'name' => 'f1',
                'value' => $request->get('f1'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('f1'));
        }

        if (!empty($request->get('f2'))) {
            $selector = Selectors::create([
                'name' => 'f2',
                'value' => $request->get('f2'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('f2'));
        }

        if (!empty($request->get('f3'))) {
            $selector = Selectors::create([
                'name' => 'f3',
                'value' => $request->get('f3'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('f3'));
        }
        if (!empty($request->get('f4'))) {
            $selector = Selectors::create([
                'name' => 'f4',
                'value' => $request->get('f4'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('f4'));
        }

        if (!empty($request->get('f5'))) {
            $selector = Selectors::create([
                'name' => 'f5',
                'value' => $request->get('f5'),
                'fid_id_node' => $node->id
            ]);
            if (!isset($selector))
                return die("Error store Selector " . $request->get('f5'));
        }

        $request->session()->flash('flash massage', 'Node saved');
        return redirect()->route('node.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $node = Nodes::findOrFail($id);
        return view('node.show', [
            'node' => $node
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
        $node = Nodes::findOrFail($id);
        return view('node.edit', [
            'node' => $node
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
        $node = Nodes::findOrFail($id);
        $node->fill($request->all());
        if (!$node->save()) {
            return redirect()->back()->withErrors('Update Error');
        }
        $request->session()->flash('flash massage', 'node updated');
        return redirect()->route('node.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $node = Nodes::find($id);

        $selectors = $node->Selectors();
        $catalogs = Catalogs::where('fid_id_node', $id)->get();
        foreach ($catalogs as $cats) {
            // dd($catalogs);
            $goods = $cats->Goods();
            $goods->delete();
            $cats->delete();
        }


        if (!empty($selectors))
            $selectors->delete(); //dd($catalogs);

        if (!empty($node))
            $node->delete();

        //   if (!$node->destroy($id)) {
        //      return redirect()->back()->withErrors('Delete Error.(Сначала удалите товары, каталоги и селекторы)');
        // }
        session()->flash('flash massage', 'node updated');
        return redirect()->route('node.index');
    }
}

