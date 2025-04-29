<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Tag;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{

    public function index()
    {
        return view('back.tag.index');
    }

    // public function get_all_tags_datatable()
    // {
    //     $tags = Tag::select(['id', 'name']);

    //     return Datatables::of($tags)->make();
    // }

    public function datatable_tags()
    {
        $all = Tag::all();
        return DataTables::of($all)
        ->addColumn('id', function($d){
            $id = $d->id;
            return $id;
        })
        ->addColumn('name', function($d){
            $name = $d->name;
            return $name;
        })
        ->addColumn('created_at', function($res){
            return $res->created_at;
        })
        ->addColumn('action', function($res){
            $buttons = '<a data-effect="effect-scale" data-toggle="modal" href="#modaldemo8" class="text-muted option-dots2 modal-effect bt_modal" act="'.url('dashboard/tags/get_edit_form/'.$res->id).'"><i class="fa fa-pen"></i></a>';

            $buttons .= '<a res_id="'.$res->id.'" class="text-muted option-dots2" id="delete" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>';
            
            return $buttons;
        })
        ->rawColumns(['id', 'name', 'created_at', 'action'])
        ->make(true);
    }

    public function get_add_form()
    {
        return view('back.tag.add_form');
    }

    public function get_edit_form($id)
    {
        $find = Tag::where('id', $id)->first();
        return view('back.tag.edit_form', compact('find'));
    }

    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required|unique:tags,name' 
        ]);

        Tag::create([
            'name' => request('name'),
        ]);

    }

    public function show(Tags $tags)
    {
        //
    }

    public function edit(Tags $tags)
    {
        //
    }

    public function update(Request $request, $id)
    {   
        $find = Tag::where('id', $id)->first();

        $request->validate([
            'name' => 'required|unique:tags,name,'.$id
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
