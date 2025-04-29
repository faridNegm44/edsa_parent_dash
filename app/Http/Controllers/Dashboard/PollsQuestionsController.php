<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PollsQuestions;
use Carbon\Carbon;

class PollsQuestionsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'group' => 'required',
            'type' => 'required',
            'percentage' => 'required',
        ],[
            'required' => 'هذا الحقل ( :attribute ) إلزامي.',
        ],[
            'question' => 'السؤال',
            'group' => 'المجموعة',
            'type' => 'نوع السؤال',
            'percentage' => 'النسبة المئوية',
        ]);
        
        $data = request()->except(['_token', 'res_id']);
        $data['question'] = json_encode(request('question'));
        $data['percentage'] = request('type') != 'radio' ? null : request('percentage');
        PollsQuestions::create($data);
    }

    public function edit($id){
        $find = PollsQuestions::where('id', $id)->first();        
        return response()->json($find);
    }

    public function update(Request $request, $id){
        $request->validate([
            'question' => 'required',
            'group' => 'required',
            'type' => 'required',
            'percentage' => request('type') != 'textarea' ? 'required' : 'nullable',
        ],[
            'required' => 'هذا الحقل ( :attribute ) إلزامي.',
        ],[
            'question' => 'السؤال',
            'group' => 'المجموعة',
            'type' => 'نوع السؤال',
            'percentage' => 'النسبة المئوية',
        ]);

        $data = request()->except(['_token', 'res_id']);
        $data['question'] = json_encode(request('question'));
        $data['percentage'] = request('type') != 'radio' ? 0 : request('percentage');
        
        PollsQuestions::where('id', $id)->update($data);
   }

    public function datatable(){
        $all = PollsQuestions::all();

        return DataTables::of($all)
        ->addColumn('id', function($d){
            return $d->id;
        })
        ->addColumn('group', function($d){
            return '
                    <span style="font-weight: bold;margin-left: 10px">(م_'.$d->PollsQuestionsRelPollsGroups['id'].' )</span>  
                    <span style="font-weight: bold;" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$d->question.'">'.$d->PollsQuestionsRelPollsGroups['title'].'</span>';
        })
        ->addColumn('type', function($d){
            if($d->type == 'checkbox'){
                return '<div class="bg bg-warning text-white p-1">اختيار من متعدد</div>';
            }else if($d->type == 'radio'){
                return '<div class="bg bg-primary text-white p-1">اختيار إجابة واحدة</div>';
            }else if($d->type == 'textarea'){
                return '<div class="bg bg-success text-white p-1">سؤال مقالي</div>';
            }else if($d->type == 'date'){
                return '<div class="bg bg-danger text-white p-1">تاريخ</div>';
            }
        })
        ->addColumn('question', function($d){
            return "<span style='width: 40% !important;'>".nl2br(json_decode($d->question))."</span>";
        })
        ->addColumn('percentage', function($d){
            return "<bold style='font-size: 18px;'>".$d->percentage."</bold>";
        })
        ->addColumn('status', function($d){
            if($d->status == 0){
                return '<span class="badge badge-danger">غير نشط</span>';
            }elseif($d->status == 1){
                return '<span class="badge badge-success">نشط</span>';
            }
        })
        ->addColumn('action', function($d){
            return '<a res_id="'.$d->id.'" data-toggle="modal" data-target="#pollsQuestionsModal" class="text-muted option-dots2 modal-effect edit_modal" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';
        })
        ->rawColumns(['id', 'group', 'type', 'question', 'percentage', 'status', 'action'])
        ->make(true);
    }
}