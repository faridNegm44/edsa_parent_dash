<?php

namespace App\Http\Controllers\Dashboard;

use DB;
use Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Parents;
use Illuminate\Http\Request;
use App\Models\ParentProblems;
use App\Models\ProblemComments;
use App\Http\Controllers\Controller;
use File;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\Facades\DataTables;

class ParentProblemsController extends Controller
{

    public function index()
    {
        return view('back.parent_problems.index');
    }

    public function create()
    {
        $parents = Parents::all();
        return view('back/parent_problems/add', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
           'problem_type' => 'required',
           'problem' => 'required',
        //    'parent_id' س=> 'required',
        ],[
            'problem_type.required' => 'تصنيف الطلب مطلوب',
            'parent_id.required' => 'ولي الأمر مطلوب',
            'problem.required' => 'مضمون الرسالة مطلوب',
        ]);

        ParentProblems::create([
            'problem_type' => request('problem_type'),
            'problem' => request('problem'),
            'parent_id' => request('parent_id'),
            'staff_id' => request('parent_id') == auth()->user()->id ? null : auth()->user()->id,
            'date_reference' => request('parent_id') == auth()->user()->id ? null : Carbon::now(),
        ]);

    }

    public function show(students $students)
    {
        //
    }

    public function edit($id)
    {
        $find = ParentProblems::where('id', $id)->first();
        $parents = Parents::all();
        $comments = ProblemComments::orderBy('id', 'DESC')->where('problem_id' , $id)->get();
        return view('back/parent_problems/edit', compact('parents', 'find', 'comments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'problem_type' => 'required',
            'problem' => 'required',
        ],[
            'problem_type.required' => 'تصنيف الطلب مطلوب',
            'parent_id.required' => 'ولي الأمر مطلوب',
            'problem.required' => 'مضمون الرسالة مطلوب',
        ]);

        ParentProblems::where('id', $id)->update([
            'problem_type' => request('problem_type'),
            'problem' => request('problem'),
            'parent_id' => request('parent_id'),
            'staff_id' => request('parent_id') == auth()->user()->id ? null : auth()->user()->id,
            'readed' =>  auth()->user()->user_status == 3 ? 0 : request('readed') ,
        ]);
   }

    public function destroy($id)
    {
        ParentProblems::where('id', $id)->delete();
        ProblemComments::where('problem_id', $id)->delete();
    }












    // reference area
        public function reference($id)
        {
            $find = ParentProblems::where('id', $id)->first();
            $stuff = User::where('user_status', '!=' , 3)->get();

            return view('back/parent_problems/reference', compact('find', 'stuff'));
        }

        public function reference_store(Request $request, $id)
        {
            $request->validate([
                'staff_id' => 'required',
            ],[
                'staff_id.required' => 'الإسم الأول مطلوب',
            ]);

            ParentProblems::where('id', $id)->update([
                'staff_id' => request('staff_id'),
                'date_reference' => Carbon::now(),
            ]);

        }







    // update_problem_rating  //  update_problem_status  //  update_staff_rating
        public function update_problem_rating(Request $request, $id)
            {
                ParentProblems::where('id', $id)->update([
                    'problem_rating' => request('problem_rating'),
                ]);
        }

        public function update_problem_status(Request $request, $id)
            {
                ParentProblems::where('id', $id)->update([
                    'problem_status' => request('problem_status'),
                    'ended_at' => request('problem_status') === "تم حلها" ? Carbon::now() : null,
                ]);
        }

        public function update_staff_rating(Request $request, $id)
            {
                ParentProblems::where('id', $id)->update([
                    'staff_rating' => request('staff_rating'),
                ]);
        }









    // start comment area

        // store commnt
        public function store_comment(Request $request, $id)
        {
            $request->validate([
            'comment' => 'required',
            ],[
                'comment.required' => 'التعليق مطلوب',
            ]);

            if(request('file') == ""){
                $name = null;
            }else{
                $file = request('file');
                $name = rand(0, 1000) . '-' .$file->getClientOriginalName();
                $path = public_path('back/files/comments');
                $file->move($path , $name);
            }

            ProblemComments::create([
                'problem_id' => $id,
                'comment' => request('comment'),
                'file' => $name,
                'commented_by' => auth()->user()->id,
                'parent_id' => request('parent_id_input'),
                'updated_at' => null,
            ]);

        }

        // edit comment
        public function edit_comment($id)
        {
            $comment = ProblemComments::where('id' , $id)->first();
            return response()->json($comment, 200);
        }

        // update comment
        public function update_comment(Request $request, $id)
        {
            $request->validate([
            'comment' => 'required',
            ],[
                'comment.required' => 'التعليق مطلوب',
            ]);

            $find = ProblemComments::findorFail($id);

            if(request('file') == ""){
                $name = request('old_file');
            }else{
                $file = request('file');
                $name = rand(0, 1000) . '-' .$file->getClientOriginalName();
                $path = public_path('back/files/comments');
                $file->move($path , $name);

                File::delete(public_path('back/files/comments/'.$find['file']));
            }

            $find->update([
                'edited_comment' => request('comment'),
                'file' => $name,
                'commented_by' => auth()->user()->id,
                'updated_at' => Carbon::now(),
            ]);
        }

        // delete comment
        public function delete_comment($id)
        {
            $find = ProblemComments::findorFail($id);
            $find->delete();
            File::delete(public_path('back/files/comments/'.$find['file']));
        }

    // end comment area









    // all datatable
        public function datatable_parent_problems()
        {
            if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2 || auth()->user()->user_status == 4){
                $all = ParentProblems::all();
                return DataTables::of($all)
                ->addColumn('parent_id', function($d){
                    $parent_id = $d->parent['name'];
                    $readed = $d->readed == 1 ? 'تمت القراءة' : '-' ;

                    return $parent_id.
                        '<hr />'.
                        '<span class="text-primary">
                            <i class="fa fa-comment" style="margin: 0px 3px;"></i>
                            '.ProblemComments::where('problem_id', $d->id)->count().'
                        </span>'.
                        '<hr />'.
                        '<span style="text-decoration: underline;color: red;font-weight: bold;">
                           ( '.$readed.' )
                        </span>';
                })
                ->addColumn('problem', function($d){
                    return '
                        <p>
                            تصنيف الطلب :
                            <br />
                            '.$d->problem_type.'
                        </p>
                        <hr />

                        <p>
                            مضمون الطلب :
                            <br />
                            '.$d->problem.'
                        </p>
                    ';
                })
                ->addColumn('staff_id_date_reference', function($d){
                    if($d->staff_id === null){
                        return '';
                    }else{
                        return '
                        <p>
                            <i class="fa fa-user text-primary" style="margin: 0px 3px;">
                                <span>'. $d->staff['name'] .'</span>
                            </i>
                            <hr />
                            <i class="fa fa-calendar text-danger" style="margin: 0px 3px;">
                                <span>'. Carbon::parse($d->date_reference)->format('d-m-Y') .'</span>
                            </i>
                            <br />
                            <i class="fa fa-clock text-danger" style="margin: 0px 3px;">
                                <span>'. Carbon::parse($d->date_reference)->format('h:i') .'</span>
                            </i>
                        </p>
                        ';
                    }
                })
                ->addColumn('problem_rating', function($d){
                    $problem_rating = '';

                    if($d->problem_rating == 30){
                        $problem_rating = 'سهلة';
                    }elseif($d->problem_rating == 40){
                        $problem_rating = 'أقل من المتوسط';
                    }elseif($d->problem_rating == 50){
                        $problem_rating = 'متوسط';
                    }elseif($d->problem_rating == 90){
                        $problem_rating = 'صعبـة';
                    }elseif($d->problem_rating == 100){
                        $problem_rating = 'صعبـة جدآ';
                    }

                    return '
                        <select class="form-control change_problem_rating" res_id="'.$d->id.'">
                            <option value="">
                            </option>
                            <option value="30">
                                سهلة
                            </option>
                            <option value="40">
                                أقل من المتوسط
                            </option>
                            <option value="50">
                                متوسط
                            </option>
                            <option value="90">
                                صعبـة
                            </option>
                            <option value="100">
                                صعبـة جدآ
                            </option>
                            <option value="">
                                null
                            </option>
                        </select>

                        <p style="margin-top: 5px;font-weight: bold;">
                            <span class="badge badge-primary" style="font-size: 13px;">
                                '.$problem_rating.'
                            </span>
                        </p>
                    ';
                })
                ->addColumn('staff_rating', function($d){
                    $staff_rating = '';

                    if($d->staff_rating == 30){
                        $staff_rating = 'ضعيف جدآ';
                    }elseif($d->staff_rating == 40){
                        $staff_rating = 'ضعيف';
                    }elseif($d->staff_rating == 50){
                        $staff_rating = 'جيد';
                    }elseif($d->staff_rating == 90){
                        $staff_rating = 'جيد جدآ';
                    }elseif($d->staff_rating == 100){
                        $staff_rating = 'ممتاز';
                    }

                    return '
                        <select class="form-control change_staff_rating" res_id="'.$d->id.'">
                            <option value="">

                            </option>
                            <option value="30">ضعيف جدآ</option>
                            <option value="40">ضعيف</option>
                            <option value="50">جيد</option>
                            <option value="90">جيد جدآ</option>
                            <option value="100">ممتاز</option>
                            <option value="">null</option>
                        </select>

                        <p style="margin-top: 5px;font-weight: bold;">
                            <span class="badge badge-success" style="font-size: 13px;">
                                '.$staff_rating.'
                            </span>
                        </p>
                    ';
                })
                ->addColumn('problem_status', function($d){
                    return '
                        <select class="form-control change_problem_status" res_id="'.$d->id.'">
                            <option value="">

                            </option>
                            <option value="عاجل">
                                عاجل
                            </option>
                            <option value="جاري حلها">
                                جاري حلها
                            </option>
                            <option value="تم الإلغاء">
                                تم الإلغاء
                            </option>
                            <option value="تم حلها">
                                تم حلها
                            </option>
                            <option value="">
                                null
                            </option>
                        </select>

                        <p style="margin-top: 5px;font-weight: bold;">
                            <span class="badge badge-danger" style="font-size: 13px;">
                                '.$d->problem_status.'
                            </span>
                        </p>
                    ';
                })
                ->addColumn('created_at_ended_at', function($d){
                    if($d->ended_at === null){
                        return '
                            <p class="badge badge-primary text-center">
                                تاريخ إرسال الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('h:i') .'</span>
                            </p>
                        ';
                    }else{
                        return '
                            <p class="badge badge-primary text-center">
                                تاريخ إرسال الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('h:i') .'</span>
                            </p>

                            <p class="badge badge-danger text-center">
                                تاريخ غلق الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. Carbon::parse($d->ended_at)->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. Carbon::parse($d->ended_at)->format('h:i') .'</span>
                            </p>
                        ';
                    }
                })
                ->addColumn('action', function($d){
                    $buttons = '<a href="'.url('dashboard/parent_problems/edit/'.$d->id).'" class="text-muted option-dots2" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                    $buttons .= '<a res_id="'.$d->id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/parent_problems/reference/'.$d->id).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-user text-success"></i></a>';

                    $buttons .= '<a res_id="'.$d->id.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';

                    return $buttons;

                })
                ->rawColumns(['parent_id', 'problem', 'staff_id_date_reference', 'problem_rating', 'staff_rating', 'problem_status', 'created_at_ended_at', 'ended_at', 'action'])
                ->make(true);
            }elseif(auth()->user()->user_status == 3){
                $all = ParentProblems::where('parent_id', auth()->user()->id)->get();
                return DataTables::of($all)
                ->addColumn('comments_count', function($d){
                    return '<span class="text-primary">
                            <i class="fa fa-comment" style="margin: 0px 3px;"></i>
                            '.ProblemComments::where('problem_id', $d->id)->count().'
                        </span>';
                })
                ->addColumn('problem', function($d){
                    return '
                        <p>
                            تصنيف الطلب :
                            <br />
                            '.$d->problem_type.'
                        </p>
                        <hr />

                        <p>
                            مضمون الطلب :
                            <br />
                            '.$d->problem.'
                        </p>
                    ';
                })
                ->addColumn('staff_id_date_reference', function($d){
                    if($d->staff_id === null){
                        return '';
                    }else{
                        return '
                        <p>
                            <i class="fa fa-user text-primary" style="margin: 0px 3px;">
                                <span>'. $d->staff['name'] .'</span>
                            </i>
                            <hr />
                            <i class="fa fa-calendar text-danger" style="margin: 0px 3px;">
                                <span>'. Carbon::parse($d->date_reference)->format('d-m-Y') .'</span>
                            </i>
                            <br />
                            <i class="fa fa-clock text-danger" style="margin: 0px 3px;">
                                <span>'. Carbon::parse($d->date_reference)->format('h:i') .'</span>
                            </i>
                        </p>
                        ';
                    }
                })
                ->addColumn('problem_status', function($d){
                    return '
                        <p style="margin-top: 5px;font-weight: bold;">
                            <span class="badge badge-danger" style="font-size: 13px;">
                                '.$d->problem_status.'
                            </span>
                        </p>
                    ';
                })
                ->addColumn('created_at_ended_at', function($d){
                    if($d->ended_at === null){
                        return '
                            <p class="badge badge-primary text-center">
                                تاريخ إرسال الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('h:i') .'</span>
                            </p>
                        ';
                    }else{
                        return '
                            <p class="badge badge-primary text-center">
                                تاريخ إرسال الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('h:i') .'</span>
                            </p>

                            <p class="badge badge-danger text-center">
                                تاريخ غلق الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. Carbon::parse($d->ended_at)->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. Carbon::parse($d->ended_at)->format('h:i') .'</span>
                            </p>
                        ';
                    }
                })
                ->addColumn('action', function($d){
                    $buttons = '<a href="'.url('dashboard/parent_problems/edit/'.$d->id).'" class="text-muted option-dots2" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                    $buttons .= '<a res_id="'.$d->id.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';

                    return $buttons;

                })
                ->rawColumns(['comments_count', 'problem', 'staff_id_date_reference', 'problem_status', 'created_at_ended_at', 'action'])
                ->make(true);
            }
        }


    // datatable_parent_problems_urgent
        public function datatable_parent_problems_urgent()
        {
            if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2 || auth()->user()->user_status == 4){
                $all = ParentProblems::where('problem_status' , 'عاجل')->get();
                return DataTables::of($all)
                ->addColumn('parent_id', function($d){
                    $parent_id = $d->parent['name'];
                    return $parent_id.
                        '<hr />'.
                        '<span class="text-primary">
                            <i class="fa fa-comment" style="margin: 0px 3px;"></i>
                            '.ProblemComments::where('problem_id', $d->id)->count().'
                        </span>';
                })
                ->addColumn('problem', function($d){
                    return '
                        <p>
                            تصنيف الطلب :
                            <br />
                            '.$d->problem_type.'
                        </p>
                        <hr />

                        <p>
                            مضمون الطلب :
                            <br />
                            '.$d->problem.'
                        </p>
                    ';
                })
                ->addColumn('staff_id_date_reference', function($d){
                    if($d->staff_id === null){
                        return '';
                    }else{
                        return '
                        <p>
                            <i class="fa fa-user text-primary" style="margin: 0px 3px;">
                                <span>'. $d->staff['name'] .'</span>
                            </i>
                            <hr />
                            <i class="fa fa-calendar text-danger" style="margin: 0px 3px;">
                                <span>'. Carbon::parse($d->date_reference)->format('d-m-Y') .'</span>
                            </i>
                            <br />
                            <i class="fa fa-clock text-danger" style="margin: 0px 3px;">
                                <span>'. Carbon::parse($d->date_reference)->format('h:i') .'</span>
                            </i>
                        </p>
                        ';
                    }
                })
                ->addColumn('problem_rating', function($d){
                    $problem_rating = '';

                    if($d->problem_rating == 30){
                        $problem_rating = 'سهلة';
                    }elseif($d->problem_rating == 40){
                        $problem_rating = 'أقل من المتوسط';
                    }elseif($d->problem_rating == 50){
                        $problem_rating = 'متوسط';
                    }elseif($d->problem_rating == 90){
                        $problem_rating = 'صعبـة';
                    }elseif($d->problem_rating == 100){
                        $problem_rating = 'صعبـة جدآ';
                    }

                    return '
                        <select class="form-control change_problem_rating" res_id="'.$d->id.'">
                            <option value="">
                            </option>
                            <option value="30">
                                سهلة
                            </option>
                            <option value="40">
                                أقل من المتوسط
                            </option>
                            <option value="50">
                                متوسط
                            </option>
                            <option value="90">
                                صعبـة
                            </option>
                            <option value="100">
                                صعبـة جدآ
                            </option>
                            <option value="">
                                null
                            </option>
                        </select>

                        <p style="margin-top: 5px;font-weight: bold;">
                            <span class="badge badge-primary" style="font-size: 13px;">
                                '.$problem_rating.'
                            </span>
                        </p>
                    ';
                })
                ->addColumn('staff_rating', function($d){
                    $staff_rating = '';

                    if($d->staff_rating == 30){
                        $staff_rating = 'ضعيف جدآ';
                    }elseif($d->staff_rating == 40){
                        $staff_rating = 'ضعيف';
                    }elseif($d->staff_rating == 50){
                        $staff_rating = 'جيد';
                    }elseif($d->staff_rating == 90){
                        $staff_rating = 'جيد جدآ';
                    }elseif($d->staff_rating == 100){
                        $staff_rating = 'ممتاز';
                    }

                    return '
                        <select class="form-control change_staff_rating" res_id="'.$d->id.'">
                            <option value="">

                            </option>
                            <option value="30">ضعيف جدآ</option>
                            <option value="40">ضعيف</option>
                            <option value="50">جيد</option>
                            <option value="90">جيد جدآ</option>
                            <option value="100">ممتاز</option>
                            <option value="">null</option>
                        </select>

                        <p style="margin-top: 5px;font-weight: bold;">
                            <span class="badge badge-success" style="font-size: 13px;">
                                '.$staff_rating.'
                            </span>
                        </p>
                    ';
                })
                ->addColumn('problem_status', function($d){
                    return '
                        <select class="form-control change_problem_status" res_id="'.$d->id.'">
                            <option value="">

                            </option>
                            <option value="عاجل">
                                عاجل
                            </option>
                            <option value="جاري حلها">
                                جاري حلها
                            </option>
                            <option value="تم الإلغاء">
                                تم الإلغاء
                            </option>
                            <option value="تم حلها">
                                تم حلها
                            </option>
                            <option value="">
                                null
                            </option>
                        </select>

                        <p style="margin-top: 5px;font-weight: bold;">
                            <span class="badge badge-danger" style="font-size: 13px;">
                                '.$d->problem_status.'
                            </span>
                        </p>
                    ';
                })
                ->addColumn('created_at_ended_at', function($d){
                    if($d->ended_at === null){
                        return '
                            <p class="badge badge-primary text-center">
                                تاريخ إرسال الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('h:i') .'</span>
                            </p>
                        ';
                    }else{
                        return '
                            <p class="badge badge-primary text-center">
                                تاريخ إرسال الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('h:i') .'</span>
                            </p>

                            <p class="badge badge-danger text-center">
                                تاريخ غلق الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. Carbon::parse($d->ended_at)->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. Carbon::parse($d->ended_at)->format('h:i') .'</span>
                            </p>
                        ';
                    }
                })
                ->addColumn('action', function($d){
                    $buttons = '<a href="'.url('dashboard/parent_problems/edit/'.$d->id).'" class="text-muted option-dots2" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                    $buttons .= '<a res_id="'.$d->id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/parent_problems/reference/'.$d->id).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-user text-success"></i></a>';

                    $buttons .= '<a res_id="'.$d->id.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';

                    return $buttons;

                })
                ->rawColumns(['parent_id', 'problem', 'staff_id_date_reference', 'problem_rating', 'staff_rating', 'problem_status', 'created_at_ended_at', 'ended_at', 'action'])
                ->make(true);
            }else{

            }
        }


    // datatable_parent_problems_waiting
        public function datatable_parent_problems_waiting()
        {
            if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2 || auth()->user()->user_status == 4){
                $all = ParentProblems::where('problem_status' , 'جاري حلها')->get();
                return DataTables::of($all)
                ->addColumn('parent_id', function($d){
                    $parent_id = $d->parent['name'];
                    return $parent_id.
                        '<hr />'.
                        '<span class="text-primary">
                            <i class="fa fa-comment" style="margin: 0px 3px;"></i>
                            '.ProblemComments::where('problem_id', $d->id)->count().'
                        </span>';
                })
                ->addColumn('problem', function($d){
                    return '
                        <p>
                            تصنيف الطلب :
                            <br />
                            '.$d->problem_type.'
                        </p>
                        <hr />

                        <p>
                            مضمون الطلب :
                            <br />
                            '.$d->problem.'
                        </p>
                    ';
                })
                ->addColumn('staff_id_date_reference', function($d){
                    if($d->staff_id === null){
                        return '';
                    }else{
                        return '
                        <p>
                            <i class="fa fa-user text-primary" style="margin: 0px 3px;">
                                <span>'. $d->staff['name'] .'</span>
                            </i>
                            <hr />
                            <i class="fa fa-calendar text-danger" style="margin: 0px 3px;">
                                <span>'. Carbon::parse($d->date_reference)->format('d-m-Y') .'</span>
                            </i>
                            <br />
                            <i class="fa fa-clock text-danger" style="margin: 0px 3px;">
                                <span>'. Carbon::parse($d->date_reference)->format('h:i') .'</span>
                            </i>
                        </p>
                        ';
                    }
                })
                ->addColumn('problem_rating', function($d){
                    $problem_rating = '';

                    if($d->problem_rating == 30){
                        $problem_rating = 'سهلة';
                    }elseif($d->problem_rating == 40){
                        $problem_rating = 'أقل من المتوسط';
                    }elseif($d->problem_rating == 50){
                        $problem_rating = 'متوسط';
                    }elseif($d->problem_rating == 90){
                        $problem_rating = 'صعبـة';
                    }elseif($d->problem_rating == 100){
                        $problem_rating = 'صعبـة جدآ';
                    }

                    return '
                        <select class="form-control change_problem_rating" res_id="'.$d->id.'">
                            <option value="">
                            </option>
                            <option value="30">
                                سهلة
                            </option>
                            <option value="40">
                                أقل من المتوسط
                            </option>
                            <option value="50">
                                متوسط
                            </option>
                            <option value="90">
                                صعبـة
                            </option>
                            <option value="100">
                                صعبـة جدآ
                            </option>
                            <option value="">
                                null
                            </option>
                        </select>

                        <p style="margin-top: 5px;font-weight: bold;">
                            <span class="badge badge-primary" style="font-size: 13px;">
                                '.$problem_rating.'
                            </span>
                        </p>
                    ';
                })
                ->addColumn('staff_rating', function($d){
                    $staff_rating = '';

                    if($d->staff_rating == 30){
                        $staff_rating = 'ضعيف جدآ';
                    }elseif($d->staff_rating == 40){
                        $staff_rating = 'ضعيف';
                    }elseif($d->staff_rating == 50){
                        $staff_rating = 'جيد';
                    }elseif($d->staff_rating == 90){
                        $staff_rating = 'جيد جدآ';
                    }elseif($d->staff_rating == 100){
                        $staff_rating = 'ممتاز';
                    }

                    return '
                        <select class="form-control change_staff_rating" res_id="'.$d->id.'">
                            <option value="">

                            </option>
                            <option value="30">ضعيف جدآ</option>
                            <option value="40">ضعيف</option>
                            <option value="50">جيد</option>
                            <option value="90">جيد جدآ</option>
                            <option value="100">ممتاز</option>
                            <option value="">null</option>
                        </select>

                        <p style="margin-top: 5px;font-weight: bold;">
                            <span class="badge badge-success" style="font-size: 13px;">
                                '.$staff_rating.'
                            </span>
                        </p>
                    ';
                })
                ->addColumn('problem_status', function($d){
                    return '
                        <select class="form-control change_problem_status" res_id="'.$d->id.'">
                            <option value="">

                            </option>
                            <option value="عاجل">
                                عاجل
                            </option>
                            <option value="جاري حلها">
                                جاري حلها
                            </option>
                            <option value="تم الإلغاء">
                                تم الإلغاء
                            </option>
                            <option value="تم حلها">
                                تم حلها
                            </option>
                            <option value="">
                                null
                            </option>
                        </select>

                        <p style="margin-top: 5px;font-weight: bold;">
                            <span class="badge badge-danger" style="font-size: 13px;">
                                '.$d->problem_status.'
                            </span>
                        </p>
                    ';
                })
                ->addColumn('created_at_ended_at', function($d){
                    if($d->ended_at === null){
                        return '
                            <p class="badge badge-primary text-center">
                                تاريخ إرسال الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('h:i') .'</span>
                            </p>
                        ';
                    }else{
                        return '
                            <p class="badge badge-primary text-center">
                                تاريخ إرسال الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('h:i') .'</span>
                            </p>

                            <p class="badge badge-danger text-center">
                                تاريخ غلق الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. Carbon::parse($d->ended_at)->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. Carbon::parse($d->ended_at)->format('h:i') .'</span>
                            </p>
                        ';
                    }
                })
                ->addColumn('action', function($d){
                    $buttons = '<a href="'.url('dashboard/parent_problems/edit/'.$d->id).'" class="text-muted option-dots2" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                    $buttons .= '<a res_id="'.$d->id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/parent_problems/reference/'.$d->id).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-user text-success"></i></a>';

                    $buttons .= '<a res_id="'.$d->id.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';

                    return $buttons;

                })
                ->rawColumns(['parent_id', 'problem', 'staff_id_date_reference', 'problem_rating', 'staff_rating', 'problem_status', 'created_at_ended_at', 'ended_at', 'action'])
                ->make(true);
            }else{

            }
        }


    // datatable_parent_problems_canceled
        public function datatable_parent_problems_canceled()
        {
            if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2 || auth()->user()->user_status == 4){
                $all = ParentProblems::where('problem_status' , 'تم الإلغاء')->get();
                return DataTables::of($all)
                ->addColumn('parent_id', function($d){
                    $parent_id = $d->parent['name'];
                    return $parent_id.
                        '<hr />'.
                        '<span class="text-primary">
                            <i class="fa fa-comment" style="margin: 0px 3px;"></i>
                            '.ProblemComments::where('problem_id', $d->id)->count().'
                        </span>';
                })
                ->addColumn('problem', function($d){
                    return '
                        <p>
                            تصنيف الطلب :
                            <br />
                            '.$d->problem_type.'
                        </p>
                        <hr />

                        <p>
                            مضمون الطلب :
                            <br />
                            '.$d->problem.'
                        </p>
                    ';
                })
                ->addColumn('staff_id_date_reference', function($d){
                    if($d->staff_id === null){
                        return '';
                    }else{
                        return '
                        <p>
                            <i class="fa fa-user text-primary" style="margin: 0px 3px;">
                                <span>'. $d->staff['name'] .'</span>
                            </i>
                            <hr />
                            <i class="fa fa-calendar text-danger" style="margin: 0px 3px;">
                                <span>'. Carbon::parse($d->date_reference)->format('d-m-Y') .'</span>
                            </i>
                            <br />
                            <i class="fa fa-clock text-danger" style="margin: 0px 3px;">
                                <span>'. Carbon::parse($d->date_reference)->format('h:i') .'</span>
                            </i>
                        </p>
                        ';
                    }
                })
                ->addColumn('problem_rating', function($d){
                    $problem_rating = '';

                    if($d->problem_rating == 30){
                        $problem_rating = 'سهلة';
                    }elseif($d->problem_rating == 40){
                        $problem_rating = 'أقل من المتوسط';
                    }elseif($d->problem_rating == 50){
                        $problem_rating = 'متوسط';
                    }elseif($d->problem_rating == 90){
                        $problem_rating = 'صعبـة';
                    }elseif($d->problem_rating == 100){
                        $problem_rating = 'صعبـة جدآ';
                    }

                    return '
                        <select class="form-control change_problem_rating" res_id="'.$d->id.'">
                            <option value="">
                            </option>
                            <option value="30">
                                سهلة
                            </option>
                            <option value="40">
                                أقل من المتوسط
                            </option>
                            <option value="50">
                                متوسط
                            </option>
                            <option value="90">
                                صعبـة
                            </option>
                            <option value="100">
                                صعبـة جدآ
                            </option>
                            <option value="">
                                null
                            </option>
                        </select>

                        <p style="margin-top: 5px;font-weight: bold;">
                            <span class="badge badge-primary" style="font-size: 13px;">
                                '.$problem_rating.'
                            </span>
                        </p>
                    ';
                })
                ->addColumn('staff_rating', function($d){
                    $staff_rating = '';

                    if($d->staff_rating == 30){
                        $staff_rating = 'ضعيف جدآ';
                    }elseif($d->staff_rating == 40){
                        $staff_rating = 'ضعيف';
                    }elseif($d->staff_rating == 50){
                        $staff_rating = 'جيد';
                    }elseif($d->staff_rating == 90){
                        $staff_rating = 'جيد جدآ';
                    }elseif($d->staff_rating == 100){
                        $staff_rating = 'ممتاز';
                    }

                    return '
                        <select class="form-control change_staff_rating" res_id="'.$d->id.'">
                            <option value="">

                            </option>
                            <option value="30">ضعيف جدآ</option>
                            <option value="40">ضعيف</option>
                            <option value="50">جيد</option>
                            <option value="90">جيد جدآ</option>
                            <option value="100">ممتاز</option>
                            <option value="">null</option>
                        </select>

                        <p style="margin-top: 5px;font-weight: bold;">
                            <span class="badge badge-success" style="font-size: 13px;">
                                '.$staff_rating.'
                            </span>
                        </p>
                    ';
                })
                ->addColumn('problem_status', function($d){
                    return '
                        <select class="form-control change_problem_status" res_id="'.$d->id.'">
                            <option value="">

                            </option>
                            <option value="عاجل">
                                عاجل
                            </option>
                            <option value="جاري حلها">
                                جاري حلها
                            </option>
                            <option value="تم الإلغاء">
                                تم الإلغاء
                            </option>
                            <option value="تم حلها">
                                تم حلها
                            </option>
                            <option value="">
                                null
                            </option>
                        </select>

                        <p style="margin-top: 5px;font-weight: bold;">
                            <span class="badge badge-danger" style="font-size: 13px;">
                                '.$d->problem_status.'
                            </span>
                        </p>
                    ';
                })
                ->addColumn('created_at_ended_at', function($d){
                    if($d->ended_at === null){
                        return '
                            <p class="badge badge-primary text-center">
                                تاريخ إرسال الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('h:i') .'</span>
                            </p>
                        ';
                    }else{
                        return '
                            <p class="badge badge-primary text-center">
                                تاريخ إرسال الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('h:i') .'</span>
                            </p>

                            <p class="badge badge-danger text-center">
                                تاريخ غلق الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. Carbon::parse($d->ended_at)->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. Carbon::parse($d->ended_at)->format('h:i') .'</span>
                            </p>
                        ';
                    }
                })
                ->addColumn('action', function($d){
                    $buttons = '<a href="'.url('dashboard/parent_problems/edit/'.$d->id).'" class="text-muted option-dots2" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                    $buttons .= '<a res_id="'.$d->id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/parent_problems/reference/'.$d->id).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-user text-success"></i></a>';

                    $buttons .= '<a res_id="'.$d->id.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';

                    return $buttons;

                })
                ->rawColumns(['parent_id', 'problem', 'staff_id_date_reference', 'problem_rating', 'staff_rating', 'problem_status', 'created_at_ended_at', 'ended_at', 'action'])
                ->make(true);
            }elseif(auth()->user()->user_status == 3){
                // $all = ParentProblems::where('TheName0', auth()->user()->name)->get();
                $all = ParentProblems::all();
                return DataTables::of($all)
                ->addColumn('problem', function($d){
                    return $d->problem;
                })
                ->addColumn('staff_id', function($d){
                    $staff_id = $d->staff['TheCity'];
                    return $staff_id;
                })
                ->addColumn('created_at', function($d){
                    return $d->TheDate1;
                })
                ->addColumn('action', function($d){
                    $buttons = '<a res_id="'.$d->ID.'" class="text-muted option-dots2" href="'.url('dashboard/ParentProblems/edit/'.$d->ID).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';
                    return $buttons;
                })
                ->rawColumns(['problem', 'staff_id', 'created_at', 'action'])
                ->make(true);
            }
        }


    // datatable_parent_problems_resolved
        public function datatable_parent_problems_resolved()
        {
            if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2 || auth()->user()->user_status == 4){
                $all = ParentProblems::where('problem_status' , 'تم حلها')->get();
                return DataTables::of($all)
                ->addColumn('parent_id', function($d){
                    $parent_id = $d->parent['name'];
                    return $parent_id.
                        '<hr />'.
                        '<span class="text-primary">
                            <i class="fa fa-comment" style="margin: 0px 3px;"></i>
                            '.ProblemComments::where('problem_id', $d->id)->count().'
                        </span>';
                })
                ->addColumn('problem', function($d){
                    return '
                        <p>
                            تصنيف الطلب :
                            <br />
                            '.$d->problem_type.'
                        </p>
                        <hr />

                        <p>
                            مضمون الطلب :
                            <br />
                            '.$d->problem.'
                        </p>
                    ';
                })
                ->addColumn('staff_id_date_reference', function($d){
                    if($d->staff_id === null){
                        return '';
                    }else{
                        return '
                        <p>
                            <i class="fa fa-user text-primary" style="margin: 0px 3px;">
                                <span>'. $d->staff['name'] .'</span>
                            </i>
                            <hr />
                            <i class="fa fa-calendar text-danger" style="margin: 0px 3px;">
                                <span>'. Carbon::parse($d->date_reference)->format('d-m-Y') .'</span>
                            </i>
                            <br />
                            <i class="fa fa-clock text-danger" style="margin: 0px 3px;">
                                <span>'. Carbon::parse($d->date_reference)->format('h:i') .'</span>
                            </i>
                        </p>
                        ';
                    }
                })
                ->addColumn('problem_rating', function($d){
                    $problem_rating = '';

                    if($d->problem_rating == 30){
                        $problem_rating = 'سهلة';
                    }elseif($d->problem_rating == 40){
                        $problem_rating = 'أقل من المتوسط';
                    }elseif($d->problem_rating == 50){
                        $problem_rating = 'متوسط';
                    }elseif($d->problem_rating == 90){
                        $problem_rating = 'صعبـة';
                    }elseif($d->problem_rating == 100){
                        $problem_rating = 'صعبـة جدآ';
                    }

                    return '
                        <select class="form-control change_problem_rating" res_id="'.$d->id.'">
                            <option value="">
                            </option>
                            <option value="30">
                                سهلة
                            </option>
                            <option value="40">
                                أقل من المتوسط
                            </option>
                            <option value="50">
                                متوسط
                            </option>
                            <option value="90">
                                صعبـة
                            </option>
                            <option value="100">
                                صعبـة جدآ
                            </option>
                            <option value="">
                                null
                            </option>
                        </select>

                        <p style="margin-top: 5px;font-weight: bold;">
                            <span class="badge badge-primary" style="font-size: 13px;">
                                '.$problem_rating.'
                            </span>
                        </p>
                    ';
                })
                ->addColumn('staff_rating', function($d){
                    $staff_rating = '';

                    if($d->staff_rating == 30){
                        $staff_rating = 'ضعيف جدآ';
                    }elseif($d->staff_rating == 40){
                        $staff_rating = 'ضعيف';
                    }elseif($d->staff_rating == 50){
                        $staff_rating = 'جيد';
                    }elseif($d->staff_rating == 90){
                        $staff_rating = 'جيد جدآ';
                    }elseif($d->staff_rating == 100){
                        $staff_rating = 'ممتاز';
                    }

                    return '
                        <select class="form-control change_staff_rating" res_id="'.$d->id.'">
                            <option value="">

                            </option>
                            <option value="30">ضعيف جدآ</option>
                            <option value="40">ضعيف</option>
                            <option value="50">جيد</option>
                            <option value="90">جيد جدآ</option>
                            <option value="100">ممتاز</option>
                            <option value="">null</option>
                        </select>

                        <p style="margin-top: 5px;font-weight: bold;">
                            <span class="badge badge-success" style="font-size: 13px;">
                                '.$staff_rating.'
                            </span>
                        </p>
                    ';
                })
                ->addColumn('problem_status', function($d){
                    return '
                        <select class="form-control change_problem_status" res_id="'.$d->id.'">
                            <option value="">

                            </option>
                            <option value="عاجل">
                                عاجل
                            </option>
                            <option value="جاري حلها">
                                جاري حلها
                            </option>
                            <option value="تم الإلغاء">
                                تم الإلغاء
                            </option>
                            <option value="تم حلها">
                                تم حلها
                            </option>
                            <option value="">
                                null
                            </option>
                        </select>

                        <p style="margin-top: 5px;font-weight: bold;">
                            <span class="badge badge-danger" style="font-size: 13px;">
                                '.$d->problem_status.'
                            </span>
                        </p>
                    ';
                })
                ->addColumn('created_at_ended_at', function($d){
                    if($d->ended_at === null){
                        return '
                            <p class="badge badge-primary text-center">
                                تاريخ إرسال الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('h:i') .'</span>
                            </p>
                        ';
                    }else{
                        return '
                            <p class="badge badge-primary text-center">
                                تاريخ إرسال الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. $d->created_at->format('h:i') .'</span>
                            </p>

                            <p class="badge badge-danger text-center">
                                تاريخ غلق الطلب:
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. Carbon::parse($d->ended_at)->format('d-m-Y') .'</span>
                                <br />
                                <span style="margin-top: 5px;font-size: 11px;">'. Carbon::parse($d->ended_at)->format('h:i') .'</span>
                            </p>
                        ';
                    }
                })
                ->addColumn('action', function($d){
                    $buttons = '<a href="'.url('dashboard/parent_problems/edit/'.$d->id).'" class="text-muted option-dots2" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                    $buttons .= '<a res_id="'.$d->id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/parent_problems/reference/'.$d->id).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-user text-success"></i></a>';

                    $buttons .= '<a res_id="'.$d->id.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';

                    return $buttons;

                })
                ->rawColumns(['parent_id', 'problem', 'staff_id_date_reference', 'problem_rating', 'staff_rating', 'problem_status', 'created_at_ended_at', 'ended_at', 'action'])
                ->make(true);
            }else{

            }
        }








    // Reports

        // between_dates report
        public function between_dates(){
            return view('back/parent_problems/report_between_dates');
        }

        public function between_dates_post(Request $request)
        {
            $find = ParentProblems::whereBetween('created_at' , [request('from'), request('to')])->get();
            $from = request('from');
            $to = request('to');
            return view('back/parent_problems/report_between_dates_posts', compact('find', 'from', 'to'));
        }



        // parent report
        public function parent(){
            $parents = Parents::all();
            return view('back/parent_problems/report_parent', compact('parents'));
        }

        public function parent_post(Request $request)
        {
            if(request('from') == null && request('to') == null){
                $find = ParentProblems::
                                    where('parent_id' , request('parent_id'))
                                    ->get();
                $from = '';
                $to = '';
            }elseif(request('from')){
                $find = ParentProblems::
                                    where('parent_id' , request('parent_id'))
                                    ->whereBetween('created_at' , [request('from'), Carbon::now()])
                                    ->get();
                $from = request('from');
                $to = Carbon::now();

            }elseif(request('to')){
                $find = ParentProblems::
                                    where('parent_id' , request('parent_id'))
                                    ->whereBetween('created_at' , [Carbon::now(), request('to')])
                                    ->get();

                $from = Carbon::now();
                $to = request('to');

            }else{
                $find = ParentProblems::
                                    where('parent_id' , request('parent_id'))
                                    ->whereBetween('created_at' , [request('from'), request('to')])
                                    ->get();
                $from = request('from');
                $to = request('to');

            }

            $first = User::where('id' , request('parent_id'))->first();

            return view('back/parent_problems/report_parent_post', compact('find', 'from', 'to', 'first'));
        }



        // staff report
        public function staff(){
            $staffs = User::
                        whereIn('user_status', [1,2,4])
                        ->orderBy('user_status', 'Desc')
                        ->get();
            return view('back/parent_problems/report_staff', compact('staffs'));
        }

        public function staff_post(Request $request)
        {
            if(request('staff_id') && request('from') == null && request('to') == null){
                $find = ParentProblems::
                                    where('staff_id' , request('staff_id'))
                                    ->get();

                $count_problems_assigned_to_staff = ParentProblems::
                                    where('staff_id' , request('staff_id'))
                                    ->count();

                $count_problems_between_dates = null;
                $percentage_of_assigned_tasks = null;
                $problems_ratings = null;
                $staff_ratings = null;

                $from = '';
                $to = '';
            }elseif(request('staff_id') && request('from') && request('to') == null){
                $find = ParentProblems::
                                    where('staff_id' , request('staff_id'))
                                    ->whereBetween('date_reference' , [request('from'), Carbon::now()])
                                    ->get();

                $count_problems_assigned_to_staff = ParentProblems::
                                    where('staff_id' , request('staff_id'))
                                    ->whereBetween('date_reference' , [request('from'), Carbon::now()])
                                    ->count();

                $problems_ratings = ParentProblems::
                                    where('staff_id' , request('staff_id'))
                                    ->whereBetween('date_reference' , [request('from'), Carbon::now()])
                                    ->sum('problem_rating');

                $staff_ratings = ParentProblems::
                                    where('staff_id' , request('staff_id'))
                                    ->whereBetween('date_reference' , [request('from'), Carbon::now()])
                                    ->sum('staff_rating');

                $count_problems_between_dates = ParentProblems::whereBetween('date_reference' , [request('from'), Carbon::now()])
                                    ->count();

                $percentage_of_assigned_tasks = $count_problems_assigned_to_staff == null ? null : sprintf("%.2f", ($count_problems_assigned_to_staff/$count_problems_between_dates)*100);

                $from = request('from');
                $to = Carbon::now();
            }elseif(request('staff_id') && request('from') == null && request('to')){
                $find = ParentProblems::
                                    where('staff_id' , request('staff_id'))
                                    ->whereBetween('date_reference' , [Carbon::now(), request('to')])
                                    ->get();

                $count_problems_assigned_to_staff = ParentProblems::
                                    where('staff_id' , request('staff_id'))
                                    ->whereBetween('date_reference' , [Carbon::now(), request('to')])
                                    ->count();

                $problems_ratings = ParentProblems::
                                    where('staff_id' , request('staff_id'))
                                    ->whereBetween('date_reference' , [Carbon::now(), request('to')])
                                    ->sum('problem_rating');

                $staff_ratings = ParentProblems::
                                    where('staff_id' , request('staff_id'))
                                    ->whereBetween('date_reference' , [Carbon::now(), request('to')])
                                    ->sum('staff_rating');

                $count_problems_between_dates = ParentProblems::whereBetween('date_reference' , [Carbon::now(), request('to')])
                                    ->count();

                $percentage_of_assigned_tasks = $count_problems_assigned_to_staff == null ? null : sprintf("%.2f", ($count_problems_assigned_to_staff/$count_problems_between_dates)*100);

                $from = Carbon::now();
                $to = request('to');
            }elseif(request('staff_id') && request('from') && request('to')){
                $find = ParentProblems::
                                    where('staff_id' , request('staff_id'))
                                    ->whereBetween('date_reference' , [request('from'), request('to')])
                                    ->get();

                $count_problems_assigned_to_staff = ParentProblems::
                                    where('staff_id' , request('staff_id'))
                                    ->whereBetween('date_reference' , [request('from'), request('to')])
                                    ->count();

                $problems_ratings = ParentProblems::
                                    where('staff_id' , request('staff_id'))
                                    ->whereBetween('date_reference' , [request('from'), request('to')])
                                    ->sum('problem_rating');

                $staff_ratings = ParentProblems::
                                    where('staff_id' , request('staff_id'))
                                    ->whereBetween('date_reference' , [request('from'), request('to')])
                                    ->sum('staff_rating');

                $count_problems_between_dates = ParentProblems::whereBetween('date_reference' , [request('from'), request('to')])
                                    ->count();

                $percentage_of_assigned_tasks = $count_problems_assigned_to_staff == null ? null : sprintf("%.2f", ($count_problems_assigned_to_staff/$count_problems_between_dates)*100);

                $from = request('from');
                $to = request('to');

            }

            $first = User::where('id' , request('staff_id'))->first();

            return view('back/parent_problems/report_staff_post', compact('find', 'from', 'to', 'first', 'count_problems_assigned_to_staff', 'count_problems_between_dates', 'percentage_of_assigned_tasks', 'problems_ratings', 'staff_ratings'));
        }

}
