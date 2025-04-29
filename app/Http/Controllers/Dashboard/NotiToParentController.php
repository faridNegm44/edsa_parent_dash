<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NotiToParent;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Input;
use DB;
use Str;
use Hash;

class NotiToParentController extends Controller
{

    public function index()
    {
        return view('back/noti_to_parent/index');
    }

    public function create()
    {        
        return view('back.noti_to_parent.add');
    }

    public function store(Request $request)
    {
        $get_group_id = NotiToParent::orderBy('id','DESC')->first();

        $request->validate([
           'parent_id' => 'required',
           'title' => 'required|',
           'description' => 'required',
        ],[
            'parent_id.required' => 'يجب إختيار ولي أمر واحد علي الأقل',
            'title.required' => 'عنوان الرسالة مطلوب',
            'description.required' => 'وصف الرسالة مطلوب',
        ]);
        
        for($i = 0; $i < count(request('parent_id')); $i++){
            $resata[] = NotiToParent::insert([
                'parent_id' => request('parent_id')[$i],
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
        $first = NotiToParent::where('id', $id)->first();
        return view('back.noti_to_parent.edit', compact('first'));
    }
    
    public function edit_group_id($id)
    {
        $first = NotiToParent::where('group_id', $id)->first();
        $find = NotiToParent::where('group_id', $id)->get();
        return view('back.noti_to_parent.edit_group_id', compact('first', 'find'));
    }

    public function update(Request $request, $id)
    {   
        $request->validate([
            'parent_id' => 'required',
            'title' => 'required|',
            'description' => 'required',
         ],[
             'parent_id.required' => 'يجب إختيار ولي أمر واحد علي الأقل',
             'title.required' => 'عنوان الرسالة مطلوب',
             'description.required' => 'وصف الرسالة مطلوب',
        ]);

        NotiToParent::where('id', $id)->update([
            'parent_id' => request('parent_id'),
            'title' => request('title'),
            'description' => request('description'),
            'sender' => auth()->user()->id,
            'readed' => 2,
            'status' => request('status'),
            'created_at' => date('Y-m-d h:i:s A'),
        ]);

    }
    
    public function update_group_id(Request $request, $id)
    {   
        $group_id_num = NotiToParent::where('group_id', $id)->first();
        $find = NotiToParent::where('group_id', $id)->delete();
            
        $request->validate([
           'parent_id' => 'required',
           'title' => 'required|',
           'description' => 'required',
        ],[
            'parent_id.required' => 'يجب إختيار ولي أمر واحد علي الأقل',
            'title.required' => 'عنوان الرسالة مطلوب',
            'description.required' => 'وصف الرسالة مطلوب',
        ]);

        for($i = 0; $i < count(request('parent_id')); $i++){
            $resata[] = NotiToParent::insert([
                'parent_id' => request('parent_id')[$i],
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
        $find = NotiToParent::where('id', $id)->delete();
    }
    
    public function destroy_group_id($id)
    {
        $find = NotiToParent::where('group_id', $id)->delete();
    }

    public function change_readed($id)
    {
        NotiToParent::where('id', $id)->update(['readed' => 1]);
    }

    public function datatable_noti_to_parent()
    {
        if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){
            $all = NotiToParent::all();
            return DataTables::of($all)
            ->addColumn('group_id', function($res){
                $group_id = "<span style='margin: 0px 10px;'>رقم المجموعة ".$res->group_id."<br />"."</span>";
                
                $group_id .= '<a res_id="'.$res->id.'" res_group_id="'.$res->group_id.'" class="text-muted option-dots2 delete_group_id" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash-alt" style="color: red;"></i></a>';
                
                $group_id .= '<a res_id="'.$res->id.'" res_group_id="'.$res->group_id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/noti_to_parent/edit_group_id/'.$res->group_id).'" style="display: inline;margin: 0px 5px;"><i style="color: green;" class="fa fa-pen-alt"></i></a>';

                return $group_id;
            })
            ->addColumn('parent_id', function($res){
                $parent_id = $res->parent_name['TheName0'];
                return $parent_id;
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
                $buttons = '<a res_id="'.$res->id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/noti_to_parent/edit/'.$res->id).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                $buttons .= '<a res_id="'.$res->id.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';
                
                return $buttons;
            })
            ->rawColumns(['group_id', 'parent_id', 'title', 'description', 'sender', 'status', 'readed', 'created_at', 'action'])
            ->make(true);
        }elseif(auth()->user()->user_status == 3){
            
            $all = NotiToParent::where('parent_id', auth()->user()->id)->where('status', 1)->get();
            return DataTables::of($all)
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
                $buttons = '<a res_id="'.$res->id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal change_readed" act="'.url('dashboard/noti_to_parent/edit/'.$res->id).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-eye"></i></a>';
                
                return $buttons;
            })
            ->rawColumns(['title', 'description', 'sender', 'readed', 'created_at', 'action'])
            ->make(true);
        }
    }
}