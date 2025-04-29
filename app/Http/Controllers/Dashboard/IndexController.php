<?php

namespace App\Http\Controllers\Dashboard;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ParentProblems;
use App\Models\PollsGroups;
use App\Models\PollsQuestions;
use App\Models\ProblemComments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Hash;

class IndexController
{

    public function index()
    {

        //return AllStudentsChart()['degreesDetails'];


        $studentsRelParentToGetTeachersToPolling = FacadesDB::table('tbl_parents')
                                                    ->leftJoin('tbl_students', 'tbl_parents.ID', 'tbl_students.ParentID')

                                                    ->leftJoin('tbl_groups_students', 'tbl_students.ID', 'tbl_groups_students.StudentID')

                                                    ->leftJoin('tbl_groups', 'tbl_groups_students.GroupID', 'tbl_groups.ID')

                                                    ->leftJoin('tbl_teachers', 'tbl_groups.TeacherID', 'tbl_teachers.ID')

                                                    ->select('tbl_students.ID as st_id', 'tbl_students.TheName as st_name', 'tbl_parents.ID', 'tbl_groups.ID as group_id', 'tbl_groups.GroupName as group_name', 'tbl_teachers.ID as teacher_id', 'tbl_teachers.TheName as teacher_name')

                                                    ->groupBy('teacher_id')

                                                    ->where('tbl_parents.ID', auth()->user()->id)
                                                    ->where('tbl_teachers.ID', '!=', 'null')

                                                    ->get();




        $today = Carbon::now()->toDateString();
        $pollGroupsActives = PollsGroups::whereDate('from', '<=', $today)
                                    ->whereDate('to', '>=', $today)
                                    ->where('status', 1)
                                    ->get();

        $checkPollGroupsToHrOrTeachers = isset($pollGroupsActives[0]) === false ? null : $pollGroupsActives[0]->special;
        $checkPollGroupsActivesNull = isset($pollGroupsActives[0]) === false ? null : $pollGroupsActives[0]->id;


        $questions = PollsQuestions::where('group', $checkPollGroupsActivesNull)
                                    ->with('answers')
                                    ->where('status', 1)
                                    ->get();



        $checkIfUserPolledToHr = FacadesDB::table('poll_users_hr_teachers')
                                    ->where('user_id', auth()->user()->id)
                                    ->where('group_id', $checkPollGroupsActivesNull)
                                    ->first();

        $checkIfUserPolledToTeachers = FacadesDB::table('poll_users_to_teachers_only')
                                    ->where('user_id', auth()->user()->id)
                                    ->where('group_id', $checkPollGroupsActivesNull)
                                    ->first();



        // $group_class_att = FacadesDB::table('tbl_groups_classes_att')
        //                         ->select('S_FinalAmount')
        //                         ->join('tbl_students', 'tbl_groups_classes_att.StudentID', 'tbl_students.ID')
        //                         ->join('tbl_parents', 'tbl_students.ParentID', 'tbl_parents.ID')
        //                         ->sum('S_FinalAmount');

        // dd($group_class_att);



        $get_students = FacadesDB::table('tbl_students_years_mat')
                            ->leftJoin('tbl_students', 'tbl_students_years_mat.StudentID', 'tbl_students.ID')
                            ->join('tbl_years_mat', 'tbl_students_years_mat.YearID', 'tbl_years_mat.ID')
                            ->where('tbl_students.ParentID' , auth()->user()->id)
                            ->select('tbl_students.TheName', 'tbl_students_years_mat.StudentID')
                            ->orderBy('tbl_students.TheName', 'ASC')
                            ->distinct()
                            ->get();


         $get_students2p = FacadesDB::table('tbl_students_years_mat')
                             ->leftJoin('tbl_students', 'tbl_students_years_mat.StudentID', 'tbl_students.ID')
                             ->join('tbl_years_mat', 'tbl_students_years_mat.YearID', 'tbl_years_mat.ID')
                             ->select('tbl_students_years_mat.StudentID','tbl_years_mat.TheFullName')
                             ->where('tbl_students.ParentID' , auth()->user()->id)
                             ->get();


        $noti_to_classes_unreaded = FacadesDB::table('noti_to_classes')
                                        ->join('tbl_students_years_mat', 'tbl_students_years_mat.YearID', 'noti_to_classes.class_id')
                                        ->join('tbl_years_mat', 'tbl_years_mat.ID', 'noti_to_classes.class_id')
                                        ->join('users', 'users.id', 'noti_to_classes.sender')
                                        ->join('tbl_students', 'tbl_students.ID', 'tbl_students_years_mat.StudentID')
                                        ->join('tbl_parents', 'tbl_students.ParentID', 'tbl_parents.ID')
                                        ->where('tbl_parents.ID', auth()->user()->id)
                                        ->where('readed', 2)
                                        ->select('title', 'description', 'sender', 'noti_to_classes.created_at', 'noti_to_classes.id', 'class_id', 'TheFullName', 'name', 'readed')
                                        ->count();

        $noti_to_parents_unreaded = FacadesDB::table('noti_to_parents')
                                        ->where('parent_id', auth()->user()->id)
                                        ->where('readed', 2)
                                        ->count();





        $payments_current_month = FacadesDB::table('tbl_parents_payments')
                                        ->where('tbl_parents_payments.ParentID', auth()->user()->id)
                                        ->whereBetween('tbl_parents_payments.TheDate', [date('Y-m-01'), date('Y-m-31')])
                                        ->Sum('tbl_parents_payments.TheAmount');

        // $all_data = FacadesDB::table('tbl_groups_classes_att')
        //                                 ->leftJoin('tbl_students', 'tbl_groups_classes_att.StudentID', 'tbl_students.ID')              // student
        //                                 ->leftJoin('tbl_parents', 'tbl_students.ParentID', 'tbl_parents.ID')                          // parent
        //                                 ->leftJoin('tbl_teachers', 'tbl_groups_classes_att.TeacherID', 'tbl_teachers.ID')            // teacher
        //                                 ->leftJoin('tbl_groups_classes', 'tbl_groups_classes_att.ClassID', 'tbl_groups_classes.ID') // groups classes
        //                                 ->leftJoin('tbl_groups', 'tbl_groups_classes_att.GroupID', 'tbl_groups.ID')                // groups
        //                                 ->leftJoin('tbl_years_mat', 'tbl_groups.YearID', 'tbl_years_mat.ID')                      // years mat

        //                                 ->whereBetween('tbl_groups_classes.TheDate', [date('Y-m-01'), date('Y-m-30')])           // whereBetween
        //                                 ->where('tbl_groups_classes_att.TheStatus', '!=' , 'غائب')

        //                                 ->select(
        //                                     FacadesDB::raw("count(tbl_groups_classes_att.ID) as CountOfID"),
        //                                     'tbl_groups_classes_att.GroupID As TheGroupID',
        //                                     'tbl_groups_classes_att.GroupPrice As TheGroupPrice',
        //                                     'tbl_groups_classes_att.S_DisPre As TheS_DisPre',
        //                                     'tbl_groups_classes_att.S_DisAmount As TheS_DisAmount',
        //                                     'tbl_groups_classes_att.S_FinalAmount As TheS_FinalAmount',
        //                                     'tbl_students.TheName As TheStudentName',
        //                                     'tbl_students.ID As TheStudentID',
        //                                     'tbl_parents.ID As TheParentID',
        //                                     'tbl_parents.TheName0 As TheParentName',
        //                                     'tbl_groups_classes_att.TeacherID As TheTeacherID',
        //                                     'tbl_teachers.TheName As TheTeacherName',
        //                                     'tbl_groups.GroupName As TheGroupName',
        //                                     'tbl_years_mat.TheFullName As TheFullNameYearsMat',
        //                                 )

        //                                 ->orderBy('tbl_students.TheName', 'ASC')

        //                                 ->groupBy(
        //                                     'tbl_groups_classes_att.GroupID',
        //                                     'tbl_groups_classes_att.GroupPrice',
        //                                     'tbl_groups_classes_att.S_DisPre',
        //                                     'tbl_groups_classes_att.S_DisAmount',
        //                                     'tbl_groups_classes_att.S_FinalAmount',
        //                                     'tbl_groups_classes_att.TeacherID',
        //                                     // 'tbl_groups_classes_att.StudentID',
        //                                     'tbl_teachers.TheName',
        //                                     'tbl_parents.TheName0',
        //                                     'tbl_students.TheName',
        //                                     'tbl_students.ParentID',
        //                                     'tbl_groups.GroupName',
        //                                     'tbl_years_mat.TheFullName',
        //                                 )
        //                                 ->Sum('tbl_groups_classes_att.S_FinalAmount');    // End FacadesDB::table



        // المستحقات السابقة
        // $previous_dues = FacadesDB::table('tbl_groups_classes_att')
        //                         ->join('tbl_groups_classes', 'tbl_groups_classes_att.ClassID', 'tbl_groups_classes.ID')
        //                         ->join('tbl_students', 'tbl_groups_classes_att.StudentID', 'tbl_students.ID')
        //                         // ->where('tbl_groups_classes.TheDate', '<' , date('Y-m-d'))
        //                         ->where('tbl_groups_classes_att.TheStatus', '!=' , 'غائب')
        //                         ->where('tbl_students.ParentID', auth()->user()->id)
        //                         ->select('tbl_groups_classes_att.S_FinalAmount')
        //                         ->Sum('tbl_groups_classes_att.S_FinalAmount');



        // // المستحقات السابقة
        $previous_dues = FacadesDB::table('tbl_groups_classes_att')
                                // ->join('tbl_groups_classes', 'tbl_groups_classes.ID', 'tbl_groups_classes_att.ClassID')
                                ->join('tbl_students', 'tbl_students.ID', 'tbl_groups_classes_att.StudentID')
                                // ->where('tbl_groups_classes.TheDate', '<' , date('Y-m-d'))
                                ->where('tbl_groups_classes_att.TheStatus', '!=' , 'غائب')
                                ->where('tbl_students.ParentID', auth()->user()->id)
                                ->select('tbl_groups_classes_att.S_FinalAmount')
                                ->Sum('tbl_groups_classes_att.S_FinalAmount');


                                // dd($previous_dues);


        // مدفوعات أولياء الأمور
        if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2 || auth()->user()->user_status == 4){
            $parents_payments = FacadesDB::table('tbl_parents_payments')
                                ->select(FacadesDB::raw('SUM(TheAmount) as total_amount'))
                                ->where('ParentID', request('parent'))
                                ->get();
        }else if(auth()->user()->user_status == 3){
            $parents_payments = FacadesDB::table('tbl_parents_payments')
                                ->where('ParentID', auth()->user()->id)
                                ->select(FacadesDB::raw('SUM(TheAmount) as total_amount'))
                                ->sum('TheAmount');
                                // ->get();
        }

        // dd($parents_payments);

        // return view('back.index');

        return view('back.index', compact('get_students', 'get_students2p', 'noti_to_classes_unreaded', 'noti_to_parents_unreaded', 'parents_payments', 'payments_current_month', 'questions', 'pollGroupsActives','checkIfUserPolledToHr', 'checkIfUserPolledToTeachers', 'checkPollGroupsActivesNull', 'checkPollGroupsToHrOrTeachers', 'studentsRelParentToGetTeachersToPolling', 'previous_dues'));
    }

    public function login()
    {
        return view('back/login');
    }

    public function forget_password()
    {
        return view('back/forget_password');
    }

    public function not_auth()
    {
        if(Auth::user()){
            return redirect('dashboard');
        }else{
            return view('back/not_auth');
        }
    }

    public function login_post(Request $request)
    {
        $request->validate([
            "TheEmail" => "required",
            "ThePass" => "required",
        ],[
            'TheEmail.required' => 'البريد الإلكتروني مطلوب',
            'ThePass.required' => 'الرقم السري مطلوب',
        ]);

        if(Auth::attempt(['email' => request('TheEmail') , 'password' => request('ThePass')])){
            FacadesDB::table('noti_to_parents')
                    ->where('parent_id', auth()->user()->id)
                    ->where('created_at', '<', date('Y-06-01 h:i:s'))
                    ->where('status', 1)
                    ->update(['status' => 2, 'readed' => 1]);

            return redirect('dashboard');
        }else{
            session()->put('error_email_or_password', 'تأكد من البريد الإلكتروني و الرقم السري');
            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('dashboard/login');
    }
}