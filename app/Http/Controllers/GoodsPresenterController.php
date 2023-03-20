<?php

namespace App\Http\Controllers;

use App\Models\Catalogs;
use App\Models\Goods;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class GoodsPresenterController extends Controller
{
    public function form(array $arts = null)
    {

        return view('GoodsPresenter.form', [
            'arts' => $arts,
        ]);
    }

    public function formAdd(Request $request)
    {
        $arts = $request->all();
        return view('GoodsPresenter.form', [
            'arts' => $arts,
        ]);
    }

    public function PresentGoods(Request $request)
    {
        $arts = $request->collect();
        unset($arts['_token']);
        $goods = [];
        $logs = [];
        foreach ($arts as $key => $art) {

            if ($art) {
                $good = Goods::where('art', $art)->first();
                if ($good) {
                    $goods[] = $good;
                    $logs[$art] = ' найден';
                   // dd($good->url);
                }
                else
                $logs[$art] = ' не найден';

            }
        }
       
        return view('GoodsPresenter.web', [
            'goods' => $goods,
            'logs' => $logs,
        ]);
    }
}
