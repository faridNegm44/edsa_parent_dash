<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parents;
use App\Models\User;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Hash;

class ParentController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['verified']);
    // }

    public function sendEmail()
    {
        $details = [
            'title' => 'Title ......',
            'body' => 'Body ......',
        ];

        Mail::to('faridnegm44@gmail.com')->send(new TestMail());
    }
   
    public function index()
    {
        return view('back.parent.index');
    }

    public function register_get()
    {
        return view('back/register');
    }

    public function register_post(Request $request)
    {
        $request->validate([
            'TheName1' => 'required',
            'TheName2' => 'required',
            'TheName3' => 'required',
            'TheEmail' => 'unique:tbl_parents,TheEmail',
            'ThePass' => 'required|min:5',
            'confirm_password' => 'required|same:ThePass',
            'NatID' => 'required',
            'CityID' => 'required',
            'ThePhone1' => 'required|unique:tbl_parents,ThePhone1|different:ThePhone2',
            'ThePhone2' => 'required|unique:tbl_parents,ThePhone2|different:ThePhone1',
            'roles' => 'required',
         ],
         [
             'TheName1.required' => 'الإسم الأول مطلوب',
             'TheName2.required' => 'الإسم الثاني مطلوب',
             'TheName3.required' => 'الإسم الثالث مطلوب',
             'TheEmail.unique' => 'البريد الإلكتروني مستخدم من قبل',
             'ThePass.required' => 'الرقم السري مطلوب',
             'ThePass.min' => 'يجب أن يكون طول نص الرقم السري على الأقل 5 حروفٍ/حرفًا',
             'confirm_password.required' => 'تأكيد الرقم السري مطلوب',
             'confirm_password.same' => 'يجب أن يطابق تأكيد الرقم السري مع الرقم السري',
             'ThePhone1.required' => 'رقم التلفون الأول مطلوب',
             'ThePhone2.required' => 'رقم التلفون الثاني مطلوب',
             'ThePhone1.unique' => 'رقم التلفون الأول مستخدم من قبل',
             'ThePhone2.unique' => 'رقم التلفون الثاني مستخدم من قبل',
             'ThePhone1.different' => 'يجب أن يكون حقل التلفون الأول والثاني مختلفين',
             'ThePhone2.different' => 'يجب أن يكون حقل التلفون الأول والثاني مختلفين',
             'roles.required' => 'يجب الموافقه علي على سياسية إديوستيدج أكاديمي',
        ]);
 
        Parents::create([
            'TheDate1' => date('Y-m-d'),
            'TheCode' => '',
            'TheNotes' => '',
            'TheStatus' => '',
            'TheNotes' => '',
            'TheName1' => request('TheName1'),
            'TheName2' => request('TheName2'),
            'TheName3' => request('TheName3'),
            'TheName0' => request('TheName1').' '.request('TheName2').' '.request('TheName3'),
            'TheEmail' => request('TheEmail'),
            'ThePass' => Hash::make(request('ThePass')),
            'NatID' => request('NatID'),
            'CityID' => request('CityID'),
            'ThePhone1' => request('ThePhone1'),
            'ThePhone2' => request('ThePhone2'),
        ]);
         
        User::create([
            'name' => request('TheName1').' '.request('TheName2').' '.request('TheName3'),
            'email' => request('TheEmail'),
            'password' => Hash::make(request('ThePass')),
            'user_status' => 2,
        ]);

    }

    public function edit($id)
    {
        $find = Parents::where('ID', $id)->first();
        return view('back.parent.edit', compact('find'));        
    }

    public function update(Request $request, $id)
    {
        $find = Parents::where('ID', $id)->first();
        $findUser = User::where('id', $id)->first();
    
        $request->validate([
            'TheName1' => 'required',
            'TheName2' => 'required',
            'TheName3' => 'required',
            'TheEmail' => 'unique:users,email, '.$id,
            // 'ThePass' => 'required|min:5',
            'confirm_password' => 'same:ThePass',
            'NatID' => 'required',
            'CityID' => 'required',
            'ThePhone1' => 'different:ThePhone2|required|unique:tbl_parents,ThePhone1, '.$id,
            'ThePhone2' => 'different:ThePhone1|required|unique:tbl_parents,ThePhone2, '.$id,
         ],
         [
            'TheName1.required' => 'الإسم الأول مطلوب',
            'TheName2.required' => 'الإسم الثاني مطلوب',
            'TheName3.required' => 'الإسم الثالث مطلوب',
            'TheEmail.unique' => 'البريد الإلكتروني مستخدم من قبل',
            'ThePass.required' => 'الرقم السري مطلوب',
            'ThePass.min' => 'يجب أن يكون طول نص الرقم السري على الأقل 5 حروفٍ/حرفًا',
            'confirm_password.required' => 'تأكيد الرقم السري مطلوب',
            'confirm_password.same' => 'يجب أن يطابق تأكيد الرقم السري مع الرقم السري',
            'ThePhone1.required' => 'رقم التليفون الأول مطلوب',
            'ThePhone2.required' => 'رقم التليفون الثاني مطلوب',
            'ThePhone1.unique' => 'رقم التليفون الأول مستخدم من قبل',
            'ThePhone2.unique' => 'رقم التليفون الثاني مستخدم من قبل',
            'ThePhone1.different' => 'يجب أن يكون حقل التليفون الأول والثاني مختلفين',
            'ThePhone2.different' => 'يجب أن يكون حقل التليفون الأول والثاني مختلفين',
            'roles.required' => 'يجب الموافقه على سياسية إديوستيدج أكاديمي',
         ]);
 
         Parents::where('ID', $id)->update([
             'TheDate1' => $find['TheDate1'],
             'TheCode' => '',
             'TheNotes' => '',
             'TheStatus' => request('TheStatus'),
             'TheStatusDate' => date('Y-m-d'),
             'TheNotes' => '',
             'TheName1' => request('TheName1'),
             'TheName2' => request('TheName2'),
             'TheName3' => request('TheName3'),
             'TheName0' => request('TheName1').' '.request('TheName2').' '.request('TheName3'),
             'TheEmail' => $findUser['email'],
             'ThePass' => request('ThePass') == null ? $findUser['password'] : Hash::make(request('ThePass')),
             'NatID' => request('NatID'),
             'CityID' => request('CityID'),
             'ThePhone1' => request('ThePhone1'),
             'ThePhone2' => request('ThePhone2'),
         ]);
         
         User::where('name', $find['TheName0'])->update([
             'name' => request('TheName1').' '.request('TheName2').' '.request('TheName3'),
             'email' => $findUser['email'],
             'password' =>  request('ThePass') == null ? $findUser['password'] : Hash::make(request('ThePass')),
             'user_status' => 3,
             'email_verified_at' => date('Y-m-d h:i:s'),
         ]);

        auth()->logout();
    }
    
    public function destroy($id)
    {
        $find = Parents::where('ID', $id)->first();
        Parents::where('ID', $id)->delete();
        User::where('name', $find['TheName0'])->delete();
        
    }

    public function datatable_parents()
    {
        if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){
            $all = Parents::all();
            return DataTables::of($all)
            ->addColumn('name', function($d){
                $name = $d->TheName0;
                return $name;
            })
            ->addColumn('email', function($d){
                $email = $d->TheEmail;
                return $email;
            })
            ->addColumn('phone', function($d){
                $phone = $d->ThePhone1;
                return $phone;
            })
            ->addColumn('phone2', function($d){
                $phone2 = $d->ThePhone2;
                return $phone2;
            })
            ->addColumn('nat_id', function($d){
                $nat_id = $d->nationality_name['TheName'];
                return $nat_id;
            })
            ->addColumn('city_id', function($d){
                $city_id = $d->city_name['TheCity'];
                return $city_id;
            })
            ->addColumn('created_at', function($d){
                return $d->TheDate1;
            })
            ->addColumn('action', function($d){
                $buttons = '<a res_id="'.$d->ID.'" class="text-muted option-dots2" href="'.url('dashboard/parents/edit/'.$d->ID).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                $buttons .= '<a res_id="'.$d->ID.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';
                
                return $buttons;
            })
            ->rawColumns(['name', 'email', 'nat_id', 'city_id', 'phone', 'phone2', 'created_at', 'action'])
            ->make(true);
        }elseif(auth()->user()->user_status == 3){
            $all = Parents::where('TheName0', auth()->user()->name)->get();
            return DataTables::of($all)
            ->addColumn('name', function($d){
                $name = $d->TheName0;
                return $name;
            })
            ->addColumn('email', function($d){
                $email = $d->TheEmail;
                return $email;
            })
            ->addColumn('phone', function($d){
                $phone = $d->ThePhone1;
                return $phone;
            })
            ->addColumn('phone2', function($d){
                $phone2 = $d->ThePhone2;
                return $phone2;
            })
            ->addColumn('nat_id', function($d){
                $nat_id = $d->nationality_name['TheName'];
                return $nat_id;
            })
            ->addColumn('city_id', function($d){
                $city_id = $d->city_name['TheCity'];
                return $city_id;
            })
            ->addColumn('created_at', function($d){
                return $d->TheDate1;
            })
            ->addColumn('action', function($d){
                $buttons = '<a res_id="'.$d->ID.'" class="text-muted option-dots2" href="'.url('dashboard/parents/edit/'.$d->ID).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';                
                return $buttons;
            })
            ->rawColumns(['name', 'email', 'nat_id', 'city_id', 'phone', 'phone2', 'created_at', 'action'])
            ->make(true);
        }
    }
}