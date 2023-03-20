<?php

namespace App\Http\Controllers;

use App\Models\Catalogs;
use Illuminate\Http\Request;
use App\Models\Goods;
use App\Models\Nodes;
use App\Models\Selectors;
use Exception;
use DiDom\Document;
use App\Jobs\ParseGoods;
use DiDom\Node;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use function PHPUnit\Framework\empty;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $goods = Goods::all();
        //  $this->parceCatalog($node,$node->url);
        return view('goods.index', ['goods' => $goods]);
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
    public function store($dataArr) //fid url  art
    {

       // dd($dataArr);
        $dataArr['name']=trim($dataArr['name']);
        $dataArr['url']=trim($dataArr['url']);
        $dataArr['art']=trim($dataArr['art']);
        $dataArr['descripttxt']=trim($dataArr['descripttxt']);
        $dataArr['descripthtml']=trim($dataArr['descripthtml']);
        $dataArr['fotos']=trim($dataArr['fotos']);
        $dataArr['videos']=trim($dataArr['videos']);
        $dataArr['charact']=trim($dataArr['charact']);
        $dataArr['complect']=trim($dataArr['complect']);
        $dataArr['price']=trim($dataArr['price']);
        $dataArr['store']=trim($dataArr['store']);
        $dataArr['f1']=trim($dataArr['f1']);
        $dataArr['f2']=trim($dataArr['f2']);
        $dataArr['f3']=trim($dataArr['f3']);
        $dataArr['f4']=trim($dataArr['f4']);
        $dataArr['f5']=trim($dataArr['f5']);
        $good = Goods::create([
            'fid_id_catalog' => $dataArr['fid_id_catalog'],
            'name' =>  $dataArr['name'],
            'url' => $dataArr['url'],
            'art' => $dataArr['art'],
            'descripttxt' =>  $dataArr['descripttxt'],
            'descripthtml' => $dataArr['descripthtml'],
            'fotos' => $dataArr['fotos'],
            'videos' =>  $dataArr['videos'],
            'charact' => $dataArr['charact'],
            'complect' => $dataArr['complect'],
            'price' =>  $dataArr['price'],
            'store' => $dataArr['store'],
            'f1' => $dataArr['f1'],
            'f2' =>  $dataArr['f2'],
            'f3' => $dataArr['f3'],
            'f4' => $dataArr['f4'],
            'f5' =>  $dataArr['f5'],
        ]);
        //  dd("Hello");
        //  dd($goods);
        return $good;

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $goods = Goods::where('fid_id_catalog', $id)->get();
        //dd($goods);
        $node_id = Catalogs::find($id)->fid_id_node;
        return view('goods.show', [
            'goods' => $goods,
            'id_node' => $node_id,
            'id_catalog' => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($catalog_id)
    {   
        $catalog = Catalogs::find($catalog_id);
        $id_node=$catalog->fid_id_node;
        if ($catalog->branch_progress_good == -1) {
           // echo ('Catalog '.$catalog->value.' is DISABLED! Enable it first.');
            return redirect()->route('catalog.show', [$catalog->fid_id_node]);
        }
        //ParseGoods::dispatch($catalog_id);
        //$process = new Process(['php ' . base_path('artisan') . " queue:listen"]);
        /*  if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }*/
          
        // dd($process);
        try{
        $job = new ParseGoods($catalog_id);
        $this->dispatch($job);
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
     
        return redirect()->route('catalog.show', [$catalog->fid_id_node]);
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
        $Good = Goods::find($id);
        $id_catalog = $Good->fid_id_catalog;
        $Good->delete();
        $node_id = Catalogs::find($id_catalog)->fid_id_node;
        $Goods = Goods::where('fid_id_catalog', $id_catalog)->get();
        return view('goods.show', [
            'goods' => $Goods,
            'id_node' => $node_id
        ]);
    }
    public function showdetails($id)
    {
        $good = Goods::find($id);
        $catalog = Catalogs::find($good->fid_id_catalog);
        $id_node = $catalog->fid_id_node; //dd($good);
        return view('goods.showdetails', [
            'good' => $good,
            'id_node' => $id_node,
        ]);
    }

    public function destroyAllCatalog($id_catalog) //delete all goods  of $id_catalog
    {
        $catalog = Catalogs::find($id_catalog);
        $node_id=$catalog->fid_id_node;
        
        $goods = Goods::where('fid_id_catalog', $id_catalog)->get();
        foreach ($goods as $good) {
            $good->delete();
        }
        return redirect()->route('catalog.show',[$node_id]); 
    }

    public function destroyAllNode($id_node) //delete all goods in all catalogs of $id_node
    {
        $catalogs = Catalogs::where('fid_id_node', $id_node)->get();
        $node_id = $catalogs->first()->fid_id_node;
        foreach ($catalogs as $catalog) {
            $this->destroyAllCatalog($catalog->id);
        }
        return view('catalog.show', [
            'catalogs' => $catalogs,
            'id_node' => $node_id
        ]);
    }
}


