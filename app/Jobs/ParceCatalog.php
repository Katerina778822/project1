<?php

namespace App\Jobs;

//use InvalidArgumentException;
use App\Helpers\Parce;
use App\Http\Controllers\CatalogController;
use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Catalogs;
//use App\Models\Goods;
use App\Models\Selectors;
//use Exception;
use App\Models\Nodes;
use DiDom\Document;
use App\Helpers\CorrectUrl;
use App\Helpers\ParceHelper;

class ParceCatalog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $id_node;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id_node)
    {
        $this->id_node = $id_node;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $node = Nodes::findOrFail($this->id_node);
        $selector = Selectors::where('fid_id_node', $this->id_node)->where('name', 'b1')->first();
        $res = $this->ParceCatalog($node->url, 'b', 1, $this->id_node);
    }

    private function ParceCatalog($url, $selector_literal, int $recursion, $id_node)
    {

        //$document = ParceHelper::getDocument($url, $id_node);
           $url=CorrectUrl::Handle($url,$id_node);//check and correct url before loading
             $document = new Document($url, true);

        if (empty($document))
            return 0; //if document didnt load
        $selector = Selectors::where('fid_id_node', $id_node)->where('name', $selector_literal . $recursion)->first();
        if (empty($selector->value)) {
            // throw new Exception("Empty Selector ".$selector_literal . $recursion);
            return 0; //if selector doesnt exist
        }
        $res = 0; //sublevels count
        $posts = ParceHelper::findCssOrXpath($document, $selector->value);
        /*  if (empty($posts[0])) {
             throw new Exception("Empty Selector ".$selector_literal . $recursion);
        }*/
        foreach ($posts as $post) {
            $selector_NEXT = Selectors::where('fid_id_node', $id_node)->where('name', $selector_literal . $recursion + 1)->first();
            $resSub = 0;
            if (!empty($selector_NEXT->value)) //if selector of deeper level doesnt exist - go further
                $resSub = $this->ParceCatalog($post->getAttribute('href'), 'b', $recursion + 1, $id_node); //try parcing deeper level catalog
            if ($resSub)
                continue; //if sublevel contains goods dont store this CATALOG
            $catalog = Catalogs::where('url', CorrectUrl::Handle($post->getAttribute('href'), $id_node))->first();
            if (empty($catalog)) { //store catalog if it doesnt exist yet
                 $catalogContrl = new CatalogController;
                $catalog_url = CorrectUrl::Handle($post->getAttribute('href'), $id_node); //check and correct url before storing

                $catalogContrl->store($id_node, $catalog_url, $post->text());
            }
            $res++;
        }
        return $res;
    }
}
