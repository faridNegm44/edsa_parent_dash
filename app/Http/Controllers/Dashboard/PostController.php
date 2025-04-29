<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\ImageManagerStatic as Image;
use PDF;

class PostController extends Controller
{

    public function index()
    {
        // $path = public_path('back/images/posts/1617791685fery.jpg');
        // $manager = Image::configure(array('driver' => 'imagick'));
 
        // $img = Image::make($path);
        // $img->opacity(0);
        
        // return $image;
        


        $pdf = app()->make('snappy.pdf.wrapper');
        $pdf = PDF::loadView('invoice');
        return $pdf->download('invoice.pdf');

        // return view('back.post.index');
    }

    public function datatable_posts()
    {
        $all = Post::with('tags_name')->get();
        return DataTables::of($all)
        ->addColumn('id', function($res){
            $id = $res->id;
            return $id;
        })
        ->addColumn('address', function($res){
            $address = $res->address;
            return $address;
        })
        ->addColumn('description', function($res){
            $description = $res->description;
            return $description;
        })
        ->addColumn('tags', function($res){
            $tags = unserialize($res->tags);
            return $tags;
        })
        ->addColumn('image', function($res){
            $image = $res->image;
            return $image;
        })
        ->addColumn('created_at', function($res){
            return $res->created_at;
        })
        ->addColumn('action', function($res){
            $buttons = '<a data-effect="effect-scale" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/posts/get_edit_form/'.$res->id).'"><i class="fa fa-pen"></i></a>';

            $buttons .= '<a res_id="'.$res->id.'" class="text-muted option-dots2" id="delete" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';

            $buttons .= '<a data-effect="effect-scale" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/posts/get_view_form/'.$res->id).'" id="view" ><i class="fa fa-eye" style="color: #65bf37;"></i></a>';
            
            return $buttons;
        })
        ->rawColumns(['id', 'name', 'created_at', 'action'])
        ->make(true);
    }

    public function get_add_form()
    {
        $tags = Tag::all();
        return view('back.post.add_form', compact('tags'));
    }

    public function get_edit_form($id)
    {
        $find = post::where('id', $id)->first();
        return view('back.post.edit_form', compact('find'));
    }

    public function get_view_form($id)
    {
        $find = post::where('id', $id)->first();
        return view('back.post.view_form', compact('find'));
    }

    public function store(Request $request)
    {
        // dd(json_encode($request->tags));

        $request->validate([
           'address' => 'required|min:5' ,
           'description' => 'required' ,
           'tags' => 'required' ,
        ]);

        if(request('file') == null){
            $file = 'df_image.png';
        }else{
            $file = request('file');
            $file_name = time().$file->getClientOriginalName();
            $path = public_path('back/images/posts');
            $file->move($path, $file_name);
        }

        // $tags = [];
        // for ($i = 0; $i < count($request->tags); $i++) {
        //     $tags[] = [
        //         'day' => $request->day[$i],
        //         'from' => $request->from[$i],
        //         'to' => $request->to[$i]
        //     ];
        // }


        // foreach ($request->tags as $key => $tags) {
        //     post::create([
        //         'address' => request('address'),
        //         'description' => request('description'),
        //         'image' => $file_name,
        //         'tags' => $request->tags[$key],
        //     ]);        
        // }

        
        post::create([
            'address' => request('address'),
            'description' => request('description'),
            'tags' => serialize(request('tags')),
            'image' => $file_name,
        ]);

    }

    public function show(posts $posts)
    {
        //
    }

    public function edit(posts $posts)
    {
        //
    }

    public function update(Request $request, $id)
    {   
        $find = post::where('id', $id)->first();

        $request->validate([
            'name' => 'required|unique:posts,name,'.$id
        ]);
        
        $find->update([
            'name' => request('name'),
        ]);
   }

    public function destroy($id)
    {
        dd('ss');
    }
}
