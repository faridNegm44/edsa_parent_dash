<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Input;
use DB;
use Hash;

class UserController extends Controller
{

    public function index()
    {
        return view('back.user.index');
    }

    public function create()
    {
        return view('back/user/add');
    }

    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required',
           'email' => 'required|unique:users,email',
           'password' => 'required|min:5',
           'confirm_password' => 'required|same:password',
        ],[
            'name.required' => 'الإسم الأول مطلوب',
            'email.unique' => 'البريد الإلكتروني مطلوب',
            'email.unique' => 'البريد الإلكتروني مستخدم من قبل',
            'password.required' => 'الرقم السري مطلوب',
            'password.min' => 'يجب أن يكون طول نص الرقم السري على الأقل 5 حروفٍ/حرفًا',
            'confirm_password.required' => 'تأكيد الرقم السري مطلوب',
            'confirm_password.same' => 'تأكيد الرقم السري يجب أن يكون مطابق للرقم السري',
        ]);

        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'user_status' => request('user_status'),
        ]);

    }

    public function show(students $students)
    {
        //
    }

    public function edit($id)
    {
        $find = User::where('id', $id)->first();
        return view('back.user.edit', compact('find'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            // 'password' => 'min:5',
            'confirm_password' => 'same:password',
         ],[
             'name.required' => 'الإسم الأول مطلوب',
             'email.unique' => 'البريد الإلكتروني مطلوب',
             'email.unique' => 'البريد الإلكتروني مستخدم من قبل',
             'confirm_password.same' => 'تأكيد الرقم السري يجب أن يكون مطابق للرقم السري',
         ]);

        User::where('id', $id)->update([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password') == null ? request('old_password') : Hash::make(request('password')),
            'user_status' => request('user_status'),
        ]);

   }

    public function destroy($id)
    {
        $find = User::where('id', $id)->delete();
    }


    public function datatable_users()
    {
        $all = User::where('user_status', 1)->orWhere('user_status', 2)->orWhere('user_status', 4)->get();
        return DataTables::of($all)
        ->addColumn('name', function($d){
            $name = $d->name;
            return $name;
        })
        ->addColumn('email', function($d){
            $email = $d->email;
            return $email;
        })
        ->addColumn('status', function($d){
            if($d->user_status == 1){
                return '<span class="badge badge-danger">سوبر أدمن</span>';
            }elseif($d->user_status == 2){
                return '<span class="badge badge-success">أدمن</span>';
            }elseif($d->user_status == 4){
                return '<span class="badge badge-warning">موظف</span>';
            }
        })
        //->addColumn('created_at', function($d){
        //    return $d->created_at->format('Y-m-d  -  h:i ');
        //})
        ->addColumn('action', function($d){
            if(auth()->user()->user_status == 1){
                $buttons = '<a res_id="'.$d->id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/users/edit/'.$d->id).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                $buttons .= '<a res_id="'.$d->id.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';

                return $buttons;
            }
        })
        ->rawColumns(['name', 'email', 'status', 'action'])
        ->make(true);
    }
}
