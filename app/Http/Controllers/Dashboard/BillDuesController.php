<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Parents;
use PDF;
use App;
use DB;

class BillDuesController extends Controller
{
    public function index()
    {
        $parents = Parents::all();
        $parent = Parents::where('TheName0', auth()->user()->name)->first();

        return view('back.bill_dues.index', compact('parents', 'parent'));
    }


    public function show($id)
    {
        $parent_name = DB::table('tbl_parents')->where('ID', request('parent'))->first();

        // dd($parent_name->PrevRaseed);

        // رقم الفاتوره
        $bill_num = date('YmdAhis');

        // تاريخ الفاتوره
        $bill_date = date('Y-m-d');

        // المدفوعات السابقه قبل تاريخ البدايه
        $previous_payments = DB::table('tbl_parents_payments')
                                    ->where('tbl_parents_payments.ParentID', request('parent'))
                                    ->where('tbl_parents_payments.TheDate', '<' ,request('from'))
                                    ->Sum('tbl_parents_payments.TheAmount');

                                    // dd($previous_payments);
        // المستحقات السابقة
        $previous_dues = DB::table('tbl_groups_classes_att')
                                ->join('tbl_groups_classes', 'tbl_groups_classes_att.ClassID', 'tbl_groups_classes.ID')
                                ->join('tbl_students', 'tbl_groups_classes_att.StudentID', 'tbl_students.ID')
                                ->where('tbl_students.ParentID', request('parent'))
                                ->where('tbl_groups_classes.TheDate', '<' ,request('from'))
                                ->where('tbl_groups_classes_att.TheStatus', '!=' , 'غائب')
                                ->Sum('tbl_groups_classes_att.S_FinalAmount');

                                // dd(($previous_dues+$parent_name->PrevRaseed) - $previous_payments);

        // المدفوعات السابقه قبل تاريخ البدايه
        $payments_between_two_dates = DB::table('tbl_parents_payments')
                                            ->where('tbl_parents_payments.ParentID', request('parent'))
                                            ->whereBetween('tbl_parents_payments.TheDate', [request('from'), request('to')])
                                            ->Sum('tbl_parents_payments.TheAmount');

                                    // dd($payments_between_two_dates);

        $st = DB::table('tbl_groups_classes_att')
                        ->distinct()
                        ->join('tbl_students', 'tbl_students.ID', 'tbl_groups_classes_att.StudentID')
                        ->join('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                        ->join('tbl_groups_classes', 'tbl_groups_classes.ID', 'tbl_groups_classes_att.ClassID')
                        ->select('tbl_groups_classes_att.StudentID', 'tbl_students.TheName')
                        ->whereBetween('tbl_groups_classes.TheDate', [request('from'), request('to')])           // whereBetween
                        ->where('tbl_students.ParentID', request('parent'))                                     // where ParentID = request('parent')
                        ->get();






        $all_data = DB::table('tbl_groups_classes_att')
                        ->leftJoin('tbl_students', 'tbl_groups_classes_att.StudentID', 'tbl_students.ID')              // student
                        ->leftJoin('tbl_parents', 'tbl_students.ParentID', 'tbl_parents.ID')                          // parent
                        ->leftJoin('tbl_teachers', 'tbl_groups_classes_att.TeacherID', 'tbl_teachers.ID')            // teacher
                        ->leftJoin('tbl_groups_classes', 'tbl_groups_classes_att.ClassID', 'tbl_groups_classes.ID') // groups classes
                        ->leftJoin('tbl_groups', 'tbl_groups_classes_att.GroupID', 'tbl_groups.ID')                // groups
                        ->leftJoin('tbl_years_mat', 'tbl_groups.YearID', 'tbl_years_mat.ID')                      // years mat

                        ->whereBetween('tbl_groups_classes.TheDate', [request('from'), request('to')])           // whereBetween
                        ->where('tbl_groups_classes_att.TheStatus', '!=' , 'غائب')                             // whereBetween tbl_groups_classes_att.TheStatus != 'غائب'
                        // ->where('tbl_groups_classes_att.StudentID', request('parent'))                                     // where ParentID = request('parent')

                        ->select(
                            DB::raw("count(tbl_groups_classes_att.ID) as CountOfID"),
                            // DB::raw('SUM(tbl_groups_classes_att.S_DisPre) as sum_S_DisPre'),
                            'tbl_groups_classes_att.GroupID As TheGroupID',
                            'tbl_groups_classes_att.GroupPrice As TheGroupPrice',
                            'tbl_groups_classes_att.S_DisPre As TheS_DisPre',
                            'tbl_groups_classes_att.S_DisAmount As TheS_DisAmount',
                            'tbl_groups_classes_att.S_FinalAmount As TheS_FinalAmount',
                            'tbl_students.TheName As TheStudentName',
                            'tbl_students.ID As TheStudentID',
                            'tbl_parents.ID As TheParentID',
                            'tbl_parents.TheName0 As TheParentName',
                            'tbl_groups_classes_att.TeacherID As TheTeacherID',
                            'tbl_teachers.TheName As TheTeacherName',
                            'tbl_groups.GroupName As TheGroupName',
                            'tbl_years_mat.TheFullName As TheFullNameYearsMat',
                        )

                        ->orderBy('tbl_students.TheName', 'ASC')

                        ->groupBy(
                            'tbl_groups_classes_att.GroupID',
                            'tbl_groups_classes_att.GroupPrice',
                            'tbl_groups_classes_att.S_DisPre',
                            'tbl_groups_classes_att.S_DisAmount',
                            'tbl_groups_classes_att.S_FinalAmount',
                            'tbl_groups_classes_att.TeacherID',
                            // 'tbl_groups_classes_att.StudentID',
                            'tbl_teachers.TheName',
                            'tbl_parents.TheName0',
                            'tbl_students.TheName',
                            'tbl_students.ParentID',
                            'tbl_groups.GroupName',
                            'tbl_years_mat.TheFullName',
                        )
                        ->get();
                        // ->Sum('tbl_groups_classes_att.S_DisAmount');

        // dd($all_data);

        if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){
            $parents_payments = DB::table('tbl_parents_payments')
                                ->select(DB::raw('SUM(TheAmount) as total_amount'))
                                ->where('ParentID', request('parent'))
                                ->get();
        }else if(auth()->user()->user_status == 3){
            $parents_payments = DB::table('tbl_parents_payments')
                                ->select(DB::raw('SUM(TheAmount) as total_amount'))
                                ->where('ParentID', auth()->user()->id)
                                ->get();
        }


        // dd($parents_payments[0]->total_amount);


        $xPrevFinal = ($previous_dues+$parent_name->PrevRaseed) - $previous_payments;

        $data = [
            'parent' => request('parent'),
            'from' => request('from'),
            'to' => request('to'),
            'all_data' => $all_data,
            'st' => $st,
            'previous_payments' => $previous_payments,
            'previous_dues' => $previous_dues,
            'payments_between_two_dates' => $payments_between_two_dates,
            'bill_num' => $bill_num,
            'bill_date' => $bill_date,
            'parent_name' => $parent_name,
            'parents_payments' => $parents_payments,
            'xPrevFinal' => $xPrevFinal,
        ];


        // return $data;


        $pdf = PDF::loadView('back.bill_dues.report', $data);
        return $pdf->stream('كشف حساب مقدم إلي '.$parent_name->TheName0.' - '.time().' - '.date('d-m-Y').'.pdf');
    }

}
