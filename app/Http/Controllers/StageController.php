<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Stage;
use Illuminate\Http\Request;
use function Webmozart\Assert\Tests\StaticAnalysis\string;

class StageController extends Controller
{
    public function stage(){
        return view('home');
    }

    public function create(){
        return view('home');
    }

    public function store(){
        $data = request() ->validate([
            'stage'=>'string'
        ]);
        Stage::create($data);
        return redirect()->route('home');
    }

    public function index(){
        $stages = Stage::all();

        return view('home', ['stages' => $stages]);
    }
}
