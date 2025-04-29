<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\MatsAndShares;
use App\Models\TheYears;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class MatsAndSharesController extends Controller
{

    public function index()
    {
        return view('back.count_of_shares.index');
    }

    public function create()
    {
        $years = TheYears::select('TheYear')->distinct()->get();
        return view('back.count_of_shares.add', compact('years'));
    }

    public function store(Request $request)
    {
        $request->validate([
           'TheName' => 'required',
           'NatID' => 'required',
           'CityID' => 'required',
           'ThePhone' => 'required',
           'TheEmail' => 'required',
           'TheEduType' => 'required',
           'TheTestType' => 'required',
        ]);

        Student::create([
            'TheDate1' => date('Y-m-d'),
            'ID' => mt_rand(0, 88888888),
            'TheName' => request('TheName'),
            'ParentID' => auth()->user()->id,
            'NatID' => request('NatID'),
            'CityID' => request('CityID'),
            'ThePhone' => request('ThePhone'),
            'TheEmail' => request('TheEmail'),
            'TheEduType' => request('TheEduType'),
            'TheTestType' => request('TheTestType'),
            'TheExplain' => request('TheExplain') == null ? '-' : request('TheExplain'),
            'TheNotes' => request('TheNotes'),
            'TheStatus' => 1,
            'TheStatusDate' => date('Y-m-d'),
        ]);

    }

    public function show(students $students)
    {
        //
    }

    public function edit($id)
    {
        $find = Student::where('id', $id)->first();
        return view('back.student.edit', compact('find'));
    }

    public function update(Request $request, $id)
    {   

        $this->validate($request , [
            'TheName' => 'required',
            'NatID' => 'required',
            'CityID' => 'required',
            'ThePhone' => 'required',
            'TheEmail' => 'required',
            'TheEduType' => 'required',
            'TheTestType' => 'required',
        ]);

        Student::where('ID', $id)->update([
            'TheDate1' => date('Y-m-d'),
            'TheName' => request('TheName'),
            'ParentID' => auth()->user()->id,
            'NatID' => request('NatID'),
            'CityID' => request('CityID'),
            'ThePhone' => request('ThePhone'),
            'TheEmail' => request('TheEmail'),
            'TheEduType' => request('TheEduType'),
            'TheTestType' => request('TheTestType'),
            'TheExplain' => request('TheExplain') == null ? '-' : request('TheExplain'),
            'TheNotes' => request('TheNotes'),
            'TheStatus' => 1,
            'TheStatusDate' => date('Y-m-d'),
        ]);

   }

    public function destroy($id)
    {
        $find = Student::where('ID', $id)->delete();
    }


    public function datatable_count_of_shares()
    {
        $all = MatsAndShares::all();
        return DataTables::of($all)
        ->addColumn('mat', function($d){
            $mat = $d->mat;
            return $mat;
        })
        ->addColumn('year', function($d){
            $year = $d->year;
            return $year;
        })
        ->addColumn('count', function($d){
            $count = $d->count;
            return $count;
        })
        ->addColumn('action', function($d){
            $buttons = '<a res_id="'.$d->ID.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/students/edit/'.$d->ID).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

            $buttons .= '<a res_id="'.$d->ID.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';
            
            return $buttons;
        })
        ->rawColumns(['mat', 'year', 'count', 'action'])
        ->make(true);
    }
}