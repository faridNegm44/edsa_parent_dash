<?php

namespace App\Http\Controllers\Dashboard;

use DB;
use App\Models\ProblemType;
use Illuminate\Http\Request;
use App\Models\ParentProblems;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\Facades\DataTables;

class ProblemTypeController extends Controller
{

    public function index()
    {
        return view('back.problem_type.index');
    }

    public function create()
    {
        return view('back/problem_type/add');
    }

    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required',
        ],[
            'name.required' => 'إسم التصنيف مطلوب',
        ]);

        ProblemType::create([
            'name' => request('name'),
            'rate' => request('rate'),
            'show_to_parent' => request('show_to_parent') == null ? 0 : 1,
        ]);

    }

    public function show()
    {
        //
    }

    public function edit($id)
    {
        $find = ProblemType::where('id', $id)->first();
        return view('back.problem_type.edit', compact('find'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
         ],[
             'name.required' => 'إسم التصنيف مطلوب',
         ]);

         ProblemType::where('id', $id)->update([
            'name' => request('name'),
            'rate' => request('rate'),
            'show_to_parent' => request('show_to_parent') == null ? 0 : 1,
        ]);
   }

    public function destroy($id)
    {
        ParentProblems::where('problem_type', $id)->update(['problem_type' => 1]);
        ProblemType::where('id', $id)->delete();
    }


    public function datatable_problem_types()
    {
        $all = ProblemType::all();
        return DataTables::of($all)
        ->addColumn('name', function($d){
            $name = $d->name;
            return $name;
        })
        ->addColumn('rate', function($d){
            $rate = '';

            if($d->rate == 30){
                $rate = 'سهلة';
            }elseif($d->rate == 40){
                $rate = 'أقل من المتوسط';
            }elseif($d->rate == 50){
                $rate = 'متوسط';
            }elseif($d->rate == 90){
                $rate = 'صعبـة';
            }elseif($d->rate == 100){
                $rate = 'صعبـة جدآ';
            }

            return $rate;
        })
        ->addColumn('show_to_parent', function($d){
            if($d->show_to_parent == 1){
                return '<span class="badge badge-primary"><i class="fa fa-check"></i></span>';
            }else{
                return '';
            }
        })
        ->addColumn('action', function($d){

            if($d->id == 1){
                $buttons = '<a res_id="'.$d->id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/problem_types/edit/'.$d->id).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                return $buttons;
            }else{
                $buttons = '<a res_id="'.$d->id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/problem_types/edit/'.$d->id).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                $buttons .= '<a res_id="'.$d->id.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i
                class="fa fa-trash" style="color: #f35f5f;"></i></a>';

                return $buttons;
            }

        })
        ->rawColumns(['name', 'rate', 'show_to_parent', 'action'])
        ->make(true);
    }
}
