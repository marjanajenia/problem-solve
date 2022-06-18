<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Product;
use Image;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=Product::orderby('id','asc')->get();
        return view('backend.manageproduct',compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend/addproduct');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([           
            'name'=>'required',
            'category_name'=>'required',
            'brand_name'=>'required',
            'description'=>'required',
            'image'=>'required',
            'status'=>'required',            
        ]);
        
        $product= new Product();
        $product->name=$request->name;
        $product->category_name=$request->category_name;
        $product->brand_name=$request->brand_name;
        $product->description=$request->description;
        $product->image=$request->image;
        $product->status=$request->status;
        if($request->image){
            $image=$request->file('image');
            $imageCustomName=rand().'.'.$image->getClientOriginalExtension();
            $location=public_path('backend/images/'.$imageCustomName);
            Image::make($image)->save($location);
            $product->image=$imageCustomName;
        }
        $product->save();
        return redirect()->route('dashboard');  
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
        $product=Product::find($id);       
        return view('backend.editproduct', compact('product'));
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
        $product=Product::find($id);
        $product->id= $request->id;
        $product->name= $request->name;
        $product->category_name= $request->category_name;
        $product->brand_name = $request->brand_name;
        $product->description = $request->description;
        $product->status= $request->status;

        if(!empty($request->image)){
            if(File::exists('backend/images/'.$product->image)){
                File::delete('backend/images/'.$product->image);
            }
            $image=$request->file('image');
            $imageCustomName=rand().'.'.$image->getClientOriginalExtension();
            $location=public_path('backend/images/'.$imageCustomName);
            Image::make($image)->save($location);
            $product->image=$imageCustomName;                
        }     
        $product->update();
        return redirect()->route('manage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::find($id);
        $product->delete();
        return redirect()->route('manage');
    }
}
