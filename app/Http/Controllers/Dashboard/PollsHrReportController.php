<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PollsGroups;
use App\Models\PollsQuestions;
use App\Models\AnswersToPollsQuestions;
use App\Models\PollUsersHrTeachers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PollsHrReportController extends Controller
{
    
    ////////////////////////////////////////////////////// start report group تقرير استبيان جروبات الإدارة //////////////////////////////////////////////////////
        public function report_groups_get(){
            $nameAr = 'تقرير استبيان جروبات الإدارة';
            $nameEn = 'report_groups';
            $groups_hr = PollsGroups::where('special', 'hr')->get();
            
            return view('back.polls_reports.reports_hr.groups.index', compact('nameAr', 'nameEn', 'groups_hr'));
        }

        public function report_groups_post(Request $request){
            $get_polls_users_to_hr = PollUsersHrTeachers::where('group_id', request('poll_hr_group'))
                                    ->leftJoin('users', 'poll_users_hr_teachers.user_id', 'users.id')
                                    ->leftJoin('polls_groups', 'poll_users_hr_teachers.group_id', 'polls_groups.id')
                                    ->leftJoin('polls_questions', 'polls_questions.id', 'poll_users_hr_teachers.question')
                                    ->leftJoin('answers_to_polls_questions', 'answers_to_polls_questions.id', 'poll_users_hr_teachers.answer')


                                    ->select(
                                        'users.name as user_name', 
                                        'polls_groups.title as group_name', 
                                        'polls_questions.question as question_title', 'polls_questions.type as question_type', 'polls_questions.percentage as question_percentage', 
                                        'poll_users_hr_teachers.*', 
                                        'answers_to_polls_questions.percentage as answer_percentage', 'answers_to_polls_questions.answer as answer_title'
                                    )

                                    ->orderBy('group_id', 'DESC')

                                    ->orderBy('created_at', 'DESC')

                                    ->get();
                                                                                        
                                    //dd($get_polls_users_to_hr);
                                    
                                        
            if(count($get_polls_users_to_hr) > 0){
                $total_question_percentage = $get_polls_users_to_hr->sum('question_percentage'); 
                $sumTotal = $get_polls_users_to_hr->sum('answer_percentage'); 
                $calcPercentageTotalAnswerFromTotalQuestion = ($sumTotal/$total_question_percentage) * 100; 
    
                $count_users_polling_hr = PollUsersHrTeachers::where('group_id', request('poll_hr_group'))->groupBy('user_id')->get();
                $count_questions = PollsQuestions::where('group', request('poll_hr_group'))->count();
    
                
                $nameAr = 'تقرير استبيان جروبات الإدارة'.' - '.$get_polls_users_to_hr[0]->group_name;
                $nameEn = 'report_groups';

                return view('back.polls_reports.reports_hr.groups.pdf', compact('nameAr', 'nameEn', 'get_polls_users_to_hr', 'total_question_percentage', 'count_users_polling_hr', 'count_questions', 'sumTotal', 'calcPercentageTotalAnswerFromTotalQuestion'));
            }else{
                return redirect()->back()->withInput()->with('message', 'لاتوجد استبيانات تمت لهذة المجموعة في الوقت الحالي');
            }
            

        }
    ////////////////////////////////////////////////////// end report group تقرير استبيان جروبات الإدارة //////////////////////////////////////////////////////












    //////////////////////////////////////// start report question with group تقرير استبيان لأسئلة جروبات الإدارة ///////////////////////////////////
        public function reportQuestionWithGroupGet(){
            $nameAr = 'تقرير استبيان لأسئلة جروبات الإدارة';
            $nameEn = 'questionWithGroup';
            $groups_hr = PollsGroups::where('special', 'hr')->get();
            
            return view('back.polls_reports.reports_hr.questionWithGroup.index', compact('nameAr', 'nameEn', 'groups_hr'));
        }

        public function getQuestionsWhenChangeGroup($id){
            if (request()->ajax()) {
                $find = pollsQuestions::where('group', $id)->get();
                return response()->json($find);
            }
            return redirect()->back();
        }

        public function reportQuestionWithGroupPost(Request $request){

            $get_polls_users_to_hr = PollUsersHrTeachers::leftJoin('users', 'poll_users_hr_teachers.user_id', 'users.id')
                                    ->leftJoin('polls_groups',  'polls_groups.id', 'poll_users_hr_teachers.group_id' )                                                        
                                    ->leftJoin('answers_to_polls_questions', 'answers_to_polls_questions.id', 'poll_users_hr_teachers.answer')
                                    ->leftJoin('polls_questions', 'polls_questions.id', 'poll_users_hr_teachers.question')

                                    ->where('poll_users_hr_teachers.question', request('poll_hr_question'))

                                    ->select(
                                        'users.name as user_name', 
                                        'polls_groups.title as group_name', 
                                        'polls_questions.question as question_title', 'polls_questions.type as question_type', 'polls_questions.percentage as question_percentage', 
                                        'answers_to_polls_questions.percentage as answer_percentage', 'answers_to_polls_questions.answer as answer_title',
                                        'poll_users_hr_teachers.*'
                                    )
                                    ->orderBy('created_at', 'DESC')
                                    ->get();
                                                                                        
                                    
            if(count($get_polls_users_to_hr) > 0){
                $count_users_polling_hr = PollUsersHrTeachers::where('question', request('poll_hr_question'))->count();
                
                $questionPercentage = ($get_polls_users_to_hr[0]['question_percentage'] * $count_users_polling_hr); 
                $sumTotalInPollUsersHrTeachers = PollUsersHrTeachers::where('question', request('poll_hr_question'))->sum('total'); 
    
                if($get_polls_users_to_hr[0]['question_type'] != 'radio'){
                    $sumTotal = 0;
                }else{
                    $sumTotal = ($sumTotalInPollUsersHrTeachers / $questionPercentage) * 100; 
                }
    
                
                $groupName = $get_polls_users_to_hr[0]->group_name;
                $questionTitle = $get_polls_users_to_hr[0]->question_title;
                
                return view('back.polls_reports.reports_hr.questionWithGroup.pdf', compact('groupName', 'questionTitle', 'count_users_polling_hr', 'get_polls_users_to_hr', 'sumTotal'));
            }else{
                return redirect()->back()->withInput()->with('message', 'لاتوجد استبيانات تمت لهذا السؤال في الوقت الحالي');
            }
        }
    //////////////////////////////////////// end report question with group تقرير استبيان لأسئلة جروبات الإدارة /////////////////////////////////////












    //////////////////////////////////////// start report parent with group تقرير استبيان لولي أمر يخص جروبات الإدارة ///////////////////////////////////
        public function reportParentWithGroupGet(){
            $nameAr = 'تقرير استبيان لولي أمر يخص جروبات الإدارة';
            $parents = DB::table('tbl_parents')->get();

            return view('back.polls_reports.reports_hr.parentWithGroup.index', compact('nameAr', 'parents'));
        }

        public function reportParentWithGroupPost(Request $request){

            $get_polls_users_to_hr = PollUsersHrTeachers::where('user_id', request('parent_id'))
                                    ->leftJoin('users', 'poll_users_hr_teachers.user_id', 'users.id')
                                    ->leftJoin('polls_groups',  'polls_groups.id', 'poll_users_hr_teachers.group_id' )                                                        
                                    ->leftJoin('answers_to_polls_questions', 'answers_to_polls_questions.id', 'poll_users_hr_teachers.answer')
                                    ->leftJoin('polls_questions', 'polls_questions.id', 'poll_users_hr_teachers.question')

                                    ->select(
                                        'users.name as user_name', 
                                        'polls_groups.title as group_name', 
                                        'polls_questions.question as question_title', 'polls_questions.type as question_type', 'polls_questions.percentage as question_percentage', 
                                        'answers_to_polls_questions.percentage as answer_percentage', 'answers_to_polls_questions.answer as answer_title',
                                        'poll_users_hr_teachers.*'
                                    )
                                    ->orderBy('created_at', 'DESC')
                                    ->get();
                                               
                                    // dd($get_polls_users_to_hr);
                                    
            if(count($get_polls_users_to_hr) > 0){
                $count_users_polling_hr = PollUsersHrTeachers::where('question', request('poll_hr_question'))->count();             
                
                $sumQuestionPercentage = PollUsersHrTeachers::where('user_id', request('parent_id'))
                                                            ->leftJoin('polls_questions', 'polls_questions.id', 'poll_users_hr_teachers.question')
                                                            ->sum('polls_questions.percentage'); 

                $sumAnswersPercentage = PollUsersHrTeachers::where('user_id', request('parent_id'))->sum('total');
                

                if($get_polls_users_to_hr[0]['question_type'] != 'radio'){
                    $sumTotal = 0;
                }else{
                    $sumTotal = ( ((double)$sumAnswersPercentage) / ((double)$sumQuestionPercentage) ) * 100; 
                }
    
                $parent = $get_polls_users_to_hr[0]->user_name;
                
                return view('back.polls_reports.reports_hr.parentWithGroup.pdf', compact('parent', 'count_users_polling_hr', 'get_polls_users_to_hr', 'sumTotal'));
            }else{
                return redirect()->back()->withInput()->with('message', 'لاتوجد استبيانات تمت لولي الأمر في الوقت الحالي');
            }
        }
    //////////////////////////////////////// end report question with group تقرير استبيان لولي أمر يخص جروبات الإدارة /////////////////////////////////////

}
