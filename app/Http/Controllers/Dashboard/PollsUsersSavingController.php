<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PollUsersHrTeachers;
use App\Models\PollUsersToTeachersOnly;
use Illuminate\Http\Request;

class PollsUsersSavingController extends Controller
{
    ///////////////////////////////////////////// start polling parents to hr ///////////////////////////////////////////
    public function poll_users_hr_teachers(Request $request)
    {    
        $answers = request()->except('_token', 'group_id');
        $group_id = request('group_id');       


        // dd($answers);


        foreach ($answers as $key => $values){

            // echo $key."=>".$values.'#########';

            
            // $explodeValue = explode('_', $values);
            // $p1 = isset($explodeValue[0]) ? $explodeValue[0] : $key;
            // $p2 = isset($explodeValue[1]) ? $explodeValue[1] : $values;
            // $p3 = isset($explodeValue[2]) ? $explodeValue[2] : 0;

            PollUsersHrTeachers::create([
                'user_id' => auth()->user()->id,
                'group_id' => $group_id,
                'question' => $key,
                'answer' => isset(explode('_', $values)[0]) ? explode('_', $values)[0] : $values,
                'total' => isset(explode('_', $values)[1]) ? explode('_', $values)[1] : null,
                'special' => 'hr',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال الإستبيان بنجاح',
        ]);
    }
    ///////////////////////////////////////////// end polling parents to hr ///////////////////////////////////////////
    










    ///////////////////////////////////////////// start polling parents to teachers ///////////////////////////////////////////
    public function poll_users_teachers(Request $request){    
    
        $answers = request()->except('_token', 'group_id');
        $group_id = request('group_id');       

        
        // dd($answers);


        foreach ($answers as $key => $values){

            // echo $key."=>".$values.'#########';


            PollUsersToTeachersOnly::create([
                'user_id' => auth()->user()->id,
                'teacher_id' => explode('_', $key)[0],
                'group_id' => $group_id,
                'question_id' => explode('_', $key)[1],
                'answer' => isset(explode('_', $values)[1]) ? explode('_', $values)[1] : $values,
                'total' => isset(explode('_', $values)[2]) ? explode('_', $values)[2] : null,
                'special' => 'teachers',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال الإستبيان بنجاح',
        ]);









        // $teacherId = $data['teacher_id'][0]; 
        // $questionIds = $data['question_id'];
        // $answersData = $data; 




        // $PollUsersHrTeachers = [];
        // foreach ($questionIds as $key => $value) {
        //     $answerText = $answersData[$key];

        //     // dd($answerValue);
        //     $PollUsersHrTeachers[] = new PollUsersToTeachersOnly([
        //         'user_id' => $teacherId,
        //         'group_id' => 1,
        //         'question' => $key,
        //         'answer' => $answerText,
        //         'special' => 'teachers',
        //     ]);
        // }

        // PollUsersToTeachersOnly::insert($PollUsersHrTeachers);

        // return response()->json(['message' => 'تم حفظ البيانات بنجاح']);



    }
    ///////////////////////////////////////////// end polling parents to teachers ///////////////////////////////////////////

}
