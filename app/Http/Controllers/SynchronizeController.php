<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SynchronizeService;

class SynchronizeController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index(Request $request)
    {
    	return view('synchronize');
    }

    public function sync(Request $request)
    {
    	$result = app(SynchronizeService::class)->syncFromApi();

    	return $result ? 
    		response()->json(['success' => true]) :
    		response()->json(['success' => false], 400);
    }
}
