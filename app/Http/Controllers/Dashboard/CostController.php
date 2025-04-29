<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TheYears;

class CostController extends Controller
{
    
    public function index()
    {
        $the_years = TheYears::select('TheYear')->distinct()->get();
        return view('back.cost.index', compact('the_years'));
    }

    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }

    public function get_mat_after_change_years($id, $section_id)
    {
        $mats = TheYears::select('TheMat', 'ID')->where('TheYear', $id)->get();
        return response()->json($mats);
    }
}
