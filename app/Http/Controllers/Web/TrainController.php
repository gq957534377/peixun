<?php

namespace App\Http\Controllers\Web;

use App\Exports\TrainsExport;
use App\Imports\TrainsImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class TrainController extends Controller
{
    public function index()
    {
        return Excel::download(new TrainsExport(), 'users.xlsx');
    }
    public function show($id,Request $request)
    {
        $res=Excel::import(new TrainsImport(),'/test.xlsx');
dd($res);
//        return redirect('/')->with('success', 'All good!');
    }
}
