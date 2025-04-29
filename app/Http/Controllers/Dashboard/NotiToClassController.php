<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\NotiToClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Input;
use DB;
use Str;
use Hash;

class NotiToClassController extends Controller
{

    public function index()
    {
        // $all = DB::table('noti_to_classes')
        //                 ->join('tbl_students_years_mat', 'tbl_students_years_mat.YearID', 'noti_to_classes.class_id')
        //                 ->join('tbl_years_mat', 'tbl_years_mat.ID', 'noti_to_classes.class_id')
        //                 ->join('users', 'users.id', 'noti_to_classes.sender')
        //                 ->join('tbl_students', 'tbl_students.ID', 'tbl_students_years_mat.StudentID')
        //                 ->join('tbl_parents', 'tbl_students.ParentID', 'tbl_parents.ID')
        //                 ->where('tbl_parents.ID', auth()->user()->id)
        //                 ->select('title', 'description', 'sender', 'created_at', 'class_id', 'TheFullName', 'name')

        //                 // ->distinct()
        //                 ->get();
        //                 dd($all);
        return view('back/noti_to_class/index');
    }

    public function create()
    {        
        $the_year = DB::table('tbl_students_years_mat')
                    ->join('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_students_years_mat.YearID')
                    ->select('YearID', 'TheMat', 'TheYear')
                    ->distinct('YearID')
                    ->get();

        return view('back.noti_to_class.add', compact('the_year'));
    }

    public function store(Request $request)
    {
        $get_group_id = NotiToclass::orderBy('id','DESC')->first();

        $request->validate([
           'class_id' => 'required',
           'title' => 'required|',
           'description' => 'required',
        ],[
            'class_id.required' => 'يجب إختيار صف دراسي واحد علي الأقل',
            'title.required' => 'عنوان الرسالة مطلوب',
            'description.required' => 'وصف الرسالة مطلوب',
        ]);
        
        for($i = 0; $i < count(request('class_id')); $i++){
            $resata[] = NotiToclass::insert([
                'class_id' => request('class_id')[$i],
                'group_id' => $get_group_id == null ? 1 : $get_group_id->group_id+1,
                'title' => request('title'),
                'description' => request('description'),
                'sender' => auth()->user()->id,
                'created_at' => date('Y-m-d h:i:s A'),
            ]);
        }
    }

    public function edit($id)
    {
        $the_year = DB::table('tbl_students_years_mat')
                    ->join('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_students_years_mat.YearID')
                    ->select('YearID', 'TheMat', 'TheYear')
                    ->distinct('YearID')
                    ->get();
                    
        $first = NotiToclass::where('id', $id)->first();
        return view('back.noti_to_class.edit', compact('first', 'the_year'));
    }
    
    public function edit_group_id($id)
    {
        $first = NotiToclass::where('group_id', $id)->first();
        $find = NotiToclass::where('group_id', $id)->get();
        $the_year = DB::table('tbl_students_years_mat')
                    ->join('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_students_years_mat.YearID')
                    ->select('YearID', 'TheMat', 'TheYear')
                    ->distinct('YearID')
                    ->get();

        return view('back.noti_to_class.edit_group_id', compact('first', 'find', 'the_year'));
    }

    public function update(Request $request, $id)
    {   
        $request->validate([
            'class_id' => 'required',
            'title' => 'required|',
            'description' => 'required',
         ],[
             'class_id.required' => 'يجب إختيار صف دراسي واحد علي الأقل',
             'title.required' => 'عنوان الرسالة مطلوب',
             'description.required' => 'وصف الرسالة مطلوب',
        ]);

        NotiToclass::where('id', $id)->update([
            'class_id' => request('class_id'),
            'title' => request('title'),
            'description' => request('description'),
            'sender' => auth()->user()->id,
            'status' => request('status'),
            'readed' => 2,
            'created_at' => date('Y-m-d h:i:s A'),
        ]);

    }
    
    public function update_group_id(Request $request, $id)
    {   
        $group_id_num = NotiToclass::where('group_id', $id)->first();
        $find = NotiToclass::where('group_id', $id)->delete();
            
        $request->validate([
           'class_id' => 'required',
           'title' => 'required|',
           'description' => 'required',
        ],[
            'class_id.required' => 'يجب إختيار صف دراسي واحد علي الأقل',
            'title.required' => 'عنوان الرسالة مطلوب',
            'description.required' => 'وصف الرسالة مطلوب',
        ]);

        for($i = 0; $i < count(request('class_id')); $i++){
            $resata[] = NotiToclass::insert([
                'class_id' => request('class_id')[$i],
                'group_id' => $group_id_num->group_id,
                'title' => request('title'),
                'description' => request('description'),
                'sender' => auth()->user()->id,
                'status' => request('status'),
                'readed' => 2,
                'created_at' => date('Y-m-d h:i:s A'),
            ]);
        }

    }

    public function destroy($id)
    {
        $find = NotiToclass::where('id', $id)->delete();
    }
    
    public function destroy_group_id($id)
    {
        $find = NotiToclass::where('group_id', $id)->delete();
    }

    public function change_readed($id)
    {
        NotiToclass::where('id', $id)->update(['readed' => 1]);
    }

    public function datatable_noti_to_class()
    {
        if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){
            $all = NotiToclass::all();
            return DataTables::of($all)
            ->addColumn('group_id', function($res){
                $group_id = "<span style='margin: 0px 10px;'>رقم المجموعة ".$res->group_id."<br />"."</span>";
                
                $group_id .= '<a res_id="'.$res->id.'" res_group_id="'.$res->group_id.'" class="text-muted option-dots2 delete_group_id" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash-alt" style="color: red;"></i></a>';
                
                $group_id .= '<a res_id="'.$res->id.'" res_group_id="'.$res->group_id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/noti_to_class/edit_group_id/'.$res->group_id).'" style="display: inline;margin: 0px 5px;"><i style="color: green;" class="fa fa-pen-alt"></i></a>';

                return $group_id;
            })
            ->addColumn('class_id', function($res){
                $class_id = $res->class_name['TheFullName'];
                return $class_id;
            })
            ->addColumn('title', function($res){
                if($res->readed == 1){
                    $title = '<span style="color: #777;" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="'.$res->title.'">'.Str::limit($res->title, 50).'</span>';
                    return $title;
                }else{
                    $title = '<span style="font-weight:bold;" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="'.$res->title.'">'.Str::limit($res->title, 50).'</span>';
                    return $title;
                }
            })
            ->addColumn('description', function($res){
                if($res->readed == 1){
                    $resescription = '<span style="color: #777;" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="'.$res->description.'">'.Str::limit($res->description, 100).'</span>';
                    return $resescription;
                }else{
                    $resescription = '<span style="font-weight:bold;" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="'.$res->description.'">'.Str::limit($res->description, 100).'</span>';
                    return $resescription;
                }
            })
            ->addColumn('sender', function($res){
                $sender = $res->sender_name['name'];
                return $sender;
            })
            ->addColumn('status', function($res){
                if($res->status == 1){
                    $status = '<span class="badge badge-success">مفعل</span>';
                }else{
                    $status = '<span class="badge badge-danger">غير مفعل</span>';
                }

                return $status;
            })
            ->addColumn('readed', function($res){
                if($res->readed == 1){
                    $readed = '<span class="badge badge-success">تمت القراءة</span>';
                }else{
                    $readed = '<span class="badge badge-danger">قي إنتظار القراءة</span>';
                }

                return $readed;
            })
            ->addColumn('created_at', function($res){
                return $res->created_at->format('d-m-Y')."<br>".$res->created_at->format('h:i:s A');
            })
            ->addColumn('action', function($res){
                $buttons = '<a res_id="'.$res->id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/noti_to_class/edit/'.$res->id).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                $buttons .= '<a res_id="'.$res->id.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';
                
                return $buttons;
            })
            ->rawColumns(['group_id', 'class_id', 'title', 'description', 'sender', 'status', 'readed', 'created_at', 'action'])
            ->make(true);
        }elseif(auth()->user()->user_status == 3){
            
            $all = DB::table('noti_to_classes')
                        ->join('tbl_students_years_mat', 'tbl_students_years_mat.YearID', 'noti_to_classes.class_id')
                        ->join('tbl_years_mat', 'tbl_years_mat.ID', 'noti_to_classes.class_id')
                        ->join('users', 'users.id', 'noti_to_classes.sender')
                        ->join('tbl_students', 'tbl_students.ID', 'tbl_students_years_mat.StudentID')
                        ->join('tbl_parents', 'tbl_students.ParentID', 'tbl_parents.ID')
                        ->where('tbl_parents.ID', auth()->user()->id)
                        ->select('title', 'description', 'sender', 'noti_to_classes.created_at', 'noti_to_classes.id', 'class_id', 'TheFullName', 'name', 'readed')

                        // ->distinct()
                        ->get();
            return DataTables::of($all)
            ->addColumn('class_id', function($res){
                $class_id = $res->TheFullName;
                return $class_id;
            })
            ->addColumn('title', function($res){
                if($res->readed == 1){
                    $title = '<span style="color: #777;" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="'.$res->title.'">'.Str::limit($res->title, 50).'</span>';
                    return $title;
                }else{
                    $title = '<span style="font-weight:bold;" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="'.$res->title.'">'.Str::limit($res->title, 50).'</span>';
                    return $title;
                }
            })
            ->addColumn('description', function($res){
                if($res->readed == 1){
                    $resescription = '<span style="color: #777;" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="'.$res->description.'">'.Str::limit($res->description, 100).'</span>';
                    return $resescription;
                }else{
                    $resescription = '<span style="font-weight:bold;" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="'.$res->description.'">'.Str::limit($res->description, 100).'</span>';
                    return $resescription;
                }
            })
            ->addColumn('sender', function($res){
                $sender = $res->name;
                return $sender;
            })
            ->addColumn('readed', function($res){
                if($res->readed == 1){
                    $readed = '<span class="badge badge-success">تمت القراءة</span>';
                }else{
                    $readed = '<span class="badge badge-danger">قي إنتظار القراءة</span>';
                }

                return $readed;
            })
            ->addColumn('created_at', function($res){
                return \Carbon\Carbon::parse($res->created_at)->format('d-m-Y')."<br>".\Carbon\Carbon::parse($res->created_at)->format('h:i:s A');
            })
            ->addColumn('action', function($res){
                $buttons = '<a res_id="'.$res->id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal change_readed" act="'.url('dashboard/noti_to_class/edit/'.$res->id).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-eye"></i></a>';
                
                return $buttons;
            })
            ->rawColumns(['class_id', 'title', 'description', 'sender', 'readed', 'created_at', 'action'])
            ->make(true);
        }
    }
}