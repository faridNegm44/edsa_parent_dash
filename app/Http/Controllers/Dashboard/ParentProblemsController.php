<?php

namespace App\Http\Controllers\Dashboard;

use DB;
use File;
use Hash;
use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Parents;
use Illuminate\Http\Request;
use App\Models\ParentProblems;
use App\Models\ProblemComments;
use App\Http\Controllers\Controller;
use App\Models\ProblemType;
use Illuminate\Support\Facades\Input;
use PHPUnit\Util\Json;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\ParentProblemDatatableTrait;

class ParentProblemsController extends Controller
{

    use ParentProblemDatatableTrait;


    public function index(){
        return view('back.parent_problems.index');
    }

    public function create(){
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

        if(auth()->user()->user_status == 1){
            $created_at = request('created_at') == null ? date('Y-m-d h:i:s') : request('created_at');
            $date_reference = null;

        }elseif(auth()->user()->user_status == 2){
            $created_at = request('created_at') == null ? date('Y-m-d h:i:s') : request('created_at');
            $date_reference = Carbon::now();
            $getRateProblemType = DB::table('problem_types')->where('id', request('problem_type'))->first();

        }else{
            $created_at = Carbon::now();
            $date_reference = null;
            $getRateProblemType = DB::table('problem_types')->where('id', request('problem_type'))->first();
        }

        ParentProblems::create([
            'problem_type' => request('problem_type'),
            'problem' => request('problem'),
            'parent_id' => request('parent_id'),
            'staff_id' => request('parent_id') == auth()->user()->id ? null : auth()->user()->id,
            'date_reference' => $date_reference,
            'created_at' => $created_at,
            'problem_rating' => request('problem_rating') ?? $getRateProblemType->rate,
        ]);

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

        $find = ParentProblems::where('id', $id)->first();

        $created_at = "";
        if(auth()->user()->user_status == 1){
            $created_at = request('created_at') == null ? date('Y-m-d h:i:s') : request('created_at');
        }else{
            $created_at = $find['created_at'];
        }

        $ended_at = "";
        if(auth()->user()->user_status == 1){
            $ended_at = request('ended_at') == null ? null : request('ended_at');
        }else{
            $ended_at = $find['ended_at'];
        }

        ParentProblems::where('id', $id)->update([
            'problem_type' => request('problem_type'),
            'problem' => request('problem'),
            'parent_id' => request('parent_id'),
            'readed' =>  auth()->user()->user_status == 3 ? 0 : request('readed'),
            'created_at' => $created_at,
            'ended_at' => $ended_at,
            'problem_status' => request('ended_at') == null ? null : 'تم حلها',
        ]);
   }

    public function destroy($id)
    {

        DB::transaction(function() use($id){
            ParentProblems::where('id', $id)->delete();
            ProblemComments::where('problem_id', $id)->delete();
        });

    }




    public function get_problem_rating($id)
    {
        $find = ProblemType::where('id', $id)->first();
        return response()->json($find);
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
            if(request('deadline') == null){
                $request->validate([
                    'staff_id' => 'required',
                ],[
                    'staff_id.required' => 'الإسم الأول مطلوب',
                ]);
            }elseif(request('staff_id') != null){
                $request->validate([
                    'staff_id' => 'required',
                    'date_reference' => 'required',
                    'deadline' => 'after:date_reference',

                ],[
                    'staff_id.required' => 'الإسم الأول مطلوب',
                    'date_reference.required' => 'تاريخ الإسناد مطلوب أولا ',
                    'deadline.after' => 'يجب أن يكون تاريخ تسليم الطلب بعد تاريخ الإسناد',
                ]);
            }

            $date_reference = "";
            if(auth()->user()->user_status == 1){
                $date_reference = request('date_reference') == null ? date('Y-m-d h:i:s') : request('date_reference');
            }else{
                $date_reference = Carbon::now();
            }

            $deadline = "";
            if(auth()->user()->user_status == 1){
                $deadline = request('deadline') == null ? null : request('deadline');
            }else{
                $deadline = null;
            }

            ParentProblems::where('id', $id)->update([
                'staff_id' => request('staff_id'),
                'date_reference' => $date_reference,
                'deadline' => $deadline,
            ]);

        }

    // reference area end








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
    // update_problem_rating  //  update_problem_status  //  update_staff_rating end







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
        if(auth()->user()->user_status == 1){
            $all = ParentProblems::all();
            return DataTables::of($all)
            ->addColumn('parent_id', function($d){
                $parent_id = $d->parent['name'];
                $readed = $d->readed == 1 ? 'تمت القراءة' : '' ;

                return $parent_id.
                    '<div class="text-primary" style="margin: 10px 0px 0px;>
                        <i class="fa fa-comment" style="margin: 0px 3px;"></i>
                        '.ProblemComments::where('problem_id', $d->id)->count().'
                    </div>'.
                    '<div style="text-decoration: underline;color: red;font-weight: bold;">
                        '.$readed.'
                    </div>';
            })
            ->addColumn('problem', function($d){
                $deadline = new DateTime($d->deadline);
                $noow = $deadline->diff(new DateTime(Carbon::now()));

                if(Carbon::now() > $d->deadline && $d->deadline != null){
                    return '
                        <div>
                            <div style="background: #E5DDC8;width: 100%;">
                                '.$d->problem_type_relation['name'].'
                            </div>
                            <div style="background: #B5E5CF;" data-toggle="tooltip" data-placement="top" title="'.$d->problem.'">
                                '.mb_strimwidth($d->problem, 0, 60).'
                            </div>
                        </div>

                        <div class="counters_class" style="margin: 3px auto 0px;width: 90%;">
                            <div class="row">
                                <div class="col-md-3 seconds" style="background: #65463E; color: #fff;">
                                    <label for="">انتهي</label>
                                    <div><i class="fa fa-check"></i></div>
                                </div>
                                <div class="col-md-3 minutes" style="background: #94C973; color: #fff;opacity: .3;">
                                    <label for="">دقايق</label>
                                    <p>-</p>
                                </div>
                                <div class="col-md-3 hours" style="background: #FFB85D; color: #fff;opacity: .3;">
                                    <label for="">ساعات</label>
                                    <p>-</p>
                                </div>
                                <div class="col-md-3 days" style="background: #D48C70; color: #fff;opacity: .3;">
                                    <label for="">ايام</label>
                                    <p>-</p>
                                </div>
                            </div>
                        </div>
                    ';
                }elseif($d->deadline === null){
                    return '
                        <div>
                            <div style="background: #E5DDC8;width: 100%;">
                                '.$d->problem_type_relation['name'].'
                            </div>
                            <div style="background: #B5E5CF;" data-toggle="tooltip" data-placement="top" title="'.$d->problem.'">
                                '.mb_strimwidth($d->problem, 0, 60).'
                            </div>
                        </div>
                    ';
                }else{
                    return '
                        <div>
                            <div style="background: #E5DDC8;width: 100%;">
                                '.$d->problem_type_relation['name'].'
                            </div>
                            <div style="background: #B5E5CF;" data-toggle="tooltip" data-placement="top" title="'.$d->problem.'">
                                '.mb_strimwidth($d->problem, 0, 60).'
                            </div>
                        </div>

                        <div class="counters_class" style="margin: 3px auto 0px;width: 90%;">
                            <div class="row">
                                <div class="col-md-3 seconds" style="background: #65463E; color: #fff;">
                                    <label for="">انتهي</label>
                                    <div><i class="fa fa-times"></i></div>
                                </div>
                                <div class="col-md-3 minutes" style="background: #94C973; color: #000;">
                                    <label for="">دقايق</label>
                                    <p>'.$noow->i.'</p>
                                </div>
                                <div class="col-md-3 hours" style="background: #FFB85D; color: #000;">
                                    <label for="">ساعات</label>
                                    <p>'.$noow->h.'</p>
                                </div>
                                <div class="col-md-3 days" style="background: #D48C70; color: #000;">
                                    <label for="">ايام</label>
                                    <p>'.$noow->d.'</p>
                                </div>
                            </div>
                        </div>
                    ';
                }
            })
            ->addColumn('staff_id_date_reference', function($d){
                if(!$d->date_reference){
                    return '';
    
                }elseif($d->date_reference && !$d->deadline){
                    return '
                        <p>
                            <div style="margin: 0px 3px;font-weight:bold;background: #E7F2F8;">
                                <span>'. $d->staff['name'] .'</span>
                            </div>
    
                            <div>
                                <div style="margin: 2px 3px 0px;font-weight:bold;background: #EFE7BC;">
                                    <span>'. Carbon::parse($d->date_reference)->format('d-m-Y') .'</span>
                                </div>
                                <div style="margin: 0px 3px;font-weight:bold;background: #EFE7BC;">
                                    <span>'. Carbon::parse($d->date_reference)->format('h:i a') .'</span>
                                </div>
                            </div>
                        </p>
                    ';
    
                }elseif($d->date_reference && $d->deadline){
                    return '
                        <p>
                            <div style="margin: 0px 3px;font-weight:bold;background: #E7F2F8;">
                                <span>'. $d->staff['name'] .'</span>
                            </div>
    
                            <div>
                                <div style="margin: 2px 3px 0px;font-weight:bold;background: #EFE7BC;">
                                    <span>'. Carbon::parse($d->date_reference)->format('d-m-Y') .'</span>
                                </div>
                                <div style="margin: 0px 3px;font-weight:bold;background: #EFE7BC;">
                                    <span>'. Carbon::parse($d->date_reference)->format('h:i a') .'</span>
                                </div>
                            </div>
    
                            <div>
                                <div style="margin: 0px 3px;font-weight:bold;background: #B4AAA9;color: #FFF;">
                                    <span>'. Carbon::parse($d->deadline)->format('d-m-Y') .'</span>
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div style="margin: 0px 3px;font-weight:bold;background: #B4AAA9;color: #FFF;">
                                    <span>'. Carbon::parse($d->deadline)->format('h:i a') .'</span>
                                </div>
                            </div>
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
                if(auth()->user()->user_status == 1){
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
    
                }else{
                    if($d->problem_status == 'تم حلها' || $d->problem_status == 'تم الإلغاء'){
                        return '
                            <p style="margin-top: 5px;font-weight: bold;">
                                <span class="badge badge-danger" style="font-size: 13px;">
                                    '.$d->problem_status.'
                                </span>
                            </p>
                        ';
    
                    }else{
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
                    }
                }
            })
            ->addColumn('created_at_ended_at', function($d){
                if($d->ended_at === null){
                    return '
                        <div class="text-center" style="padding: 10px;border-radius: 5px;width: 100px;margin-bottom: 7px;font-weight: bold;text-decoration: underline;x">'
                            . $d->created_at->format('d-m-Y') .
                            '<br />'
                            . $d->created_at->format('h:i a') .
                        '</div>
                    ';
                }else{
                    return '
                        <div class="text-center" style="padding: 10px;border-radius: 5px;width: 100px;margin-bottom: 7px;font-weight: bold;text-decoration: underline;x">'
                            . $d->created_at->format('d-m-Y') .
                            '<br />'
                            . $d->created_at->format('h:i a') .
                        '</div>

                        <div class="text-center" style="background: #E57F84;color: #fff;border-radius: 5px;width: 100px;padding: 8px 10px 1px;font-weight: bold;">'
                            . Carbon::parse($d->ended_at)->format('d-m-Y') .
                            '<br />'
                            . Carbon::parse($d->ended_at)->format('h:i a') .
                        '</p>
                    ';
                }
            })
            ->addColumn('action', function($d){
                $buttons = '<a href="'.url('dashboard/parent_problems/edit/'.$d->id).'" class="text-muted option-dots2" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                $buttons .= '<a res_id="'.$d->id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/parent_problems/reference/'.$d->id).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-user text-success"></i></a>';

                if(auth()->user()->user_status == 1){
                    $buttons .= '<a res_id="'.$d->id.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';
                }

                return $buttons;

            })
            ->rawColumns(['parent_id', 'problem', 'staff_id_date_reference', 'problem_rating', 'staff_rating', 'problem_status', 'created_at_ended_at', 'ended_at', 'action'])
            ->make(true);

        }elseif(auth()->user()->user_status == 2 || auth()->user()->user_status == 4){
            $all = ParentProblems::where('staff_id', auth()->user()->id)->orWhere('staff_id', null)->get();
            return DataTables::of($all)
            ->addColumn('parent_id', function($d){
                $parent_id = $d->parent['name'];
                $readed = $d->readed == 1 ? 'تمت القراءة' : '' ;

                return $parent_id.
                    '<div class="text-primary" style="margin: 10px 0px 0px;>
                        <i class="fa fa-comment" style="margin: 0px 3px;"></i>
                        '.ProblemComments::where('problem_id', $d->id)->count().'
                    </div>'.
                    '<div style="text-decoration: underline;color: red;font-weight: bold;">
                        '.$readed.'
                    </div>';
            })
            ->addColumn('problem', function($d){
                $deadline = new DateTime($d->deadline);
                $noow = $deadline->diff(new DateTime(Carbon::now()));

                if(Carbon::now() > $d->deadline && $d->deadline != null){
                    return '
                        <div>
                            <div style="background: #E5DDC8;width: 100%;">
                                '.$d->problem_type_relation['name'].'
                            </div>
                            <div style="background: #B5E5CF;" data-toggle="tooltip" data-placement="top" title="'.$d->problem.'">
                                '.mb_strimwidth($d->problem, 0, 60).'
                            </div>
                        </div>

                        <div class="counters_class" style="margin: 3px auto 0px;width: 90%;">
                            <div class="row">
                                <div class="col-md-3 seconds" style="background: #65463E; color: #fff;">
                                    <label for="">انتهي</label>
                                    <div><i class="fa fa-check"></i></div>
                                </div>
                                <div class="col-md-3 minutes" style="background: #94C973; color: #fff;opacity: .3;">
                                    <label for="">دقايق</label>
                                    <p>-</p>
                                </div>
                                <div class="col-md-3 hours" style="background: #FFB85D; color: #fff;opacity: .3;">
                                    <label for="">ساعات</label>
                                    <p>-</p>
                                </div>
                                <div class="col-md-3 days" style="background: #D48C70; color: #fff;opacity: .3;">
                                    <label for="">ايام</label>
                                    <p>-</p>
                                </div>
                            </div>
                        </div>
                    ';
                }elseif($d->deadline === null){
                    return '
                        <div>
                            <div style="background: #E5DDC8;width: 100%;">
                                '.$d->problem_type_relation['name'].'
                            </div>
                            <div style="background: #B5E5CF;" data-toggle="tooltip" data-placement="top" title="'.$d->problem.'">
                                '.mb_strimwidth($d->problem, 0, 60).'
                            </div>
                        </div>
                    ';
                }else{
                    return '
                        <div>
                            <div style="background: #E5DDC8;width: 100%;">
                                '.$d->problem_type_relation['name'].'
                            </div>
                            <div style="background: #B5E5CF;" data-toggle="tooltip" data-placement="top" title="'.$d->problem.'">
                                '.mb_strimwidth($d->problem, 0, 60).'
                            </div>
                        </div>

                        <div class="counters_class" style="margin: 3px auto 0px;width: 90%;">
                            <div class="row">
                                <div class="col-md-3 seconds" style="background: #65463E; color: #fff;">
                                    <label for="">انتهي</label>
                                    <div><i class="fa fa-times"></i></div>
                                </div>
                                <div class="col-md-3 minutes" style="background: #94C973; color: #000;">
                                    <label for="">دقايق</label>
                                    <p>'.$noow->i.'</p>
                                </div>
                                <div class="col-md-3 hours" style="background: #FFB85D; color: #000;">
                                    <label for="">ساعات</label>
                                    <p>'.$noow->h.'</p>
                                </div>
                                <div class="col-md-3 days" style="background: #D48C70; color: #000;">
                                    <label for="">ايام</label>
                                    <p>'.$noow->d.'</p>
                                </div>
                            </div>
                        </div>
                    ';
                }
            })
            ->addColumn('staff_id_date_reference', function($d){
                if(!$d->date_reference){
                    return '';
    
                }elseif($d->date_reference && !$d->deadline){
                    return '
                        <p>
                            <div style="margin: 0px 3px;font-weight:bold;background: #E7F2F8;">
                                <span>'. $d->staff['name'] .'</span>
                            </div>
    
                            <div>
                                <div style="margin: 2px 3px 0px;font-weight:bold;background: #EFE7BC;">
                                    <span>'. Carbon::parse($d->date_reference)->format('d-m-Y') .'</span>
                                </div>
                                <div style="margin: 0px 3px;font-weight:bold;background: #EFE7BC;">
                                    <span>'. Carbon::parse($d->date_reference)->format('h:i a') .'</span>
                                </div>
                            </div>
                        </p>
                    ';
    
                }elseif($d->date_reference && $d->deadline){
                    return '
                        <p>
                            <div style="margin: 0px 3px;font-weight:bold;background: #E7F2F8;">
                                <span>'. $d->staff['name'] .'</span>
                            </div>
    
                            <div>
                                <div style="margin: 2px 3px 0px;font-weight:bold;background: #EFE7BC;">
                                    <span>'. Carbon::parse($d->date_reference)->format('d-m-Y') .'</span>
                                </div>
                                <div style="margin: 0px 3px;font-weight:bold;background: #EFE7BC;">
                                    <span>'. Carbon::parse($d->date_reference)->format('h:i a') .'</span>
                                </div>
                            </div>
    
                            <div>
                                <div style="margin: 0px 3px;font-weight:bold;background: #B4AAA9;color: #FFF;">
                                    <span>'. Carbon::parse($d->deadline)->format('d-m-Y') .'</span>
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div style="margin: 0px 3px;font-weight:bold;background: #B4AAA9;color: #FFF;">
                                    <span>'. Carbon::parse($d->deadline)->format('h:i a') .'</span>
                                </div>
                            </div>
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
                    <p style="margin-top: 5px;font-weight: bold;">
                        <span class="badge badge-success" style="font-size: 13px;">
                            '.$staff_rating.'
                        </span>
                    </p>
                ';
            })
            ->addColumn('problem_status', function($d){
                if(auth()->user()->user_status == 1){
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
    
                }else{
                    if($d->problem_status == 'تم حلها' || $d->problem_status == 'تم الإلغاء'){
                        return '
                            <p style="margin-top: 5px;font-weight: bold;">
                                <span class="badge badge-danger" style="font-size: 13px;">
                                    '.$d->problem_status.'
                                </span>
                            </p>
                        ';
    
                    }else{
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
                    }
                }
            })
            ->addColumn('created_at_ended_at', function($d){
                if($d->ended_at === null){
                    return '
                        <div class="text-center" style="padding: 10px;border-radius: 5px;width: 100px;margin-bottom: 7px;font-weight: bold;text-decoration: underline;x">'
                            . $d->created_at->format('d-m-Y') .
                            '<br />'
                            . $d->created_at->format('h:i a') .
                        '</div>
                    ';
                }else{
                    return '
                        <div class="text-center" style="padding: 10px;border-radius: 5px;width: 100px;margin-bottom: 7px;font-weight: bold;text-decoration: underline;x">'
                            . $d->created_at->format('d-m-Y') .
                            '<br />'
                            . $d->created_at->format('h:i a') .
                        '</div>

                        <div class="text-center" style="background: #E57F84;color: #fff;border-radius: 5px;width: 100px;padding: 8px 10px 1px;font-weight: bold;">'
                            . Carbon::parse($d->ended_at)->format('d-m-Y') .
                            '<br />'
                            . Carbon::parse($d->ended_at)->format('h:i a') .
                        '</p>
                    ';
                }
            })
            ->addColumn('action', function($d){
                $buttons = '<a href="'.url('dashboard/parent_problems/edit/'.$d->id).'" class="text-muted option-dots2" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                if($d->staff_id == null){
                    $buttons .= '<a res_id="'.$d->id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/parent_problems/reference/'.$d->id).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-user text-success"></i></a>';
                }
                if(auth()->user()->user_status == 1){
                    $buttons .= '<a res_id="'.$d->id.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';
                }

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
                    <div>
                        <div style="background: #E5DDC8;width: 100%;padding: 10px;">
                            '.$d->problem_type_relation['name'].'
                        </div>
                        <div style="background: #B5E5CF;padding: 10px;" data-toggle="tooltip" data-placement="top" title="'.$d->problem.'">
                            '.mb_strimwidth($d->problem, 0, 60).'
                        </div>
                    </div>
                ';
            })
            ->addColumn('staff_id_date_reference', function($d){
                if(!$d->date_reference){
                    return '';
    
                }elseif($d->date_reference && !$d->deadline){
                    return '
                        <p>
                            <div style="margin: 0px 3px;font-weight:bold;background: #E7F2F8;">
                                <span>'. $d->staff['name'] .'</span>
                            </div>
    
                            <div>
                                <div style="margin: 2px 3px 0px;font-weight:bold;background: #EFE7BC;">
                                    <span>'. Carbon::parse($d->date_reference)->format('d-m-Y') .'</span>
                                </div>
                                <div style="margin: 0px 3px;font-weight:bold;background: #EFE7BC;">
                                    <span>'. Carbon::parse($d->date_reference)->format('h:i a') .'</span>
                                </div>
                            </div>
                        </p>
                    ';
    
                }elseif($d->date_reference && $d->deadline){
                    return '
                        <p>
                            <div style="margin: 0px 3px;font-weight:bold;background: #E7F2F8;">
                                <span>'. $d->staff['name'] .'</span>
                            </div>
    
                            <div>
                                <div style="margin: 2px 3px 0px;font-weight:bold;background: #EFE7BC;">
                                    <span>'. Carbon::parse($d->date_reference)->format('d-m-Y') .'</span>
                                </div>
                                <div style="margin: 0px 3px;font-weight:bold;background: #EFE7BC;">
                                    <span>'. Carbon::parse($d->date_reference)->format('h:i a') .'</span>
                                </div>
                            </div>
    
                            <div>
                                <div style="margin: 0px 3px;font-weight:bold;background: #B4AAA9;color: #FFF;">
                                    <span>'. Carbon::parse($d->deadline)->format('d-m-Y') .'</span>
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div style="margin: 0px 3px;font-weight:bold;background: #B4AAA9;color: #FFF;">
                                    <span>'. Carbon::parse($d->deadline)->format('h:i a') .'</span>
                                </div>
                            </div>
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
                        <div class="text-center" style="padding: 10px;border-radius: 5px;width: 100px;margin-bottom: 7px;font-weight: bold;text-decoration: underline;x">'
                            . $d->created_at->format('d-m-Y') .
                            '<br />'
                            . $d->created_at->format('h:i a') .
                        '</div>
                    ';
                }else{
                    return '
                        <div class="text-center" style="padding: 10px;border-radius: 5px;width: 100px;margin-bottom: 7px;font-weight: bold;text-decoration: underline;x">'
                            . $d->created_at->format('d-m-Y') .
                            '<br />'
                            . $d->created_at->format('h:i a') .
                        '</div>

                        <div class="text-center" style="background: #E57F84;color: #fff;border-radius: 5px;width: 100px;padding: 8px 10px 1px;font-weight: bold;">'
                            . Carbon::parse($d->ended_at)->format('d-m-Y') .
                            '<br />'
                            . Carbon::parse($d->ended_at)->format('h:i a') .
                        '</p>
                    ';
                }
            })
            ->addColumn('action', function($d){
                $buttons = '<a href="'.url('dashboard/parent_problems/edit/'.$d->id).'" class="text-muted option-dots2" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                if(auth()->user()->user_status == 1){
                    $buttons .= '<a res_id="'.$d->id.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';
                }

                return $buttons;

            })
            ->rawColumns(['comments_count', 'problem', 'staff_id_date_reference', 'problem_status', 'created_at_ended_at', 'action'])
            ->make(true);
        }
    }
    // all datatable end






    // datatable_parent_problems_urgent     عااااااااجل
    public function datatable_parent_problems_urgent(){
        return $this->getParentProblemDatatable('عاجل');
    }
    // datatable_parent_problems_urgent end


    // datatable_parent_problems_waiting     جااااااري حلها
    public function datatable_parent_problems_waiting(){
        return $this->getParentProblemDatatable('جاري حلها');
    }
    // datatable_parent_problems_waiting end


    // datatable_parent_problems_canceled     تم الإلغاااااء
    public function datatable_parent_problems_canceled(){
        return $this->getParentProblemDatatable('تم الإلغاء');
    }
    // datatable_parent_problems_canceled end


    // datatable_parent_problems_resolved     تم حلهااااااا
    public function datatable_parent_problems_resolved(){
        return $this->getParentProblemDatatable('تم حلها');
    }
    // datatable_parent_problems_resolved end



    // datatable_parent_problems_deadline      ديدلاااااااااين
    public function datatable_parent_problems_deadline(){
        return $this->getParentProblemDatatable(null, true);
    }
    // datatable_parent_problems_deadline end











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
    // Report end
}

