<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;
use Illuminate\Http\Response;

class SizesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = Size::orderby('created_at', 'DESC')->get();
        return view('sizes.index', compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sizes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //form validation
        $this->validate($request, [
            'size'  =>  'required|min:1|max:50|unique:sizes'
        ]);

        $size = new Size();
        $size->size = $request->size;
        $size->save();

        flash('Size Created Successfully')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $size = Size::findOrFail($id);
        return view('sizes.edit', compact('size'));
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
        //form validation
        $this->validate($request, [
            'size'  =>  'required|min:1|max:50|unique:sizes,size,' . $id
        ]);

        $size = Size::findOrFail($id);

        $size->size = $request->size;
        $size->save();

        flash('Size Updated Successfully')->success();
        return redirect()->route('sizes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        flash('Size Deleted Successfully')->success();
        return redirect()->route('sizes.index');
    }

    //Handle AJAX request
    public function getSizesJson(){
        $sizes = Size::all();

        return response()->json([
            'success' => true,
            'data' => $sizes
        ], Response::HTTP_OK);
    }
}
