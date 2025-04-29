<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PollsGroups;
use App\Models\PollsQuestions;
use App\Models\PollUsersHrTeachers;
use App\Models\PollUsersToTeachersOnly;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PollsGroupsController extends Controller
{
    /////////////////////////////////////////// start polls hr ///////////////////////////////////////////

        public function show(){
            $today = Carbon::now()->toDateString();
            $polls_groups = PollsGroups::whereDate('from', '<=', $today)
                                        ->whereDate('to', '>=', $today)
                                        ->where('status', 1)
                                        ->get();
                                    
            if(isset($polls_groups[0])){
                $questions = PollsQuestions::where('group', $polls_groups[0]->id)
                                            ->with('answers')
                                            ->where('status', 1)
                                            ->get();
                // dd($questions);
                return view('back.poll_hr', compact('questions', 'polls_groups'));
            }else{
                return redirect('dashboard');
            }
        }
        









        



        public function polls_relation_with_user(){
            $pollRelationWithUser = PollUsersHrTeachers::where('user_id', auth()->user()->id)
                                                        ->leftJoin('users', 'poll_users_hr_teachers.user_id', 'users.id')
                                                        ->get();

            dd($pollRelationWithUser);
        }

    ///////////////////////////////////////////// end polls hr ///////////////////////////////////////////











    ///////////////////////////////////////////// start polls groups section ///////////////////////////////////////////

        public function polls_hr(){
            $nameAr = 'إستبيان الإدارة والمدرسين';
            $nameEn = 'polls_hr';
            $polls_group = PollsGroups::where('status', 1)->get();
            $polls_questions = PollsQuestions::leftJoin('polls_groups', 'polls_groups.id', 'polls_questions.group')
                                                ->select('polls_questions.*', 'polls_groups.title as group_title', 'polls_groups.id as group_id')
                                                ->orderBy('polls_groups.id', 'DESC')
                                                // ->where('polls_questions.status', 1)
                                                ->where('polls_questions.type', 'radio')
                                                // ->groupBy('polls_groups.id')
                                                ->get();
            // dd($polls_questions[0]->group_title);

            if (auth()->user()->user_status == 1 || auth()->user()->user_status == 2) {            
                return view('back.polls_hr.index', compact('nameAr', 'nameEn', 'polls_group', 'polls_questions'));
            }else{
                return redirect()->back();
            }
        }
        


        public function store(Request $request)
        {
            $request->validate([
            'title' => 'required|unique:polls_groups,title',
            'from' => 'required|date',
            'to' => 'required|date',
            'special' => 'required',
            ],[
                'required' => 'هذا الحقل ( :attribute ) إلزامي.',
                'unique' => 'هذا الحقل ( :attribute ) مستخدم من قبل.',
                'date' => 'هذا الحقل ( :attribute ) غير صحيح.',
            ],[
                'title' => 'عنوان المجموعة',
                'from' => 'التاريخ من',
                'to' => 'التاريخ إلي',
                'special' => 'تخصص المجموعة',
            ]);

            PollsGroups::create(request()->all());
        }



        public function edit($id){
            $find = PollsGroups::where('id', $id)->first();        
            return response()->json($find);
        }



        public function update(Request $request, $id){
            $request->validate([
                'title' => 'required|unique:polls_groups,title,'.$id,
                'from' => 'required|date',
                'to' => 'required|date',
                'special' => 'required',
            ],[
                'required' => 'هذا الحقل ( :attribute ) إلزامي.',
                'unique' => 'هذا الحقل ( :attribute ) مستخدم من قبل.',
                'date' => 'هذا الحقل ( :attribute ) غير صحيح.',
            ],[
                'title' => 'عنوان المجموعة',
                'from' => 'التاريخ من',
                'to' => 'التاريخ إلي',
                'special' => 'تخصص المجموعة',
            ]);

            PollsGroups::where('id', $id)->update(request()->except(['_token', 'res_id']));
        }



        public function datatable(){
            $all = PollsGroups::orderBy('id', 'DESC')->get();

            return DataTables::of($all)
            ->addColumn('id', function($d){
                return $d->id;
            })
            ->addColumn('title', function($d){
                $title = $d->title;
                return $title;
            })
            ->addColumn('from', function($d){
                return Carbon::parse($d->from)->format('d-m-Y ( h:i a )');
            })
            ->addColumn('to', function($d){
                return Carbon::parse($d->to)->format('d-m-Y ( h:i a )');
            })
            ->addColumn('special', function($d){
                if($d->special == 'hr'){
                    return '<span class="badge badge-dark">الإدارة</span>';
                }elseif($d->special == 'teachers'){
                    return '<span class="badge badge-light">المدرسين</span>';
                }
            })
            ->addColumn('status', function($d){
                if($d->status == 0){
                    return '<span class="badge badge-danger">غير نشط</span>';
                }elseif($d->status == 1){
                    return '<span class="badge badge-success">نشط</span>';
                }
            })
            ->addColumn('action', function($d){
                return '<a res_id="'.$d->id.'" data-toggle="modal" data-target="#pollsGroupModal" class="text-muted option-dots2 modal-effect edit_modal" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';
            })
            ->rawColumns(['id', 'title', 'from', 'to', 'special', 'status', 'action'])
            ->make(true);
        }

    ///////////////////////////////////////////// end polls groups section ///////////////////////////////////////////
    










    
    ///////////////////////////////////////////// start users answers section ///////////////////////////////////////////

        public function users_answers(){
            $nameAr = 'إجابات إستبيان الإدارة';
            $nameEn = 'users_answers';

            if (auth()->user()->user_status == 1 || auth()->user()->user_status == 2) {            
                return view('back.polls_hr.users_answers', compact('nameAr', 'nameEn'));
            }else{
                return redirect()->back();
            }
        }



        public function users_answers_datatable(){
            $all = PollUsersHrTeachers:: //select('*', DB::raw('GROUP_CONCAT(answer) as answers'))
                                        leftJoin('users', 'poll_users_hr_teachers.user_id', 'users.id')
                                        ->leftJoin('polls_groups', 'poll_users_hr_teachers.group_id', 'polls_groups.id')
                                        ->leftJoin('polls_questions', 'polls_questions.id', 'poll_users_hr_teachers.question')
                                        
                                        ->leftJoin('answers_to_polls_questions', 'answers_to_polls_questions.id', 'poll_users_hr_teachers.answer')


                                        ->select(
                                            'users.name as user_name', 
                                            'polls_groups.title as group_name', 
                                            
                                            'poll_users_hr_teachers.user_id', 'poll_users_hr_teachers.group_id', 'poll_users_hr_teachers.question', 'poll_users_hr_teachers.answer', 'poll_users_hr_teachers.total', 'poll_users_hr_teachers.special', 'poll_users_hr_teachers.created_at', 
                                            
                                            'polls_questions.question as question_title', 'polls_questions.percentage as question_percentage', 'polls_questions.type as question_type', 
                                            
                                            'answers_to_polls_questions.percentage as answer_percentage', 'answers_to_polls_questions.answer as answer_title'
                                        )

                                        ->orderBy('group_id', 'DESC')

                                        ->orderBy('created_at', 'DESC')

                                        ->get();

                                        //return $all;

            return DataTables::of($all)
            ->addColumn('user', function($d){
                return $d->user_name;
            })
            ->addColumn('created_at', function($d){
                return '
                    <div>'.$d->created_at->format('d-m-Y').'</div>
                    <div>'.$d->created_at->format('h:i a').'</div>
                ';

                // return 'crat';

            })
            ->addColumn('group', function($d){
                return $d->group_name;
            })
            ->addColumn('question', function($d){
                return nl2br(json_decode($d->question_title));
            })
            ->addColumn('question_value', function($d){
                if($d->question_type == 'textarea'){
                    return "<b class='bg bg-success p-1'>مقالي</b>";
                }else{
                    return '<p style="font-weight: bold;font-size: 16px;">'.$d->question_percentage.'</p>';
                }
            })
            ->addColumn('answers', function ($d) {
                if($d->question_type == 'textarea'){
                    return $d->answer;
                }else{
                    return json_decode($d->answer_title);
                }

            })
            ->addColumn('answer_value', function ($d) {
                if($d->question_type == 'textarea'){
                    return 0;
                }else{
                    return $d->answer_percentage;
                }
            })
            ->addColumn('answer_value_percentage', function ($d) {
                return '<p style="font-weight: bold;font-size: 16px;">
                        '.($d->answer_percentage / 100) * ($d->question_percentage).'
                    </p>';
            })
            ->rawColumns(['user', 'created_at', 'group', 'question', 'question_value', 'answers', 'answer_value', 'answer_value_percentage'])
            ->make(true);
        }

    ///////////////////////////////////////////// end users answers section ///////////////////////////////////////////
    
    
    
    
    
    
    
    
    
    
    
    ///////////////////////////////////////////// start users answers to teachers section ///////////////////////////////////////////

        public function users_answers_to_teachers(){
            $nameAr = 'إجابات إستبيان المدرسين';
            $nameEn = 'users_answers_to_teachers';

            if (auth()->user()->user_status == 1 || auth()->user()->user_status == 2) {            
                return view('back.polls_hr.users_answers_to_teachers', compact('nameAr', 'nameEn'));
            }else{
                return redirect()->back();
            }
        }



        public function users_answers_to_teachers_datatable(){
            $all = PollUsersToTeachersOnly::leftJoin('users', 'poll_users_to_teachers_only.user_id', 'users.id')
                                        ->leftJoin('polls_groups', 'poll_users_to_teachers_only.group_id', 'polls_groups.id')
                                        ->leftJoin('polls_questions', 'polls_questions.id', 'poll_users_to_teachers_only.question_id')
                                        ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'poll_users_to_teachers_only.teacher_id')
                                        
                                        ->leftJoin('answers_to_polls_questions', 'answers_to_polls_questions.id', 'poll_users_to_teachers_only.answer')


                                        ->select(
                                            'users.name as user_name', 
                                            'tbl_teachers.ID as teacher_id', 'tbl_teachers.TheName as teacher_name',
                                            'polls_groups.title as group_name', 
                                            'polls_questions.question as question_title', 'polls_questions.percentage as question_percentage', 'polls_questions.type as question_type', 
                                            'poll_users_to_teachers_only.*', 
                                            'answers_to_polls_questions.percentage as answer_percentage', 'answers_to_polls_questions.answer as answer_title'
                                        )

                                        ->orderBy('group_id', 'DESC')
                                        ->orderBy('created_at', 'DESC')
                                        ->orderBy('tbl_teachers.ID', 'DESC')

                                        ->get();

                                        // dd($all);

            return DataTables::of($all)
            ->addColumn('user', function($d){
                return $d->user_name;
            })
            ->addColumn('created_at', function($d){
                return '
                    <div>'.$d->created_at->format('d-m-Y').'</div>
                    <div>'.$d->created_at->format('h:i a').'</div>
                ';

                // return 'crat';

            })
            ->addColumn('group', function($d){
                return $d->group_name;
            })
            ->addColumn('teacher', function($d){
                return $d->teacher_name;
            })
            ->addColumn('question', function($d){
                return "<span style='width: 20% !important;'>".nl2br(json_decode($d->question_title))."</span>";
            })
            ->addColumn('question_value', function($d){
                if($d->question_type == 'textarea'){
                    return "<b class='bg bg-success p-1'>مقالي</b>";
                }else{
                    return '<p style="font-weight: bold;font-size: 16px;">'.$d->question_percentage.'</p>';
                }
            })
            ->addColumn('answer_value', function ($d) {
                if($d->question_type == 'radio'){
                    return $d->answer_percentage;
                }else{
                    return 0;
                }

            })
            ->addColumn('answers', function ($d) {
                if($d->question_type == 'radio'){
                    return json_decode($d->answer_title);
                }else{
                    return $d->answer;
                }

            })
            ->addColumn('answer_value_percentage', function ($d) {
                if($d->question_type == 'radio'){
                    return ($d->answer_percentage / $d->question_percentage) * 100;

                }else{
                    return 0;
                }
            })
            ->rawColumns(['user', 'created_at', 'group', 'teacher', 'question', 'question_value', 'answers', 'answer_value', 'answer_value_percentage'])
            ->make(true);
        }

    ///////////////////////////////////////////// end users answers to teachers section ///////////////////////////////////////////

}