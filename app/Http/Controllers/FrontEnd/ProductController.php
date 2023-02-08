<?php

namespace App\Http\Controllers\FrontEnd;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->page = 8;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title_name = 'All Product';
        $check_cate = 'all';
        $all_product = Product::where('product_status',1)->orderBy('product_id','desc')->paginate($this->page);
        $category = Category::where('category_status',1)->limit(4)->get();
        return view('FrontEnd.all_product', compact('title_name','all_product','category','check_cate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()){
            if(request()->id_cate == 'all'){
                $check_cate = 'all';
                $all_product = Product::where('product_status',1)->orderBy('product_id','desc')->paginate($this->page);
            }else{
                $check_cate = request()->id_cate;
                $all_product = Product::where('product_status',1)
                                        ->where('category_id',$check_cate)
                                        ->orderBy('product_id','desc')
                                        ->paginate($this->page);
            }

            return view('FrontEnd.all_include',compact('all_product','check_cate'))->render();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(request()->ajax()){
            if($id == 'all'){
                $all_product = Product::where('product_status',1)
                                        ->orderBy('product_id','desc')
                                        ->paginate($this->page);
                $check_cate = $id;
            }else{
                $all_product = Product::where('product_status',1)
                                        ->where('category_id',$id)
                                        ->orderBy('product_id','desc')
                                        ->paginate($this->page);
                $check_cate = $id;
            }

            return view('FrontEnd.all_include',compact('all_product','check_cate'));
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
