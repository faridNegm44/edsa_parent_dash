<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PollsGroups;
use App\Models\PollsQuestions;
use App\Models\AnswersToPollsQuestions;
use App\Models\PollUsersToTeachersOnly;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PollsTeachersReportController extends Controller
{
    
    ////////////////////////////////////////////////////// start report تقرير استبيان جروبات المدرسين //////////////////////////////////////////////////////
        public function report_groups_get(){
            $nameAr = 'تقرير استبيان جروبات المدرسين';
            $groups_hr = PollsGroups::where('special', 'teachers')->get();
            
            return view('back.polls_reports.reports_teachers.groups.index', compact('nameAr', 'groups_hr'));
        }

        public function report_groups_post(Request $request){
            $get_polls_users_to_teachers = PollUsersToTeachersOnly::where('group_id', request('poll_hr_group'))
                                    ->leftJoin('users', 'poll_users_to_teachers_only.user_id', 'users.id')
                                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'poll_users_to_teachers_only.teacher_id')
                                    ->leftJoin('polls_groups', 'poll_users_to_teachers_only.group_id', 'polls_groups.id')
                                    ->leftJoin('polls_questions', 'polls_questions.id', 'poll_users_to_teachers_only.question_id')
                                    ->leftJoin('answers_to_polls_questions', 'answers_to_polls_questions.id', 'poll_users_to_teachers_only.answer')


                                    ->select(
                                        'users.name as user_name', 
                                        'tbl_teachers.ID as teacher_id', 'tbl_teachers.TheName as teacher_name',
                                        'polls_groups.title as group_name', 
                                        'polls_questions.question as question_title', 'polls_questions.type as question_type', 'polls_questions.percentage as question_percentage', 
                                        'poll_users_to_teachers_only.*', 
                                        'answers_to_polls_questions.percentage as answer_percentage', 'answers_to_polls_questions.answer as answer_title'
                                    )

                                    ->orderBy('group_id', 'DESC')
                                    ->orderBy('created_at', 'DESC')
                                    ->orderBy('tbl_teachers.ID', 'DESC')

                                    ->get();
                                                                                        
                                    //dd($get_polls_users_to_teachers);
                                    
        
            if(count($get_polls_users_to_teachers) > 0){

                $total_question_percentage = $get_polls_users_to_teachers->sum('question_percentage'); 
                $sumTotal = $get_polls_users_to_teachers->sum('answer_percentage'); 
                $calcPercentageTotalAnswerFromTotalQuestion = ($sumTotal/$total_question_percentage) * 100; 
    
                $count_users_polling_teachers = PollUsersToTeachersOnly::where('group_id', request('poll_hr_group'))->groupBy('user_id')->get();
                $count_questions = PollsQuestions::where('group', request('poll_hr_group'))->count();
    
                
                $nameAr = 'تقرير استبيان جروبات المدرسين'.' - '.$get_polls_users_to_teachers[0]->group_name;

                return view('back.polls_reports.reports_teachers.groups.pdf', compact('nameAr', 'get_polls_users_to_teachers', 'total_question_percentage', 'count_users_polling_teachers', 'count_questions', 'sumTotal', 'calcPercentageTotalAnswerFromTotalQuestion'));
            }else{
                return redirect()->back()->withInput()->with('message', 'لاتوجد استبيانات تمت لهذة المجموعة في الوقت الحالي');
            }
            

        }
    ////////////////////////////////////////////////////// end report تقرير استبيان جروبات المدرسين //////////////////////////////////////////////////////






    ////////////////////////////////////////////////////// start report تقرير استبيان لمدرس //////////////////////////////////////////////////////
        public function report_teachers_get(){
            $nameAr = 'تقرير استبيان لمدرس';
            $teachers = DB::table('tbl_teachers')->orderBy('TheName', 'ASC')->get();
            
            return view('back.polls_reports.reports_teachers.teacher.index', compact('nameAr', 'teachers'));
        }

        public function report_teacher_post(Request $request){
            $get_polls_users_to_teachers = PollUsersToTeachersOnly::where('teacher_id', request('poll_teacher_id'))
                                    ->leftJoin('users', 'poll_users_to_teachers_only.user_id', 'users.id')
                                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'poll_users_to_teachers_only.teacher_id')
                                    ->leftJoin('polls_groups', 'poll_users_to_teachers_only.group_id', 'polls_groups.id')
                                    ->leftJoin('polls_questions', 'polls_questions.id', 'poll_users_to_teachers_only.question_id')
                                    ->leftJoin('answers_to_polls_questions', 'answers_to_polls_questions.id', 'poll_users_to_teachers_only.answer')


                                    ->select(
                                        'users.name as user_name', 
                                        'tbl_teachers.ID as teacher_id', 'tbl_teachers.TheName as teacher_name',
                                        'polls_groups.title as group_name', 
                                        'polls_questions.question as question_title', 'polls_questions.type as question_type', 'polls_questions.percentage as question_percentage', 
                                        'poll_users_to_teachers_only.*', 
                                        'answers_to_polls_questions.percentage as answer_percentage', 'answers_to_polls_questions.answer as answer_title'
                                    )

                                    ->orderBy('group_id', 'DESC')
                                    ->orderBy('created_at', 'DESC')
                                    ->orderBy('tbl_teachers.ID', 'DESC')

                                    ->get();
                                                                                        
                                    // dd($get_polls_users_to_teachers);
                                
                                    
                                    
            if(count($get_polls_users_to_teachers) > 0){

                $total_question_percentage = $get_polls_users_to_teachers->sum('question_percentage'); 
                $sumTotal = $get_polls_users_to_teachers->sum('answer_percentage'); 
                $calcPercentageTotalAnswerFromTotalQuestion = ($sumTotal/$total_question_percentage) * 100; 
    
                $count_users_polling_teachers = PollUsersToTeachersOnly::where('teacher_id', request('poll_teacher_id'))->groupBy('user_id')->get();
                $count_questions = PollsQuestions::where('group', request('poll_teacher_id'))->count();
    
                
                $nameAr = 'تقرير استبيان لمدرس'.' - '.$get_polls_users_to_teachers[0]->teacher_name;         

                return view('back.polls_reports.reports_teachers.teacher.pdf', compact('nameAr', 'get_polls_users_to_teachers', 'total_question_percentage', 'count_users_polling_teachers', 'count_questions', 'sumTotal', 'calcPercentageTotalAnswerFromTotalQuestion'));
            }else{
                return redirect()->back()->withInput()->with('message', 'لاتوجد استبيانات تمت لهذا المدرس في الوقت الحالي');
            }
            

        }
    ////////////////////////////////////////////////////// end report تقرير استبيان لمدرس //////////////////////////////////////////////////////












    //////////////////////////////////////// start report parent with group تقرير استبيان لولي أمر يخص جروبات المدرسين ///////////////////////////////////
        public function reportParentWithGroupGet(){
            $nameAr = 'تقرير استبيان لولي أمر يخص جروبات المدرسين';
            $parents = DB::table('tbl_parents')->get();

            return view('back.polls_reports.reports_teachers.parentWithGroup.index', compact('nameAr', 'parents'));
        }

        public function reportParentWithGroupPost(Request $request){
            $get_polls_users_to_hr = PollUsersToTeachersOnly::where('user_id', request('parent_id'))
                                    ->leftJoin('users', 'poll_users_to_teachers_only.user_id', 'users.id')
                                    ->leftJoin('polls_groups',  'polls_groups.id', 'poll_users_to_teachers_only.group_id' )                                                        
                                    ->leftJoin('answers_to_polls_questions', 'answers_to_polls_questions.id', 'poll_users_to_teachers_only.answer')
                                    ->leftJoin('polls_questions', 'polls_questions.id', 'poll_users_to_teachers_only.question_id')
                                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'poll_users_to_teachers_only.teacher_id')
                                    
                                    ->select(
                                        'users.name as user_name', 
                                        'polls_groups.title as group_name', 
                                        'polls_questions.question as question_title', 'polls_questions.type as question_type', 'polls_questions.percentage as question_percentage', 
                                        'answers_to_polls_questions.percentage as answer_percentage', 'answers_to_polls_questions.answer as answer_title',
                                        'poll_users_to_teachers_only.*',
                                        'tbl_teachers.TheName as teacher_name'
                                    )
                                    ->orderBy('created_at', 'DESC')
                                    ->get();
                                            
                                    // dd($get_polls_users_to_hr);
                                    
            if(count($get_polls_users_to_hr) > 0){
                $count_users_polling_hr = PollUsersToTeachersOnly::where('question_id', request('poll_hr_question'))->count();             
                
                $sumQuestionPercentage = PollUsersToTeachersOnly::where('user_id', request('parent_id'))
                                                            ->leftJoin('polls_questions', 'polls_questions.id', 'poll_users_to_teachers_only.question_id')
                                                            ->sum('polls_questions.percentage'); 

                $sumAnswersPercentage = PollUsersToTeachersOnly::where('user_id', request('parent_id'))->sum('total');
                

                if($get_polls_users_to_hr[0]['question_type'] != 'radio'){
                    $sumTotal = 0;
                }else{
                    $sumTotal = ( ((double)$sumAnswersPercentage) / ((double)$sumQuestionPercentage) ) * 100; 
                }

                $parent = $get_polls_users_to_hr[0]->user_name;
                
                return view('back.polls_reports.reports_teachers.parentWithGroup.pdf', compact('parent', 'count_users_polling_hr', 'get_polls_users_to_hr', 'sumTotal'));
            }else{
                return redirect()->back()->withInput()->with('message', 'لاتوجد استبيانات تمت لولي الأمر في الوقت الحالي');
            }
        }
    //////////////////////////////////////// end report question with group تقرير استبيان لولي أمر يخص جروبات المدرسين /////////////////////////////////////



}
