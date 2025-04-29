<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\AnswersToPollsQuestions;
use App\Models\PollsQuestions;
use App\Models\PollUsersHrTeachers;
use App\Models\PollUsersToTeachersOnly;
use Carbon\Carbon;

class AnswersToPollsQuestionsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
           'question' => 'required',
           'answer.*' => 'required',
           'percentage.*' => 'required',
        ],[
            'required' => 'هذا الحقل ( :attribute ) إلزامي.',
        ],[
            'question' => 'السؤال',
            'answer' => 'الإجابة',
            'percentage' => 'النسبة المئوية',
        ]);

        
        $questionId = explode('_', request('question'))[0];
        $questionValue = explode('_', request('question'))[1];

        for($i = 0; $i < count(request('answer')); $i++){
            
            $data[] = [
                'question' => $questionId,
                'answer' => json_encode(request('answer')[$i]),
                'value' => request('answer_value')[$i],
                'percentage' => ( (request('answer_value')[$i] / 100) * $questionValue ),
                'status' => request('status')[$i]
            ];

        }

        AnswersToPollsQuestions::insert($data);
    }

    public function edit($id){
        $find = AnswersToPollsQuestions::where('id', $id)->first();        
        return response()->json($find);
    }

    public function show_answers($id){
        $find = AnswersToPollsQuestions::where('question', $id)->get();
        return response()->json($find);
    }

    public function update_answer(Request $request, $id){
        AnswersToPollsQuestions::where('id', $id)->update([
            'answer' => json_encode(request('answer')),
            'value' => request('answer_value'),
            'percentage' => (request('answer_value') / 100) * request('questionPercentage'),
            'status' => request('status'),
        ]);

        PollUsersHrTeachers::where('answer', $id)->update([
            'total' => (request('answer_value') / 100) * request('questionPercentage')
        ]);
        
        PollUsersToTeachersOnly::where('answer', $id)->update([
            'total' => (request('answer_value') / 100) * request('questionPercentage')
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'question' => 'required',
        ],[
            'required' => 'هذا الحقل ( :attribute ) إلزامي.',
        ],[
            'question' => 'السؤال',
        ]);

        AnswersToPollsQuestions::where('id', $id)->update(request()->except(['_token', 'res_id']));
   }

    public function datatable(){
        $all = AnswersToPollsQuestions::leftJoin('polls_questions', 'polls_questions.id', 'answers_to_polls_questions.question')
                                        ->leftJoin('polls_groups', 'polls_groups.id', 'polls_questions.group')
                                        ->select(
                                            'polls_questions.question as question_title', 'polls_questions.id as question_id', 'polls_questions.percentage as question_percentage', 
                                            'polls_groups.title as group_title', 'polls_groups.id as group_id', 
                                            'answers_to_polls_questions.question')
                                        ->groupBy('answers_to_polls_questions.question')
                                        ->get();
        // dd($all);
        return DataTables::of($all)
        ->addColumn('group', function($d){
            return  "<span>م_".$d->group_id."</span> <span style='margin: 0 10px;'>".$d->group_title."</span>";
        })
        ->addColumn('question', function($d){
            return '<span class="show_answers" res_id="'.$d->question_id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.json_decode($d->question_title).'" questionPercentage="'.$d->question_percentage.'" data-toggle="modal" data-target="#answersModal" style="cursor: pointer;">'.nl2br(e(json_decode($d->question_title))).'</span>';
        })
        ->rawColumns(['group', 'question'])
        ->make(true);
    }
}
