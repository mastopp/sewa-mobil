<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsCategory;

class MsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = '';
        if (!empty($request)) {
            $keyword .= $request->keyword;
            
        }
        $select = [
            'id',
            'name'
        ];
            
        $data = MsCategory::select($select)
        ->where('name','like',"%".$keyword."%")
        ->orderBy('name', 'ASC')
        ->paginate(10)
        ->appends(request()->query());        
        
        // dd($data);
        return view('admin.mscategory.index', [
            'title' => 'Category List',
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.mscategory.create', [
            'title' => 'New Category',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3'
        ]);
        try {
            $store = MsCategory::create([
                'name' => $request->name
            ]);
            return redirect('admin/mscategory')->with('success', 'Saved Successfully!'); 
            
        } catch (Exception $e) {
            return back()->with('error', 'Oh snap! Please check your input.'.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = MsCategory::findOrFail($id);
        // dd($data);
        return view('admin.mscategory.show', [
            'title' => 'Edit Category',
            'data'  => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3'
        ]);
        // dd($request);
        try {
            $store = MsCategory::where('id', $request->id)
            ->update([
                'name' => $request->name
            ]);
            return redirect('admin/mscategory')->with('success', 'Updated Successfully!'); 
            
        } catch (Exception $e) {
            return back()->with('error', 'Oh snap! Please check your input.'.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = MsCategory::findOrFail($id);
        $data->delete();
        if ($data) {
            return redirect('admin/mscategory')->with('success', 'Deleted Successfully!');
        } else {
            return redirect('admin/mscategory')->with('error', 'Oh snap. Data cannot deleted!');
        }
        
    }
}
