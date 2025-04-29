<?php

function Months(){
    $months = [
        ['يناير' , 1],
        ['فبراير' , 2],
        ['مارس' , 3],
        ['أبريل' , 4],
        ['مايو' , 5],
        ['يونيو' , 6],
        ['يوليو' , 7],
        ['أغسطس' , 8],
        ['سبتمبر' , 9],
        ['أكتوبر' , 10],
        ['نوفمبر' , 11],
        ['ديسمبر' , 12],
    ];

    return $months;
}

function AllStudentsChart(){

    $parent = auth()->user()->id;

    $students = DB::table('tbl_students')
                    ->where('parentID', $parent)
                    ->select('ID', 'TheName')
                    ->orderBy('TheName', 'ASC')
                    ->get();
                    
                    
    $studentsDegree = DB::table('tbl_students')
                    ->where('parentID', $parent)
                    ->leftJoin('tbl_eval', 'tbl_eval.Eval_StudentID', '=', 'tbl_students.ID')
                    ->leftJoin('tbl_groups', 'tbl_groups.ID', '=', 'tbl_eval.Eval_GroupID')
                    ->select(
                        'tbl_students.ID',
                        'tbl_students.TheName',
                        'tbl_eval.Eval_Month',
                        DB::raw('SUM(tbl_eval.Eval_Degree) as total_degree'),  // جمع الدرجات في كل شهر
                        DB::raw('COUNT(DISTINCT tbl_eval.Eval_GroupID) as num_subjects'),  // عدد المواد التي تم تقييم الطالب فيها
                        'tbl_groups.GroupName'
                    )
                    ->groupBy('tbl_students.ID', 'tbl_eval.Eval_Month')  // تجميع البيانات حسب الطالب والشهر
                    ->orderBy('tbl_students.TheName', 'ASC')
                    ->orderBy('tbl_eval.Eval_Month', 'DESC')
                    ->get()
                    ->map(function($student) {
                        if ($student->num_subjects > 0) {
                            $total_possible = $student->num_subjects * 100;
                            $student->percentage = ($student->total_degree / $total_possible) * 100;
                        } else {
                            $student->percentage = 0;
                        }
                        return $student;
                    });

    $degreesDetails = DB::table('tbl_students')
                    ->where('parentID', $parent)
                    ->leftJoin('tbl_eval', 'tbl_eval.Eval_StudentID', '=', 'tbl_students.ID')
                    ->leftJoin('tbl_groups', 'tbl_groups.ID', '=', 'tbl_eval.Eval_GroupID')
                    ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', '=', 'tbl_groups.YearID')
                    ->select(
                        'tbl_students.ID',
                        'tbl_students.TheName',
                        'tbl_eval.Eval_Month',
                        'tbl_eval.Eval_Degree',
                        'tbl_eval.Eval_GroupID',
                        'tbl_groups.GroupName',
                        'tbl_years_mat.TheMat',
                    )
                    ->orderBy('tbl_years_mat.TheMat', 'ASC')
                    ->get();
                    


    return [
        'parent' => $parent,
        'students' => $students,
        'studentsDegree' => $studentsDegree,
        'degreesDetails' => $degreesDetails,
    ];
}