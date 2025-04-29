<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Input;
use App\Models\ParentsPayment;
use App\Models\Parents;
use DB;
use Hash;
use File;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

class ParentsPaymentController extends Controller
{

    public function index()
    {
        return view('back.parents_payments.index');
    }

    public function create()
    {        
        $parents = Parents::all();
        return view('back/parents_payments/add', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
           'TheDate' => 'required',
           'amount_by_currency' => 'required',
           'ThePayType' => 'required',
           'currency' => 'required',
        ],[
            'TheDate.required' => 'التاريخ مطلوب',
            'amount_by_currency.required' => 'المبلغ مطلوب',
            'ThePayType.required' => 'طريقه الدفع مطلوبه',
            'currency.required' => 'العمله مطلوبه',
        ]);

        $file = request('file');
        if(request('file') == null){
            $file_name = 'df_image.png';
        }elseif($file->getClientOriginalExtension() === 'jpg' || $file->getClientOriginalExtension() === 'png'){
            $file_name = time().'.'.$file->getClientOriginalExtension();
            $img = Image::make($file);
            $img->resize(700, 500);
            $img->save(public_path('back/images/parents_payments/'.$file_name));
        }else{
            $file_name = time() . '.' .$file->getClientOriginalExtension();
            $path = public_path('back/images/parents_payments');
            $file->move($path , $file_name);
            
        }

        if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){
            ParentsPayment::create([
                'TheDate' => request('TheDate'),
                'ParentID' => request('ParentID'),
                'TheAmount' => 0,
                'amount_by_currency' => request('amount_by_currency'),
                'ThePayType' => request('ThePayType'),
                'currency' => request('currency'),
                'TheNotes' => request('TheNotes') == null ? ' ' : request('TheNotes'),
                'image' => $file_name,
                'invoice_number' => request('invoice_number'),
                'sender_name' => request('sender_name'),
            ]);
        }elseif(auth()->user()->user_status == 3){
            ParentsPayment::create([
                'TheDate' => request('TheDate'),
                'ParentID' => auth()->user()->id,
                'TheAmount' => 0,
                'amount_by_currency' => request('amount_by_currency'),
                'ThePayType' => request('ThePayType'),
                'currency' => request('currency'),
                'TheNotes' => request('TheNotes') == null ? ' ' : request('TheNotes'),
                'image' => $file_name,
                'invoice_number' => request('invoice_number'),
                'sender_name' => request('sender_name'),
            ]);
        }

    }

    public function show(students $students)
    {
        //
    }

    public function edit($id)
    {
        $find = ParentsPayment::where('id', $id)->first();
        $parents = Parents::all();
        return view('back/parents_payments/edit', compact('find', 'parents'));
    }

    public function update(Request $request, $id)
    {   
        $find = ParentsPayment::where('ID', $id)->first();

        $request->validate([
            'TheDate' => 'required',
            'amount_by_currency' => 'required',
            'ThePayType' => 'required',
            'currency' => 'required',
         ],[
             'TheDate.required' => 'التاريخ مطلوب',
             'amount_by_currency.required' => 'المبلغ مطلوب',
             'ThePayType.required' => 'طريقه الدفع مطلوبه',
             'currency.required' => 'العمله مطلوبه',
         ]);
 
        $file = request('file');
        if(request('file') == null){
            $file_name = request('default_file');
        }elseif($file->getClientOriginalExtension() === 'jpg' || $file->getClientOriginalExtension() === 'png'){
            $file_name = time().'.'.$file->getClientOriginalExtension();
            $img = Image::make($file);
            $img->resize(700, 500);
            $img->save(public_path('back/images/parents_payments/'.$file_name));

            if($find['image'] != 'df_image.png'){
                File::delete(public_path('back/images/parents_payments/'.$find['image'])); 
            }
        }else{
            $file_name = time() . '.' .$file->getClientOriginalExtension();
            $path = public_path('back/images/parents_payments');
            $file->move($path , $file_name);

            if($find['image'] != 'df_image.png'){
                File::delete(public_path('back/images/parents_payments/'.$find['image'])); 
            }
        }

        if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){
            ParentsPayment::where('ID', $id)->update([
                'TheDate' => request('TheDate'),
                'ParentID' => request('ParentID'),
                'TheAmount' => request('TheAmount'),
                'TheNotes' => request('TheNotes') == null ? ' ' : request('TheNotes'),
                'ThePayType' => request('ThePayType'),
                'currency' => request('currency'),
                'amount_by_currency' => request('amount_by_currency'),
                'image' => $file_name,
                'invoice_number' => request('invoice_number'),
                'sender_name' => request('sender_name'),
                'expense_price' => request('expense_price'),
                'transfer_expense' => request('transfer_expense'),
                'admin_notes' => request('admin_notes'),
                'status' => request('status'),
            ]);

        }elseif(auth()->user()->user_status == 3){
            ParentsPayment::where('ID', $id)->update([
                'TheDate' => request('TheDate'),
                'ParentID' => auth()->user()->id,
                'TheAmount' => 0,
                'amount_by_currency' => request('amount_by_currency'),
                'ThePayType' => request('ThePayType'),
                'currency' => request('currency'),
                'TheNotes' => request('TheNotes') == null ? ' ' : request('TheNotes'),
                'image' => $file_name,
                'invoice_number' => request('invoice_number'),
                'sender_name' => request('sender_name'),
            ]);
        }

   }

    public function destroy($id)
    {
        $find = ParentsPayment::where('ID', $id)->first();
        ParentsPayment::where('ID', $id)->delete();
        
        if($find['image'] != 'df_image.png'){
            File::delete(public_path('back/images/parents_payments/'.$find['image'])); 
        }
    }


    public function datatable_parents_payments()
    {
        if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){
            $all = ParentsPayment::all();
            return DataTables::of($all)
            ->addColumn('date', function($d){
                $date = $d->TheDate;
                return $date;
            })
            ->addColumn('name', function($d){
                $name = $d->parent_name['name'];
                return $name;
            })
            ->addColumn('amount_by_currency', function($d){
                $amount_by_currency = '<span style="color: red;font-weight: bold;">'.$d->amount_by_currency.'</span>';
                return $amount_by_currency;
            })
            ->addColumn('transfer_expense', function($d){
                $transfer_expense = $d->transfer_expense;
                return "<span style='font-weight: bold;font-size: 17px;text-decoration: underline;'>".$transfer_expense."</span>";
            })
            ->addColumn('amount', function($d){
                $amount = '<span style="color: red;font-weight: bold;">'.$d->TheAmount.'</span>';
                return $amount;
            })
            ->addColumn('pay_type', function($d){
                $pay_type = $d->ThePayType;
                return $pay_type;
            })
            ->addColumn('image', function($d){
                if(strpos($d->image , '.jpg') || strpos($d->image , '.png') || strpos($d->image , '.jpeg') || strpos($d->image , '.gif')){
                    $image = '
                            <a class="spotlight" href="'.url('back/images/parents_payments/'.$d->image).'">
                                <img src="'.url('back/images/parents_payments/'.$d->image).'" style="width:50px;height:50px;border-radius:50%;">
                            </a>
                        ';
                return $image;

                }elseif(strpos($d->image , '.pdf')){
                    $image = '
                            <a href="'.url('back/images/parents_payments/'.$d->image).'" download>
                                <i class="fas fa-file-pdf" style="width:50px;height:50px;border-radius:50%;border: 1px solid red;text-align: center;line-height: 50px;font-size: 25px;"></i>
                            </a>
                        ';
                    return $image;
                }elseif(strpos($d->image , '.xlsx')){
                    $image = '
                            <a href="'.url('back/images/parents_payments/'.$d->image).'" download>
                                <i class="fas fa-file-excel" style="width:50px;height:50px;border-radius:50%;border: 1px solid red;text-align: center;line-height: 50px;font-size: 25px;"></i>
                            </a>
                        ';
                    return $image;
                }elseif(strpos($d->image , '.docx')){
                    $image = '
                            <a href="'.url('back/images/parents_payments/'.$d->image).'" download>
                                <i class="fa fa-file-word" aria-hidden="true" style="width:50px;height:50px;border-radius:50%;border: 1px solid red;text-align: center;line-height: 50px;font-size: 25px;"></i>
                            </a>
                        ';
                    return $image;
                }elseif(strpos($d->image , '.txt')){
                    $image = '
                            <a href="'.url('back/images/parents_payments/'.$d->image).'" download>
                                <i class="fas fa-text" style="width:50px;height:50px;border-radius:50%;border: 1px solid red;text-align: center;line-height: 50px;font-size: 25px;"></i>
                            </a>
                        ';
                    return $image;
                }else{
                    $image = '
                            <a href="'.url('back/images/parents_payments/'.$d->image).'" download>
                                <i class="fa fa-file" style="width:50px;height:50px;border-radius:50%;border: 1px solid red;text-align: center;line-height: 50px;font-size: 25px;"></i>
                            </a>
                        ';
                    return $image;
                }
            })
            ->addColumn('status', function($d){
                if($d->status == 'غير مؤكد'){
                    return '<span class="badge badge-danger">غير مؤكد</span>';
                }elseif($d->status == 'مؤكد'){
                    return '<span class="badge badge-primary">مؤكد</span>';
                }
            })
            ->addColumn('action', function($d){
                $buttons = '<a res_id="'.$d->id.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/parents_payments/edit/'.$d->ID).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                $buttons .= '<a res_id="'.$d->ID.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';
                
                return $buttons;
            })
            ->rawColumns(['date', 'name', 'amount_by_currency', 'transfer_expense', 'amount', 'pay_type', 'image', 'status', 'action'])
            ->make(true);
        
        }elseif(auth()->user()->user_status == 3){
            $curr_year = date('Y');
            $next_year = $curr_year+1;

            $all = ParentsPayment::leftjoin('users', 'users.id', '=', 'tbl_parents_payments.ParentID')
                                    ->where('tbl_parents_payments.ParentID', '=', auth()->user()->id)
                                    ->whereBetween('tbl_parents_payments.TheDate', [date('Y-09-01'), date($next_year.'-'.'08-31')])  
                                    ->get();
            return DataTables::of($all)
            ->addColumn('date', function($d){
                $date = $d->TheDate;
                return $date;
            })
            ->addColumn('name', function($d){
                $name = $d->parent_name['name'];
                return $name;
            })
            ->addColumn('amount_by_currency', function($d){
                $amount_by_currency = '<span style="color: red;font-weight: bold;">'.$d->amount_by_currency.'</span>';
                return $amount_by_currency;
            })
            // ->addColumn('expense_price', function($d){
            //     $expense_price = $d->expense_price;
            //     return $expense_price;
            // })
            ->addColumn('transfer_expense', function($d){
                $transfer_expense = $d->transfer_expense;
                return "<span style='font-weight: bold;font-size: 17px;text-decoration: underline;'>".$transfer_expense."</span>";
            })
            ->addColumn('amount', function($d){
                $amount = '<span style="color: red;font-weight: bold;">'.$d->TheAmount.'</span>';
                return $amount;
            })
            ->addColumn('pay_type', function($d){
                $pay_type = $d->ThePayType;
                return $pay_type;
            })
            ->addColumn('image', function($d){
                if(strpos($d->image , '.jpg') || strpos($d->image , '.png') || strpos($d->image , '.jpeg') || strpos($d->image , '.gif')){
                    $image = '
                            <a class="spotlight" href="'.url('back/images/parents_payments/'.$d->image).'">
                                <img src="'.url('back/images/parents_payments/'.$d->image).'" style="width:50px;height:50px;border-radius:50%;">
                            </a>
                        ';
                return $image;

                }elseif(strpos($d->image , '.pdf')){
                    $image = '
                            <a href="'.url('back/images/parents_payments/'.$d->image).'" download>
                                <i class="fas fa-file-pdf" style="width:50px;height:50px;border-radius:50%;border: 1px solid red;text-align: center;line-height: 50px;font-size: 25px;"></i>
                            </a>
                        ';
                    return $image;
                }elseif(strpos($d->image , '.xlsx')){
                    $image = '
                            <a href="'.url('back/images/parents_payments/'.$d->image).'" download>
                                <i class="fas fa-file-excel" style="width:50px;height:50px;border-radius:50%;border: 1px solid red;text-align: center;line-height: 50px;font-size: 25px;"></i>
                            </a>
                        ';
                    return $image;
                }elseif(strpos($d->image , '.docx')){
                    $image = '
                            <a href="'.url('back/images/parents_payments/'.$d->image).'" download>
                                <i class="fa fa-file-word" aria-hidden="true" style="width:50px;height:50px;border-radius:50%;border: 1px solid red;text-align: center;line-height: 50px;font-size: 25px;"></i>
                            </a>
                        ';
                    return $image;
                }elseif(strpos($d->image , '.txt')){
                    $image = '
                            <a href="'.url('back/images/parents_payments/'.$d->image).'" download>
                                <i class="fas fa-text" style="width:50px;height:50px;border-radius:50%;border: 1px solid red;text-align: center;line-height: 50px;font-size: 25px;"></i>
                            </a>
                        ';
                    return $image;
                }
                
            })
            ->addColumn('status', function($d){
                if($d->status == 'غير مؤكد'){
                    return '<span class="badge badge-danger">غير مؤكد</span>';
                }elseif($d->status == 'مؤكد'){
                    return '<span class="badge badge-primary">مؤكد</span>';
                }
            })
            ->addColumn('action', function($d){
                if($d->status == 'غير مؤكد'){
                    $buttons = '<a res_id="'.$d->ID.'" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/parents_payments/edit/'.$d->ID).'" style="display: inline;margin: 0px 5px;"><i class="fa fa-pen"></i></a>';

                    $buttons .= '<a res_id="'.$d->ID.'" class="text-muted option-dots2 delete" style="display: inline;margin: 0px 5px;" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';
                    
                    return $buttons;
                }elseif($d->status == 'مؤكد'){
                    return '-';
                }

                
            })
            ->rawColumns(['date', 'name', 'amount_by_currency', 'transfer_expense', 'amount', 'pay_type', 'image', 'status', 'action'])
            ->make(true);
        } // end else if
    } // end datatable_parents_payments
}