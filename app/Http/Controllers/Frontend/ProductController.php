<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Product;


class ProductController extends Controller
{
    public function show(){
        $product=Product::all();
        return view('frontend.home',compact('product'));
    }
    public function details($id){
        $product=Product::find($id);
        return view('frontend.details',compact('product'));
    }
    
}
