<?php

namespace App\Jobs;

use App\Http\Controllers\GoodsController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Selectors;
use Exception;
use DiDom\Document;
use App\Models\Catalogs;
use App\Models\Nodes;
use App\Models\Goods;
use App\Helpers\CorrectUrl;
use App\Helpers\ParceHelper;
use DiDom\Query;

class ParseGoods implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id_catalog;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function handle()
    {
        $catalog = Catalogs::findOrFail($this->id_catalog);
        $node_id = $catalog->fid_id_node;
        $node = Nodes::find($node_id);
        $i = 1;
        do { //pagination cycle
            $selector = Selectors::where('fid_id_node', $node_id)->where('name', 'gd')->first();
            if (!empty($selector->value)) {
                $page = $node->GetXPaginat($i);
                if ($page === false)
                    throw new Exception('Check pagination pattern! Should contain "x"-symbol!');
                $document = new Document($catalog->url . $page, true); //dd($document);
                $posts = ParceHelper::findCssOrXpath($document, $selector->value);
                if (!empty($posts)) { //dd($posts[3]);
                    // $goods = Goods::all();
                    foreach ($posts as $post) {
                        $goodUrl = $post->getAttribute('href');
                        if (!empty($goodUrl))
                            $goodUrl = CorrectUrl::Handle($goodUrl, $node_id);
                        else throw new Exception('Wrong good URL! Check gd SELECTOR.  '); //if incorrect url of the good
                        $storedGood = Goods::where('url', $goodUrl)->first();
                        if (empty($storedGood)) { //if goods isnt before
                            $documentGood = new Document($goodUrl, true); //create goods details
                            // if (1) {                            
                            $goodArr['url'] = $goodUrl;

                            //Find fotos urls
                            $goodArr['fotos'] = '';
                            $selectorGood = Selectors::where('fid_id_node', $node_id)->where('name', 'im')->first();
                            if (!empty($selectorGood)) {
                                $postsGoods = ParceHelper::findCssOrXpath($documentGood, $selectorGood->value);
                                if (!empty($postsGoods)) {
                                    foreach ($postsGoods as $postsGood) {
                                        $str = $postsGood->getAttribute('href');
                                        if (empty($str)) {
                                            $str = $postsGood->getAttribute('src');
                                        }
                                        // $str = substr($str, 1 - strlen($str));
                                        if(!empty($str)){
                                            $str = CorrectUrl::Handle($str, $node_id);
                                            $goodArr['fotos'] = $goodArr['fotos'] .  $str . ',';
                                        }
                                       
                                    }
                                }
                            }
                            //store
                            $selectorGood = Selectors::where('fid_id_node', $node_id)->where('name', 'st')->first();
                            $goodArr['store'] = "";
                            if (!empty($selectorGood)) {
                                $postsGoods = ParceHelper::findCssOrXpath($documentGood, $selectorGood->value);
                                if (!empty($postsGoods)) {
                                    $goodArr['store'] = $postsGoods[0]->text();
                                    if (empty($goodArr['store'])) {
                                        $goodArr['store'] = $postsGoods[0]->getAttribute('value');
                                    }
                                }
                            }
                            //description
                            $selectorGood = Selectors::where('fid_id_node', $node_id)->where('name', 'ds')->first();
                            $goodArr['descripttxt'] = "";
                            $goodArr['descripthtml'] = "";
                            if (!empty($selectorGood)) {
                                $postsGoods = ParceHelper::findCssOrXpath($documentGood, $selectorGood->value);
                                if (!empty($postsGoods)) {
                                    foreach ($postsGoods as $postsGood) {
                                        if (!empty($goodArr['descripttxt'])) {
                                            $str = $goodArr['descripttxt'];
                                            $goodArr['descripttxt'] = $str . $postsGood->text() . "\r\n";
                                        } else {
                                            $goodArr['descripttxt'] = $postsGood->text() . "\r\n";
                                        }

                                        $goodArr['descripthtml'] = $goodArr['descripthtml'] . $postsGood->html() . "\r\n";
                                    }
                                }
                            }
                            //art
                            $selectorGood = Selectors::where('fid_id_node', $node_id)->where('name', 'ar')->first();
                            $goodArr['art'] = "";
                            if (!empty($selectorGood)) {
                                $postsGoods = ParceHelper::findCssOrXpath($documentGood, $selectorGood->value);
                                // $postsGoods = $documentGood->find($selectorGood->value,Query::TYPE_XPATH);
                               //     dd($postsGoods); 
                                if (!empty($postsGoods))
                                    $goodArr['art'] = $postsGoods[0]->text();
                                //    dd( $goodArr['art']);             
                            }
                            //charact
                            $selectorGood = Selectors::where('fid_id_node', $node_id)->where('name', 'ch')->first();
                            $goodArr['charact'] = "";
                            if (!empty($selectorGood)) {
                                $postsGoods = ParceHelper::findCssOrXpath($documentGood, $selectorGood->value);
                                if (!empty($postsGoods))
                                    $goodArr['charact'] = $postsGoods[0]->html();
                            }
                            //name
                            $selectorGood = Selectors::where('fid_id_node', $node_id)->where('name', 'nm')->first();
                            $goodArr['name'] = "";
                            if (!empty($selectorGood)) {
                                $postsGoods = ParceHelper::findCssOrXpath($documentGood, $selectorGood->value);
                                if (!empty($postsGoods))
                                    $goodArr['name'] = $postsGoods[0]->text();
                            }

                            //price
                            $selectorGood = Selectors::where('fid_id_node', $node_id)->where('name', 'pr')->first();
                            $goodArr['price'] = null;
                            if (!empty($selectorGood)) {
                                $postsGoods = ParceHelper::findCssOrXpath($documentGood, $selectorGood->value);
                           //      dd($postsGoods); 
                                if (!empty($postsGoods)) {
                                    $goodArr['price'] = $postsGoods[0]->text();
                               //     dd($postsGoods[0]);
                                }
                            }
                            //videos
                            $goodArr['videos'] = '';
                            $selectorGood = Selectors::where('fid_id_node', $node_id)->where('name', 'vd')->first();
                            if (!empty($selectorGood)) {
                                $postsGoods = ParceHelper::findCssOrXpath($documentGood, $selectorGood->value);

                                if (!empty($postsGoods)) {
                                    foreach ($postsGoods as $postsGood) {
                                        $str = $postsGood->getAttribute('href');
                                        $str = substr($str, 1 - strlen($str));
                                        $str = $node->url . $str;
                                        $goodArr['videos'] = $goodArr['videos']  . $str . ',';
                                    }
                                }
                            }
                            //complect
                            $selectorGood = Selectors::where('fid_id_node', $node_id)->where('name', 'cp')->first();
                            $goodArr['complect'] = "";
                            if (!empty($selectorGood)) {
                                $postsGoods = ParceHelper::findCssOrXpath($documentGood, $selectorGood->value);
                                if (!empty($postsGoods))
                                    $goodArr['complect'] = $postsGoods[0]->html();
                            }
                            //dd($goodArr['price']);
                            //f1
                            $selectorGood = Selectors::where('fid_id_node', $node_id)->where('name', 'f1')->first();
                            $goodArr['f1'] = "";
                            if (!empty($selectorGood)) {
                                $postsGoods = ParceHelper::findCssOrXpath($documentGood, $selectorGood->value);
                                if (!empty($postsGoods))
                                    $goodArr['f1'] = $postsGoods[0]->text();
                            }
                            //f2
                            $selectorGood = Selectors::where('fid_id_node', $node_id)->where('name', 'f2')->first();
                            $goodArr['f2'] = "";
                            if (!empty($selectorGood)) {
                                $postsGoods = ParceHelper::findCssOrXpath($documentGood, $selectorGood->value);
                                if (!empty($postsGoods))
                                    $goodArr['f2'] = $postsGoods[0]->text();
                            }
                            //f3
                            $selectorGood = Selectors::where('fid_id_node', $node_id)->where('name', 'f3')->first();
                            $goodArr['f3'] = "";
                            if (!empty($selectorGood)) {
                                $postsGoods = ParceHelper::findCssOrXpath($documentGood, $selectorGood->value);

                                if (!empty($postsGoods))
                                    $goodArr['f3'] = $postsGoods[0]->text();
                            }
                            //f4
                            $selectorGood = Selectors::where('fid_id_node', $node_id)->where('name', 'f4')->first();
                            $goodArr['f4'] = "";
                            if (!empty($selectorGood)) {
                                $postsGoods = ParceHelper::findCssOrXpath($documentGood, $selectorGood->value);
                                if (!empty($postsGoods)) {
                                    $goodArr['f4'] = $postsGoods[0]->text();
                                }
                            }
                            //f5
                            $selectorGood = Selectors::where('fid_id_node', $node_id)->where('name', 'f5')->first();
                            $goodArr['f5'] = "";
                            if (!empty($selectorGood)) {
                                $postsGoods = ParceHelper::findCssOrXpath($documentGood, $selectorGood->value);
                                if (!empty($postsGoods))
                                    $goodArr['f5'] = $postsGoods[0]->text();
                            }
                            //  }

                            // $goodArr['art'] = "Some art"; //delete
                            // $goodArr['name'] = "Some name"; //delete
                            $goodArr['fid_id_catalog'] = $this->id_catalog;
                            // dd($goodArr);
                            $gController = new GoodsController; //dd($goodArr);
                            $gController->store($goodArr);

                            //redirect()->route('goods.show', $this->id_catalog);
                        }
                    }
                } else {
                    return redirect()->route('goods.show', $this->id_catalog);
                }
            }

            $i++;
        } while (!empty($posts) && $page != "");
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id_catalog = $id;
    }
}

