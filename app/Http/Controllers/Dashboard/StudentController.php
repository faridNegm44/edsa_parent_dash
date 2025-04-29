<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Student;
use App\Models\Parents;
use App\Models\TheYears;
use App\Models\StudentsDesires;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use PDF;
use App;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        return view('back.student.index');
    }

    public function create()
    {
        $user_name = auth()->user()->name;
        $parent = Parents::where('TheName0', $user_name)->first();
        $parents = Parents::all();

        return view('back.student.add', compact('parent', 'parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
           'TheName' => 'required',
           'NatID' => 'required',
           'CityID' => 'required',
        //    'ThePhone' => 'required',
           'TheEmail' => 'required',
           'TheEduType' => 'required',
           'TheTestType' => 'required',
        ],
        [
            'TheName.required' => 'إسم الطالب مطلوب',
            'NatID.required' => 'الجنسية مطلوبة',
            'CityID.required' => 'مكان الإقامة مطلوب',
            'TheEmail.required' => 'البريد الإلكتروني مطلوب',
            'TheEmail.unique' => 'البريد الإلكتروني مستخدم من قبل',
            'TheEduType.required' => 'نظام التعليم مطلوب',
            'TheTestType.required' => 'نظام الاختبارات مطلوب',
       ]);

       if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){
            Student::create([
                'TheDate' => date('Y-m-d'),
                'TheName' => request('TheName'),
                'ParentID' => request('ParentID'),
                'NatID' => request('NatID'),
                'CityID' => request('CityID'),
                'ThePhone' => request('ThePhone') == null ? '-' : request('ThePhone'),
                'TheEmail' => request('TheEmail'),
                'TheLangID' => request('TheEduType'),
                'TheTestType' => request('TheTestType'),
                'TheExplain' => request('TheExplain') == null ? null : request('TheExplain'),
                'TheNotes' => request('TheNotes'),
                'TheStatus' => 'جديد',
                'TheStatusDate' => date('Y-m-d'),
            ]);
        }elseif(auth()->user()->user_status == 3){
            Student::create([
                'TheDate' => date('Y-m-d'),
                // 'ID' => mt_rand(0, 88888888),
                'TheName' => request('TheName'),
                'ParentID' => auth()->user()->id,
                'NatID' => request('NatID'),
                'CityID' => request('CityID'),
                'ThePhone' => request('ThePhone') == null ? '-' : request('ThePhone'),
                'TheEmail' => request('TheEmail'),
                'TheLangID' => request('TheEduType'),
                'TheTestType' => request('TheTestType'),
                'TheExplain' => request('TheExplain') == null ? null : request('TheExplain'),
                'TheNotes' => request('TheNotes'),
                'TheStatus' => 'جديد',
                'TheStatusDate' => date('Y-m-d'),
            ]);
        }

    }

    public function edit($id)
    {
        $find = Student::where('id', $id)->first();
        $parents = Parents::all();
        return view('back.student.edit', compact('find', 'parents'));
    }

    public function update(Request $request, $id)
    {
        // dd(request('ParentID'));
        $this->validate($request , [
            'TheName' => 'required',
            'NatID' => 'required',
            'CityID' => 'required',
            // 'ThePhone' => 'required',
            'TheEmail' => 'required',
            'TheEduType' => 'required',
            'TheTestType' => 'required',
        ],
        [
            'TheName.required' => 'إسم الطالب مطلوب',
            'NatID.required' => 'الجنسية مطلوبة',
            'CityID.required' => 'مكان الإقامة مطلوب',
            'TheEmail.required' => 'البريد الإلكتروني مطلوب',
            'TheEmail.unique' => 'البريد الإلكتروني مستخدم من قبل',
            'TheEduType.required' => 'نظام التعليم مطلوب',
            'TheTestType.required' => 'نظام الاختبارات مطلوب',
       ]);

        if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){
            Student::where('ID', $id)->update([
                'TheDate' => date('Y-m-d'),
                'TheName' => request('TheName'),
                'ParentID' => request('ParentID'),
                'NatID' => request('NatID'),
                'CityID' => request('CityID'),
                'ThePhone' => request('ThePhone') == null ? '-' : request('ThePhone'),
                'TheEmail' => request('TheEmail'),
                'TheLangID' => request('TheEduType'),
                'TheTestType' => request('TheTestType'),
                'TheExplain' => request('TheExplain') == null ? null : request('TheExplain'),
                'TheNotes' => request('TheNotes'),
                'TheStatus' => 'جديد',
                'TheStatusDate' => date('Y-m-d'),
            ]);
        }elseif(auth()->user()->user_status == 3){
            Student::where('ID', $id)->update([
                'TheDate' => date('Y-m-d'),
                'TheName' => request('TheName'),
                'ParentID' => auth()->user()->id,
                'NatID' => request('NatID'),
                'CityID' => request('CityID'),
                'ThePhone' => request('ThePhone') == null ? '-' : request('ThePhone'),
                'TheEmail' => request('TheEmail'),
                'TheLangID' => request('TheEduType'),
                'TheTestType' => request('TheTestType'),
                'TheExplain' => request('TheExplain') == null ? null : request('TheExplain'),
                'TheNotes' => request('TheNotes'),
                'TheStatus' => 'جديد',
                'TheStatusDate' => date('Y-m-d'),
            ]);
        }
   }

    public function destroy($id)
    {
        $find = Student::where('ID', $id)->delete();
    }

    public function datatable_students()
    {
        if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){
            $all = Student::all();
            return DataTables::of($all)
            ->addColumn('id', function($d){
                $id = $d->ID;
                return $id;
            })
            ->addColumn('desires', function($d){
                $desires = '<a res_id="'.$d->ID.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal2" act="'.url('dashboard/students/student_desires/'.$d->ID).'" style="display: inline;margin: 0px 5px;"><i style="color: #753422;font-weight: bold;font-size: 17px;" class="fa fa-list"></i></a>';
                return $desires;
            })
            ->addColumn('parent', function($d){
                $parent = $d->parent_name['name'];
                return $parent;
            })
            ->addColumn('name', function($d){
                $name = $d->TheName;
                return $name;
            })
            ->addColumn('nationality', function($d){
                $nationality = $d->nationality_name['TheName'];
                return $nationality;
            })
            ->addColumn('city', function($d){
                $city = $d->city_name['TheCity'];
                return $city;
            })
            ->addColumn('mobile', function($d){
                $mobile = $d->ThePhone;
                return $mobile;
            })
            ->addColumn('TheEduType', function($d){
                $TheEduType = $d->TheEduType;
                return $TheEduType;
            })
            ->addColumn('TheTestType', function($d){
                $TheTestType = $d->TheTestType;
                return $TheTestType;
            })
            ->addColumn('action', function($d){
                $buttons = '<a res_id="'.$d->ID.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/students/edit/'.$d->ID).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                $buttons .= '<a res_id="'.$d->ID.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';

                return $buttons;
            })
            ->rawColumns(['id', 'desires', 'name', 'TheEduType', 'TheTestType', 'parent', 'nationality', 'city', 'mobile', 'created_at', 'action'])
            ->make(true);
        }elseif(auth()->user()->user_status == 3){
            $all = Student::where('ParentID', auth()->user()->id)->get();
            return DataTables::of($all)
            ->addColumn('id', function($d){
                $id = $d->ID;
                return $id;
            })
            ->addColumn('desires', function($d){
                $desires = '<a res_id="'.$d->ID.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal2" act="'.url('dashboard/students/student_desires/'.$d->ID).'" style="display: inline;margin: 0px 5px;"><i style="color: #753422;font-weight: bold;font-size: 17px;" class="fa fa-list"></i></a>';
                return $desires;
            })
            ->addColumn('name', function($d){
                $name = $d->TheName;
                return $name;
            })
            ->addColumn('nationality', function($d){
                $nationality = $d->nationality_name['TheName'];
                return $nationality;
            })
            ->addColumn('city', function($d){
                $city = $d->city_name['TheCity'];
                return $city;
            })
            ->addColumn('mobile', function($d){
                $mobile = $d->ThePhone;
                return $mobile;
            })
            ->addColumn('TheEduType', function($d){
                $TheEduType = $d->TheEduType;
                return $TheEduType;
            })
            ->addColumn('TheTestType', function($d){
                $TheTestType = $d->TheTestType;
                return $TheTestType;
            })
            ->addColumn('action', function($d){
                $buttons = '<a res_id="'.$d->ID.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/students/edit/'.$d->ID).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                $buttons .= '<a res_id="'.$d->ID.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';

                return $buttons;
            })
            ->rawColumns(['id', 'desires', 'name', 'TheEduType', 'TheTestType', 'parent', 'nationality', 'city', 'mobile', 'created_at', 'action'])
            ->make(true);
        }
    }











    /////////////////////////////////  Student Desires  /////////////////////////////////

    public function student_desires($id)
    {
        $years = TheYears::select('TheYear')->distinct()->get();
        $student_desires = StudentsDesires::where('StudentID', $id)->get();
        $student = Student::where('ID', $id)->first();

        return view('back.student.student_desires', compact('years', 'student_desires', 'student'));
    }

    public function store_desires(Request $request)
    {
        if(StudentsDesires::where('StudentID', request('student_id'))->exists()){
            for($i = 0; $i < count(request('new_matt')); $i++){
                StudentsDesires::updateOrInsert([
                    'StudentID'=> request('student_id'),
                    'YearID'=> request('new_matt')[$i],
                ],[
                    'StudentID' => request('student_id'),
                    'YearID' =>  request('new_matt')[$i],
                    'TheTime' =>  request('new_TheTime')[$i],
                    'ThePackage' =>  request('new_ThePackage')[$i],
                    'TheNotes' => request('TheNotes'),
                ]);
            }
        }else{
            $request->validate([
                'YearID' => 'required',
            ],[
                'YearID.required' => 'يجب إختيار صف دراسي لإظهار المواد المتعلقه به',
            ]);

            for($i = 0; $i < count(request('new_matt')); $i++){
                $data[] = [
                    'StudentID' => request('student_id'),
                    'YearID' =>  request('new_matt')[$i],
                    'TheTime' =>  request('new_TheTime')[$i],
                    'ThePackage' =>  request('new_ThePackage')[$i],
                    'TheNotes' =>  request('TheNotes'),
                ];
            }

            DB::table('tbl_students_years_mat')->insert($data);
        }
    }

    public function destroy_desire_to_student($id, $student_id)
    {
        $find = StudentsDesires::where('StudentID', $student_id)->where('YearID', $id)->delete();
    }

    /////////////////////////////////  End Student Desires  ////////////////////////////////





    /////////////////////////////////  Start attendance_and_absence_report_for_students  ////////////////////////////////

    public function attendance_and_absence_report_for_students()
    {
        $parents = Parents::all();
        $parent = Parents::where('TheName0', auth()->user()->name)->first();

        $get_students = DB::table('tbl_groups_students')
                                    ->distinct()
                                    ->select(
                                            'tbl_students.TheName As StudentName',
                                            'tbl_students.ID As StudentID',
                                    )
                                    ->join('tbl_students', 'tbl_students.ID', 'tbl_groups_students.StudentID')
                                    ->where('tbl_students.ParentID', auth()->user()->id)
                                    ->orderBy('StudentName', 'ASC')
                                    ->get();

                                    // dd($get_students);

        $get_students_and_groups = DB::table('tbl_groups_students')
                                    ->select(
                                            'tbl_groups_students.GroupID AS GroupID',
                                            'tbl_groups.GroupName AS GroupName',
                                            'tbl_groups_students.StudentID',
                                            'tbl_students.TheName As StudentName',
                                    )
                                    ->join('tbl_groups', 'tbl_groups.ID', 'tbl_groups_students.GroupID')
                                    ->join('tbl_students', 'tbl_students.ID', 'tbl_groups_students.StudentID')
                                    ->where('tbl_students.ParentID', auth()->user()->id)
                                    ->where('tbl_groups.TheStatus', '=', 'مفتوحة')
                                    ->orderBy('StudentName', 'ASC')
                                    ->get();



        return view('back.student.attendance_and_absence_report_for_students', compact('parents', 'parent', 'get_students', 'get_students_and_groups'));
    }

    public function attendance_and_absence_report_for_students_post(Request $request)
    {
        $parent_name = DB::table('tbl_parents')->where('ID', request('parent'))->first();

        // رقم الفاتوره
        // $bill_num = date('YmdAhis');

        // تاريخ الفاتوره
        $bill_date = date('Y-m-d');

        $request->validate([
            'students' => 'required',
            'groups' => 'required',
            'from' => 'required',
            'to' => 'required',
         ],[
             'students.required' => 'يجب إختيار طالب واحد علي الأقل',
             'groups.required' => 'يجب إختيار مجموعة واحده علي الأقل',
             'from.required' => 'تاريخ البداية مطلوب',
             'to.required' => 'تاريخ النهاية مطلوب',
         ]);


        // if(request('students') === null){
        //     $st = null;
        // }else{
            $st = DB::table('tbl_groups_classes_att')
                            ->distinct()
                            ->join('tbl_students', 'tbl_students.ID', 'tbl_groups_classes_att.StudentID')
                            ->join('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                            ->join('tbl_groups_classes', 'tbl_groups_classes.ID', 'tbl_groups_classes_att.ClassID')
                            ->select('tbl_groups_classes_att.StudentID', 'tbl_students.TheName')
                            ->whereBetween('tbl_groups_classes.TheDate', [request('from'), request('to')])
                            ->where('tbl_students.ParentID', request('parent'))
                            ->whereIn('tbl_students.ID', request('students'))
                            ->get();
        // }
                        // dd($st);

        $all_data = DB::table('tbl_groups_classes_att')
                        ->join('tbl_groups_classes', 'tbl_groups_classes_att.ClassID', 'tbl_groups_classes.ID')
                        ->join('tbl_groups', 'tbl_groups_classes.GroupID', 'tbl_groups.ID')
                        ->join('tbl_years_mat', 'tbl_groups.YearID', 'tbl_years_mat.ID')
                        ->join('tbl_students', 'tbl_groups_classes_att.StudentID', 'tbl_students.ID')
                        ->join('tbl_teachers', 'tbl_groups_classes_att.TeacherID', 'tbl_teachers.ID')


                        ->whereBetween('tbl_groups_classes.TheDate', [request('from'), request('to')])
                        ->whereIn('tbl_students.ID', request('students'))
                        ->whereIn('tbl_groups_classes_att.GroupID', request('groups'))

                        ->select(
                            // DB::raw("count(tbl_groups_classes_att.TheStatus) as StatusCount"),
                            'tbl_groups.YearID',
                            'tbl_groups_classes_att.GroupID',
                            'tbl_groups_classes_att.TeacherID',
                            'tbl_groups_classes_att.ClassID',
                            'tbl_groups_classes_att.StudentID',
                            'tbl_years_mat.TheFullName',
                            'tbl_groups.GroupName',
                            'tbl_teachers.TheName AS TeacherName',
                            'tbl_groups_classes.ClassNumber',
                            'tbl_groups_classes.TheDate',
                            'tbl_groups_classes_att.TheStatus',
                            'tbl_students.TheName',
                        )

                        ->orderBy('tbl_groups.YearID', 'ASC')
                        ->orderBy('tbl_groups_classes_att.GroupID', 'ASC')
                        ->orderBy('tbl_groups_classes.ClassNumber', 'ASC')
                        ->get();    // End DB::table


        $data = [
            'parent' => request('parent'),
            'from' => request('from'),
            'to' => request('to'),
            'all_data' => $all_data,
            'st' => $st,
            // 'bill_num' => $bill_num,
            'bill_date' => $bill_date,
            'parent_name' => $parent_name,
        ];

        $pdf = PDF::loadView('back.student.report', $data);
        return $pdf->stream('تقرير التفقد الخاص بأولاد '.$parent_name->TheName0.' - '.date('h-i-s').' - '.date('d-m-Y').'.pdf');
    }







    /////////////////////////////////  Start students_rates  ////////////////////////////////

    public function students_rates()
    {
        $parents = Parents::all();
        $parent = Parents::where('TheName0', auth()->user()->name)->first();
        if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){
            return redirect()->back();
        }else{
            return view('back.student.students_rates', compact('parents', 'parent'));
        }
    }

    public function get_students_to_rates()
    {
        if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){
            $get_students = DB::table('tbl_eval')->select(
                                            'Eval_ID',
                                            'Eval_GroupID',
                                            'Eval_TeacherID',
                                            'Eval_StudentID',
                                            'Eval_Years_Mat',
                                            'Eval_TeacherComment',
                                            'Eval_TeacherSugg',
                                            'Eval_Att',
                                            'Eval_Part',
                                            'Eval_Eval',
                                            'Eval_HW',
                                            'GroupName',
                                            'tbl_teachers.TheName AS TeacherName',
                                            'tbl_students.TheName AS StudentName',
                                            'tbl_students.ParentID AS ParentID',
                                            'TheFullName',
                                    )
                                    ->join('tbl_groups', 'tbl_groups.ID', 'tbl_eval.Eval_GroupID')
                                    ->join('tbl_teachers', 'tbl_teachers.ID', 'tbl_eval.Eval_TeacherID')
                                    ->join('tbl_students', 'tbl_students.ID', 'tbl_eval.Eval_StudentID')
                                    ->join('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_eval.Eval_Years_Mat')


                                    ->where('tbl_students.ParentID', request('parent'))
                                    ->whereBetween('Eval_Date', [request('from'), request('to')])
                                    ->orderBy('Eval_GroupID', 'ASC')
                                    ->groupBy('StudentName')
                                    ->get();
        }else if(auth()->user()->user_status == 3){
            $get_students = DB::table('tbl_eval')
                                ->where('Eval_Month', request('month'))
                                ->join('tbl_students', 'tbl_students.ID', 'tbl_eval.Eval_StudentID')
                                ->where('tbl_students.ParentID', auth()->user()->id)
                                ->orderBy('tbl_students.TheName', 'ASC')
                                ->groupBy('tbl_students.TheName')
                                ->select('tbl_students.ID', 'tbl_students.TheName')
                                ->get();
        }
                                    // dd($get_students);

        return response()->json([
                'get_students' => $get_students,
                'month' => request('month')
            ]);
    }

    public function students_rates_post(Request $request)
    {
        $parent_name = DB::table('tbl_parents')->where('ID', auth()->user()->id)->first();

        // رقم الفاتوره
        $bill_num = date('YmdAhis');

        // تاريخ الفاتوره
        $bill_date = date('Y-m-d');

        $request->validate([
            'students' => 'required',
         ],[
             'students.required' => 'يجب إختيار طالب واحد علي الأقل',
         ]);

        // $all_data = DB::table('tbl_eval')
        //                 ->join('tbl_groups', 'tbl_groups.ID', 'tbl_eval.Eval_GroupID')
        //                 ->join('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_eval.Eval_Years_Mat')
        //                 ->join('tbl_teachers', 'tbl_teachers.ID', 'tbl_eval.Eval_TeacherID')
        //                 ->join('tbl_students', 'tbl_students.ID', 'tbl_eval.Eval_StudentID')
        //                 ->join('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
        //                 ->select(
        //                     'Eval_ID',
        //                     'Eval_Date',
        //                     'Eval_GroupID',
        //                     'Eval_TeacherID',
        //                     'Eval_Years_Mat',
        //                     'Eval_StudentID',
        //                     'Eval_Count',
        //                     'Eval_Att',
        //                     'Eval_Part',
        //                     'Eval_Eval',
        //                     'Eval_HW',
        //                     'Eval_Degree',
        //                     'tbl_groups.GroupName',
        //                     'tbl_years_mat.TheFullName',
        //                     'Eval_TeacherComment',
        //                     'Eval_TeacherSugg',
        //                     'GroupName',
        //                     'tbl_teachers.TheName AS TeacherName',
        //                     'tbl_students.TheName AS StudentName',
        //                     'tbl_students.ParentID AS ParentID',
        //                     'tbl_parents.TheName0 AS ParentName',
        //                     'TheFullName',
        //                 )
        //                 ->orderBy('Eval_Date', 'ASC')


        //                 ->whereBetween('Eval_Date', [$from, $to])
        //                 ->whereIn('Eval_StudentID', request('students'))
        //                 ->get();

// dd(request('month'));

        $all_data = DB::table('tbl_eval')
                        ->leftJoin('tbl_groups', 'tbl_groups.ID', 'tbl_eval.Eval_GroupID')
                        ->join('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_eval.Eval_Years_Mat')
                        ->leftJoin('tbl_teachers', 'tbl_teachers.ID', "tbl_eval.Eval_TeacherID")
                        ->leftJoin('tbl_students', 'tbl_students.ID', 'tbl_eval.Eval_StudentID')
                        ->leftJoin('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                        ->select(
                            "tbl_eval.*",
                            "tbl_groups.GroupName as groupName",
                            "tbl_teachers.TheName as teacherName",
                            "tbl_students.TheName as studentName",
                            'tbl_students.ParentID AS ParentID',
                            "tbl_parents.TheName0 as parentName",
                            'tbl_years_mat.TheFullName',
                        )

                        ->orderBy('tbl_students.TheName', 'ASC')

                        ->where('Eval_Month', request('month'))
                        ->whereIn('Eval_StudentID', request('students'))
                        ->get();

                        // return $all_data;



        $data = [
            'parent' => request('parent'),
            'all_data' => $all_data,
            'bill_num' => $bill_num,
            'bill_date' => $bill_date,
            'parent_name' => $parent_name,
            'month' => request('month'),
        ];

        $pdf = PDF::loadView('back.student.report_students_rates', $data);
        return $pdf->stream('تقرير التقييم الشهري لأولاد '.$parent_name->TheName0.' - '.date('h-i-s').' - '.date('d-m-Y').'.pdf');
    }



































    /////////////////////////////////////////////// Students Desires ///////////////////////////////////////////////

    public function index_student_desires()
    {
        return view('back.student_desires.index');
    }

    public function create_desires()
    {
        $user_id = auth()->user()->id;
        $students = Student::where('ParentID', $user_id)->get();
        $years = TheYears::select('TheYear')->distinct()->get();

        return view('back/student_desires/add', compact('students', 'years'));
    }

    public function get_mat_after_change_years($id, $student_id)
    {
        $mats = TheYears::select('TheMat', 'tbl_years_mat.ID')
                        ->where('TheYear', $id)
                        ->distinct()
                        ->get();

        return response()->json($mats);
    }

    public function get_mat_after_change_years_register_form($lang, $class)
    {
        if($lang == 1 || $lang == 2 ){
            $mats = TheYears::select('TheMat', 'tbl_years_mat.ID')
                            ->where('TheYear', $class)
                            ->whereIn('LangType', [$lang, 3])
                            ->distinct()
                            ->get();
        }else{
            $mats = TheYears::select('TheMat', 'tbl_years_mat.ID')
                            ->where('TheYear', $class)
                            ->where('LangType', $lang)
                            ->distinct()
                            ->get();
        }

        return response()->json($mats);
    }


    public function view_desires($id)
    {
        $user_name = auth()->user()->name;
        $group_id = StudentsDesires::where('group_id', $id)->first();
        $student = StudentsDesires::where('StudentID', $group_id['StudentID'])->first();
        $year = TheYears::where('ID', $group_id['YearID'])->first();
        $mats = StudentsDesires::where('group_id', $id)->get();

        return view('back/student_desires/view', compact('group_id', 'student', 'user_name', 'year', 'mats'));
    }

    public function edit_desires($id)
    {

        $user_name = auth()->user()->name;
        $user_id = auth()->user()->id;

        $group_id = StudentsDesires::where('group_id', $id)->first();

        $student = StudentsDesires::where('StudentID', $group_id['StudentID'])->first();
        $students = Student::where('ParentID', $user_id)->get();

        $year = TheYears::where('ID', $group_id['YearID'])->first();
        $years = TheYears::select('TheYear')->distinct()->get();

        $the_year = TheYears::where('ID', $group_id['YearID'])->first();
        $get_all_mats_after_get_year = TheYears::where('TheYear', $the_year['TheYear'])->get();

        $get_mats_selected = StudentsDesires::where('group_id', $id)->get();

        return view('back/student_desires/edit', compact('group_id', 'student', 'students', 'user_name', 'year', 'years', 'get_all_mats_after_get_year', 'get_mats_selected'));
    }


    public function update_desires(Request $request, $id)
    {
        $find = StudentsDesires::where('group_id', $id)->delete();
        $request->validate([
            'StudentID' => 'required',
            'YearID' => 'required',
        ],
        [
            'StudentID.required' => 'يجب إختيار طالب',
            'YearID.required' => 'يجب إختيار صف دراسي لإظهار المواد المتعلقه به',
        ]);

        $last_group_id = StudentsDesires::select('group_id')->orderBy('ID', 'DESC')->first();

        for($i = 0; $i < count(request('new_matt')); $i++){
            $data[] = [
                'group_id' => $last_group_id == null ? 1 : $last_group_id->group_id+1,
                'StudentID' => request('StudentID'),
                'YearID' =>  request('new_matt')[$i],
                'time' =>  request('new_time')[$i],
                'package' =>  request('new_package')[$i],
                'notes' =>  request('new_notes')[$i],
            ];
         }

        DB::table('tbl_students_years_mat')->insert($data);
    }

    public function destroy_desires($id)
    {
        $find = StudentsDesires::where('group_id', $id)->delete();
    }

    public function datatable_students_desires()
    {
        $all = StudentsDesires::leftjoin('tbl_students', 'tbl_students.ID', '=', 'tbl_students_years_mat.StudentID')
                                ->where('tbl_students.ParentID', '=', auth()->user()->id)
                                ->groupBy('group_id')
                                ->get();
        return DataTables::of($all)
        ->addColumn('id', function($d){
            $id = $d->student_name->ID;
            return $id;
        })
        ->addColumn('name', function($d){
            $StudentID = $d->student_name->TheName;
            return $StudentID;
        })
        ->addColumn('classroom', function($d){
            $year_id = DB::table('tbl_years_mat')->where('ID', $d->YearID)->first();
            return $year_id->TheYear;
        })
        ->addColumn('subjects', function($d){
            $button = '<a res_group_id="'.$d->group_id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/students/view_desires/'.$d->group_id).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-eye" style="font-size: 20px;color: #50CB93;"></i></a>';

            return $button;
        })
        ->addColumn('action', function($d){
            $buttons = '<a res_id="'.$d->group_id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/students/edit_desires/'.$d->group_id).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

            $buttons .= '<a res_id="'.$d->group_id.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';

            return $buttons;
        })
        ->rawColumns(['id', 'name', 'classroom', 'subjects', 'action'])
        ->make(true);
    }
}
