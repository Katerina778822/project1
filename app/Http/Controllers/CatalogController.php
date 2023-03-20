<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogs;
use App\Models\Goods;
//use App\Models\Selectors;
use Exception;
//use App\Models\Nodes;
//use DiDom\Document;
use App\Jobs\ParceCatalog;
use Attribute;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, $url = 0, $value = '', $branch_progress_good = 0)
    {
            $url=trim($url);
            $value =trim($value);
            $value =mb_substr($value,0,45);//dd($value);
            $catalogs = Catalogs::create([
                'fid_id_node' => $id,
                'value' => $value,
                'url' => $url,
                'branch_progress_good' => $branch_progress_good,
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
        // dd($id);
        $catalog = Catalogs::where('fid_id_node', $id)->get();
        //dd($catalog);
        return view('catalog.show', [
            'catalogs' => $catalog,
            'id_node' => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_node) //create CATALOG!!
    {
        try {
        $job = new ParceCatalog($id_node);
        $this->dispatch($job);
 /*       $node = Nodes::findOrFail($id_node);
        $selector = Selectors::where('fid_id_node', $id_node)->where('name', 'b1')->first();
        
            if (isset($selector->value)) {
                $document = new Document($node->url, true);
                $posts = $document->find($selector->value);
                $catalog = Catalogs::all();
                $selector2 = Selectors::where('fid_id_node', $id_node)->where('name', 'b2')->first();
                $selector3 = Selectors::where('fid_id_node', $id_node)->where('name', 'b3')->first();
                //dd($posts);
                foreach ($posts as $post) {
                    if (!isset($selector2->value)) // Если b2 селектор установлен, парсим L2
                    {
                        if (!$catalog->where('url', $post->getAttribute('href'))->first()) // check did catalog exist before                  
                            $this->store($id_node, $post->getAttribute('href'), $post->text());
                    } else {
                        $document2 = new Document($post->getAttribute('href'), true);

                        $posts2 = $document2->find($selector2->value);
                        if (!isset($posts2[0])) { //if it is not a catalog L2
                            if (!$catalog->where('url', $post->getAttribute('href'))->first()) // check did catalog exist before                  
                                $this->store($id_node, $post->getAttribute('href'), $post->text());
                            continue;
                        }
                       
                        $catalog = Catalogs::all();
                        foreach ($posts2 as $post2) {
                            if (!isset($selector3->value)) {
                                if (!$catalog->where('url', $post2->getAttribute('href'))->first())
                                    // check is catalog Level3
                                    $this->store($id_node, $post2->getAttribute('href'), $post2->text());
                            } else {
                                $document3 = new Document($post2->getAttribute('href'), true);
                                $posts3 = $document3->find($selector3->value);
                                $catalog = Catalogs::all();
                                foreach ($posts3 as $post3) {
                                    if (!isset($posts3[0])) {
                                        if (!$catalog->where('url', $post3->getAttribute('href'))->first()) //                   
                                            $this->store($id_node, $post3->getAttribute('href'), $post3->text());
                                    }
                                    if (!$catalog->where('url', $post3->getAttribute('href'))->first()) {
                                        $this->store($id_node, $post3->getAttribute('href'), $post3->text());
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $error = 'Selector B1 dont exist. Create?';
                $agreeBtn = '<a  href=' . route('selector.createAll', [$id_node]) . '> No </a>   ';
                $disAgreeBtn = '<a  href=' . route('selector.createAll', [$id_node]) . '> Yes </a>   ';
                $id = '$id';
                return view('partial.errorMessage', compact('error', 'agreeBtn', 'disAgreeBtn', 'id'));
            }*/
        } catch (Exception $e) {

            if ($e::class == 'DiDom\Exceptions\InvalidSelectorException') {
                $error = 'Some Problems with DOM object. Pls check URL and SELECTOR. Ok?';
                $agreeBtn = '<a  href=' . route('selector.createAll', [$id_node]) . '> Yes </a>   ';
                $disAgreeBtn = '<a  href=' . route('node.show', [$id_node]) . '> No </a>   ';
                $id = '$id_node';
            }

            
            $disAgreeBtnurl=route('catalog.show', [$id_node]);           
            $agreeBtnurl=route('selector.createAll',[$id_node]);
            return view('partial.errorMessage', [
                'error'=>$e->getMessage().'Would you create it?',
                'agreeBtn' => '<a class="btn-main" href="'.$agreeBtnurl.'"> Yes   </a>  ',
                'disAgreeBtn' => '<a class="btn-main" href="'.$disAgreeBtnurl.'">  No   </a>  ',
                'id' => '$id_node' 
                ]
        );
    
        }


        return redirect()->route('catalog.show', $id_node);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_node)
    {
        $data = $request->all();
        //dd($data);
        $catalogs = Catalogs::where('fid_id_node', $id_node)->get();
        foreach ($catalogs as $catalog) { //enable  disabled catalog
            if ($catalog->branch_progress_good == -1)
                if (empty($request->input($catalog->id))) {
                    $catalog->branch_progress_good = 0;
                    $catalog->save();
                    // dd($catalog->branch_progress_good);
                }
        }

        foreach ($data as $id_cat => $key) { //disable enadled catalog
            if ($catalog = Catalogs::where('fid_id_node', $id_node)->find($id_cat))
                if ($key == 'on') {
                    $catalog->branch_progress_good = -1;
                    $catalog->save();
                    //dd($catalog->branch_progress_good);
                    $gController = new GoodsController;
                    $gController->destroyAllCatalog($catalog->id);
                }
        }
        $request->session()->flash('flash massage', 'EventTest updated');
        return redirect()->route('catalog.show', [$id_node]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_node) //delete Catalog if empty
    {
        $catalogs = Catalogs::where('fid_id_node', $id_node)->get();
        foreach ($catalogs as $catalog) {
            $goods = Goods::where('fid_id_catalog', $catalog->id)->get();
            if (count($goods) == 0)
                $catalog->delete();
        }

        // dd($catalog);
        return redirect()->route('catalog.show', [$id_node]);
    }
}

